<?php
session_start();
@require("./configs/config.php");
@require("./models/model.logger.php");
@require("./models/model.response.php");
@require("./models/model.user.php");

$wcsj = new WCSJ();
$method = $_SERVER['REQUEST_METHOD'];
$headers = isset($_SERVER['HTTP_X_CONNEXION_WCSJ_MOBILE']) ? ($_SERVER['HTTP_X_CONNEXION_WCSJ_MOBILE']) : null;

if ($headers !== null && $headers === authorization) {
    if (ucwords($method) === "POST") {
        if (isset($_GET['_cb']) && ($_GET['_cb']) !== null) {
            $cb = $_GET['_cb'] ?? "";
            switch ($cb) {
                case 'login':
                    if (isset($_POST['username']) && isset($_POST['password'])) {

                        $user = new User();

                        $username = $_POST['username'];
                        $password = $_POST['password'];

                        $user = $user->onAuthentification($username, $password, $wcsj);
                        if ($user !== null) {
                            $res = new Response(200, $user);
                            echo ($res->print());
                        } else {
                            $res = new Response(403, "Password or username is incorrect !");
                            echo ($res->print());
                        }
                    } else {
                        $res = new Response(205, "This request must have at least username, or password !");
                        echo ($res->print());
                    }
                    break;

                default:
                    $res = new Response(405, "This methode used is not allowed or key cb ::: $method $cb");
                    echo ($res->print());
                    break;
            }
        }
    } else {
        $res = new Response(405, "This methode used is not allowed ::: $method");
        echo ($res->print());
    }
} else {
    $res = new Response(401, $headers);
    echo ($res->print());
}
