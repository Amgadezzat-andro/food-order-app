<?php include("partials/menu.php") ?>



<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        </br> </br>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" placeholder="Enter your name" required></td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="user_name" placeholder="Enter your username" required></td>
                </tr>
                <tr>
                    <td>Password </td>
                    <td><input type="password" name="password" placeholder="Enter a password" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-primary" required>
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>


<?php include("partials/footer.php") ?>


<?php
// Process Values & Store it in database

// Check Whetter the submit button is clicked or not
if (isset($_POST['submit'])) {
    // Validate Data
    // Get Data From Post Request
    $full_name = $_POST['full_name'];
    $username = $_POST['user_name'];
    $password = md5($_POST['password']); // Password Encryption



    // SQL Query To Insert Data
    $sqlQuery = "INSERT INTO tbl_admin SET
        full_name = '$full_name' ,
        username  = '$username'  ,
        password  = '$password'  ";

    // Execute Query
    $res = mysqli_query($conn, $sqlQuery) or die(mysqli_error($conn));

    if ($res == true) {
        // create session variable
        $_SESSION['success'] = "<div class = 'success'>Admin Added Successfully</div>";
        // Redirect Page
        header("Location: " . $SITE_URL . "manage-admin.php");
    } else {
        // create session variable
        $_SESSION['error'] = "<div class = 'error'>Admin Couldn't be Added </div>";
        // Redirect Page
        header("Location: " . $SITE_URL . "add-admin.php");
    }


} else {

}

?>