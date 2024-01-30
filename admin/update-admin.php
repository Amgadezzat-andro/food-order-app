<?php include("partials/menu.php") ?>



<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin Info</h1>
        </br> </br>
        <form action="" method="POST">
            <table class="tbl-30">
                <?php
                if (isset($_GET['id'])) {
                    // Validate ID
                    $sql = "SELECT TRUE FROM tbl_admin WHERE id = {$_GET['id']}";
                    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    $exists = $res->fetch_assoc();
                    if (!$exists) {
                        $_SESSION['not-found'] = "<div class = 'error'>Not Found! <br>There is no such an admin </div>";
                        header("Location: " . $SITE_URL . "manage-admin.php");
                    }
                    // Get ID
                    $id = $_GET['id'];
                    //  SQL QUERY
                    $sql = "SELECT id,full_name,username FROM tbl_admin where id = $id";
                    // Response
                    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    // Get Admin Info
                    $admin_info = $res->fetch_assoc();
                    if ($res == true) {
                        echo <<<"AdminDataTable"
                            <tr>
                            <td>Full Name: </td>
                            <td><input type="text" name="full_name" value="{$admin_info["full_name"]}" required></td>
                            <td><input type="hidden" name="id" value = "{$admin_info["id"]}"> </td>
                            </tr>
                            <tr>
                            <td>Username: </td>
                            <td><input type="text" name="user_name" value="{$admin_info["username"]}" required></td>
                            </tr>
                            <tr>
                            <td colspan="2">
                            <input type="submit" name="submit" value="Update Admin Info" class="btn-primary" required>
                            </td>
                            </tr>
                        AdminDataTable;

                    } else {
                        echo <<<"ErrorDB"
                        <tr>
                        <td>Error Happened !! Can not Get Admin Info !</td>
                        
                        </tr>
                        ErrorDB;


                    }
                } else {
                    echo <<<"ErrorDB"
                   <tr>
                   <td>Error Happened !! Refresh The Page !</td>
                   
                   </tr>
                   ErrorDB;

                }



                ?>

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
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['user_name'];




    // SQL Query To Insert Data
    $sqlQuery = "UPDATE tbl_admin
                 SET
                    full_name = '$full_name' ,
                    username  = '$username'  
                 WHERE id = $id ";

    // Execute Query
    $res = mysqli_query($conn, $sqlQuery) or die(mysqli_error($conn));

    if ($res == true) {
        // create session variable
        $_SESSION['success'] = "<div class = 'success'>Admin Info Update Successfully</div>";
        // Redirect Page
        header("Location: " . $SITE_URL . "manage-admin.php");
    } else {
        // create session variable
        $_SESSION['error'] = "<div class = 'error'>Admin Info Couldn't be Updated </div>";
        // Redirect Page
        header("Location: " . $SITE_URL . "add-admin.php");
    }


} else {

}

?>