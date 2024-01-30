<?php

// Start Session
session_start();

// Constants
define("SITE_URL" , "https://food-order-app.test/");
define('LOCALHOST', "localhost");
define('DB_USERNAME', "root");
define('DB_PASS', "1234");
define('DB_NAME', "food-order");


// Connect To DataBase
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASS, DB_NAME) or die(mysqli_error($conn));


?>