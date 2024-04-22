<?php 
@require("./configs/config.php");
@require("./models/model.logger.php");
@require("./models/model.response.php");
@require("./models/model.user.php");
@require("./functions.php");

$wcsj = new WCSJ();
$method = $_SERVER['REQUEST_METHOD'];

$user = new User($wcsj);
var_dump($user);

