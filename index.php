<?php
session_start();
@require("./configs/config.php");
@require("./models/model.logger.php");
@require("./models/model.response.php");
@require("./models/model.user.php");
@require("./functions.php");

$wcsj = new WCSJ();
$method = $_SERVER['REQUEST_METHOD'];
$url = "http://localhost:1004/api/test"; //"https://app.etsdelespoir.com";
$user = new User($wcsj);

if (ucwords($method) === "POST") {
    if (isset($_GET['_cb']) && ($_GET['_cb']) !== null) {
        $cb = $_GET['_cb'] ?? "";
        switch ($cb) {
            case 'login':
                if (isset($_POST['username']) && isset($_POST['password'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
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
