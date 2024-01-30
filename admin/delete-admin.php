<?php
include("partials/login-check.php");
include("../config/constants.php");
// Get Id
if (isset($_GET['id'])) {
    // Validate ID
    $sql = "SELECT TRUE FROM tbl_admin WHERE id = {$_GET['id']}";
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $exists = $res->fetch_assoc();
    if (!$exists) {
        $_SESSION['not-found'] = "<div class = 'error'>Not Found! <br>There is no such an admin </div>";
        header("Location: " . $SITE_URL . "manage-admin.php");
    } else {
        // Get Id
        $id = $_GET['id'];
        // Create SQL Query To DElete Admin
        $sqlQuery = "DELETE FROM tbl_admin WHERE id = $id";
        // Get Response
        $res = mysqli_query($conn, $sqlQuery) or die(mysqli_error($conn));

        if ($res == true) {
            $_SESSION['success'] = "<div class='success' >Admin Deleted Successfully</div>";
            header("Location: " . $SITE_URL . "manage-admin.php");
        } else {
            $_SESSION['error'] = "<div class='error' >Failed To  Delete This Admin, Try Again !</div>";
            header("Location: " . $SITE_URL . "manage-admin.php");
        }
    }



} else {
    echo "Error Happened ! ";
}



?>