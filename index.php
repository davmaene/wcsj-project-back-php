<?php
session_start();
@require("./configs/config.php");
@require("./models/model.logger.php");
@require("./models/model.response.php");
@require("./models/model.user.php");
@require("./models/model.produits.php");
@require("./models/model.stock.php");
@require("./models/model.stockinput.php");
@require("./models/model.stockinputdepot.php");
@require("./models/model.approvisionnement.php");
@require("./models/model.stockinputdetails.php");
@require("./models/model.stockdetails.php");
@require("./models/model.facturepersonnalisee.php");
@require("./models/model.facturepersonnaliseitems.php");

$wcsj = new WCSJ();
$method = $_SERVER['REQUEST_METHOD'];
$headers = isset($_SERVER['HTTP_X_CONNEXION_WCSJ_MOBILE']) ? ($_SERVER['HTTP_X_CONNEXION_WCSJ_MOBILE']) : null;

if ($headers !== null && $headers === authorization) {
    if (ucwords($method) === "POST" || ucwords($method) === "GET") {
        if (isset($_GET['_cb']) && ($_GET['_cb']) !== null) {
            $cb = $_GET['_cb'] ?? "";
            switch ($cb) {
                case 'users':
                    $users = new User();

                    $users = $users->list($wcsj);
                    if ($users !== null) {
                        $res = new Response(200, array("length" => count($users), "rows" => $users));
                        echo ($res->print());
                    } else {
                        $res = new Response(403, "Password or username is incorrect !");
                        echo ($res->print());
                    }
                    break;
                case 'facturation':
                    $by = $_POST['createdby'] ?? null;
                    $pos = $_POST['pos'] ?? null;
                    $items = $_POST['items'] ?? null;
                    $queryArray = [];
                    parse_str($items, $queryArray);

                    foreach ($queryArray as $key => $value) {

                        $u = $value['user'] ?? $by;
                        $p = $value['pos'] ?? $pos;
                        $c = (($value['client'] === "Ordinary") ? 0 : 1) ?? null;
                        $d = date("Y-m-d", strtotime($value['crearedon'])) ?? date("YYYY-MM-DD");
                        $pc = !empty($value['pack']) && strlen($value['pack']) > 0 ? $value['pack'] : "Boite";
                        $qte = $value['qte'] ?? 0;
                        $prix = $value['prix'] ?? 0.0;
                        $item = $value['item'] ?? "";
                        $ref = $value['ref'] ?? "";

                        $fp = new Facturepersonnalisee(null, $u, $p, $c, $d);
                        $fp = $fp->create($wcsj);

                        if (is_numeric($fp)) {
                            $fpi = new Facturepersonnaliseeitems($fp, $item, $prix, $qte, $pc);
                            $fpi = $fpi->create($wcsj);
                        } else {
                            $res = new Response(500, array("message" => "This line was not saved ==> ", "length" => 1, "rows" => [$value]));
                            echo ($res->print());
                            return false;
                        }
                    }

                    $res = new Response(200, array("length" => count($queryArray), "rows" => $queryArray));
                    echo ($res->print());
                    break;
                case 'approvisionnement':

                    $by = $_POST['createdby'] ?? null;
                    $pos = isset($_POST['pos']) &&  $_POST['pos'] !== null &&  $_POST['pos'] !== "null" ? (int)  $_POST['pos'] : 1;
                    $date_approvisonnement = $_POST['date_approvisonnement'] ?? null;
                    $items = $_POST['items'] ?? null;

                    // $res = new Response(500, $_POST);
                    // echo ($res->print());
                    // return false;

                    $queryArray = [];
                    parse_str($items, $queryArray);

                    $items = $queryArray;

                    $approv = new Approvisionnements();
                    $approv = $approv->create($wcsj, $by, $pos, $items);
                    if (is_array($approv)) {
                        $res = new Response(200, array("length" => count($approv), "rows" => $approv));
                        echo ($res->print());
                    } else {
                        // "data" => $items
                        $exc = new LogNotification([Date('d/m/Y, H:i:s')], ["Approv: can not be proceded with approvisionnement, sorry try again letter !" . $approv], ['Failed'], []);
                        $wcsj->onLog($exc, 1);
                        $res = new Response(500, array("message" => "Approv: can not be proceded with approvisionnement, sorry try again letter !" . $approv, "data" => $items));
                        echo ($res->print());
                    }
                    break;
                case 'produits':
                    $produits = new Produits();
                    $id_pos = $_GET['id_pos'] ?? 0;
                    $produits = $produits->liste($id_pos, $wcsj);

                    $res = new Response(200, array("length" => count($produits), "rows" => $produits));
                    echo ($res->print());
                    break;
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
