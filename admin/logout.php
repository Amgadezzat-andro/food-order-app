<?php
include("../config/constants.php");
// Destroy The Session 
session_destroy();
//  Go to Login Page
header("Location:" . $SITE_URL . "login.php")


?>