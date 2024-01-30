<?php
include("../config/constants.php");
include("partials/login-check.php");


// Get Id
if (isset($_GET['id']) and isset($_GET['image_name'])) {
    // GET ID & Image Name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];
    // Delete The Actual Image From Server
    if ($image_name != "") {
        $path = "../images/category_images/" . $image_name;
        $remove = unlink($path);
        if ($remove == false) {
            $_SESSION['error'] = "<div class='error' >Failed To  Delete This Category, Try Again !</div>";
            header("Location: " . SITE_URL . "admin/manage-category.php");
            die();
        }
    }
    // Delete Category From DATABASE
    $sql = "DELETE FROM tbl_category WHERE id = {$_GET['id']}";
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if ($res == true) {
        $_SESSION['success'] = "<div class='success' >Category Deleted Successfully</div>";
        header("Location: " . SITE_URL . "admin/manage-category.php");
    } else {
        $_SESSION['error'] = "<div class='error' >Failed To  Delete This Category, Try Again !</div>";
        header("Location: " . SITE_URL . "admin/manage-category.php");
    }




} else {
    $_SESSION['error'] = "<div class='error' >Failed To  Delete This Category, Try Again !</div>";
    header("Location: " . SITE_URL . "admin/manage-category.php");
}


?>