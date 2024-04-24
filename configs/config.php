<?php
// customer enviroment infos goes here
// $customer_dbname = "__bd__wcsj"; // the name of your database
// $customer_dialect = "mysql"; // env database service cloud
// $customer_hostname = "localhost"; // name or ip of host
// $customer_username = "root"; // username to access to db
// $customer_password = ""; // password to access to db
// ---------------- ofline connexion ----------------------
$customer_dbname = "etsdelespoir_mobileuser";// || "__db_big"; // the name of your database
$customer_dialect = "mysql"; // env database service cloud
$customer_hostname = "localhost";// || "localhost"; // name or ip of host
$customer_username = "u0jrypzsb57uybno";// || "root"; // username to access to db
$customer_password = 'S$rW}tosN%j{';// || ""; // password to access to db
// ---------------------------------------------------------
// ---------------------------------------------------------
//          dont modify code beyond this line
// ---------------------------------------------------------
define("authorization", "Bearer $2a$10$9sGZJIxtRzABhoQkc.kyVegE7esOAlxa8C45/BKeAM4vep2NxiFj2");
define(
    "env", // environement
    array(
        "dialect" => $customer_dialect ?? "mysql",
        "dbname" => $customer_dbname ?? "test",
        "hostname" => $customer_hostname ?? "localhost",
        "username" => $customer_username ?? "root",
        "password" => $customer_password ?? ""
    )
);
