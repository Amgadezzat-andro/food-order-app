<?php

if (!isset($_SESSION['user'])) {

    $_SESSION['no-login-message'] = "<div class = 'error'>Login to Access this Page</div>";
    header('location:' . SITE_URL . "admin/login.php");

}
?>