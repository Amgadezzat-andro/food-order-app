<?php include('../config/constants.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Food-Order System - Login</title>
    <link rel="stylesheet" href="../css/login-style.css">

</head>

<body>
    <!-- partial:index.partial.html -->
    <div id="bg"></div>

    <form action="" method="POST">
        <div class="form-field">
            <input type="text" placeholder="Email / Username" name="username" required />
        </div>

        <div class="form-field">
            <input type="password" placeholder="Password" name="password" required />
        </div>

        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        if (isset($_SESSION['no-login-message'])) {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }
        ?>
        </br></br>

        <div class="form-field">
            <button class="btn" type="submit" name="submit">Log in</button>
        </div>
    </form>
    <!-- partial -->

</body>

</html>

<?php

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    // var_dump($username, $password);
    $sql = "SELECT TRUE FROM tbl_admin WHERE username = '$username' AND password = '$password'";
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $exists = $res->fetch_assoc();
    if ($exists) {
        // Match
        $_SESSION['user'] = $username;
        $_SESSION['login'] = "<div class = 'success'>Login Successful</div>";
        header("Location: " . $SITE_URL . "index.php");
    } else {
        // No Match
        $_SESSION['login'] = "<div class = 'error'>Incorrect password or username</div>";
        header("Location: " . $SITE_URL . "login.php");
    }

}


?>