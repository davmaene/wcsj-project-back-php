<?php
@require("./configs/config.php");
@require("./models/model.logger.php");
@require("./models/model.response.php");
@require("./models/model.user.php");
@require("./functions.php");

$wcsj = new WCSJ();
$method = $_SERVER['REQUEST_METHOD'];
$url = "http://localhost:1004/api/test"; //"https://app.etsdelespoir.com";
$user = new User($wcsj);
// var_dump($user);
$postmethod = $wcsj->_httpPost("$url", array("username" => "", "password" => "p@sss", "verify" => (int)1));
echo (($postmethod));
