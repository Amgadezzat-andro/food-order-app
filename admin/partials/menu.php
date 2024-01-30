<?php
include(dirname(__DIR__) . "/../config/constants.php");
include("login-check.php");
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <!-- Menu Section Starts -->
    <div class="menu text-center">
        <div class="wrapper">
            <ul>
                <li> <a href=<?php echo SITE_URL."admin/index.php"?>>Home</a> </li>
                <li> <a href=<?php echo SITE_URL."admin/manage-admin.php"?>>Admin</a> </li>
                <li> <a href=<?php echo SITE_URL."admin/manage-category.php"?>>Category</a> </li>
                <li> <a href=<?php echo SITE_URL."admin/manage-food.php"?>>Food</a> </li>
                <li> <a href=<?php echo SITE_URL."admin/manage-orders.php"?>>Orders</a> </li>
                <li> <a href=<?php echo SITE_URL."admin/logout.php"?>>Log Out</a> </li>
            </ul>
        </div>
    </div>
    <!-- Menu Section Ends -->