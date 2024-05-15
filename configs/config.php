<?php
$customer_dbname = "__bd__wcsj"; // 
$customer_dialect = "mysql"; //
$customer_hostname = "localhost"; // 
$customer_username = "root"; //
$customer_password = ""; //
// ---------------------------------------------------------
// ---------------- offline connexion ----------------------
// ---------------------------------------------------------
// $customer_dbname = "etsdelespoir_hblitev321"; //
// $customer_dialect = "mysql"; // 
// $customer_hostname = "localhost"; // 
// $customer_username = "etsdelespoir_mobileuser"; // 
// $customer_password = 'S$rW}tosN%j{'; //
// ---------------------------------------------------------
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
