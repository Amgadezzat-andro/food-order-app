<?php include("partials/menu.php") ?>



<div class="main-content">
    <div class="wrapper">
        <h1>Change Admin Password</h1>
        </br> </br>
        <?php
        if (isset($_SESSION['success'])) {
            echo $_SESSION['success'];
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['not-found'])) {
            echo $_SESSION['not-found'];
            unset($_SESSION['not-found']);
        }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <?php

                if (isset($_GET['id'])) {
                    $sql = "SELECT TRUE FROM tbl_admin WHERE id = {$_GET['id']}";
                    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    $exists = $res->fetch_assoc();
                    if (!$exists) {
                        $_SESSION['not-found'] = "<div class = 'error'>Not Found! <br>There is no such an admin </div>";
                        header("Location: " . $SITE_URL . "manage-admin.php");
                    }
                    echo <<<"AdminDataTable"
                            <tr>
                            <td>Old Password: </td>
                            <td><input type="text" name="current_password" value="" required></td>
                            <td><input type="hidden" name="id" value = "{$_GET['id']}"> </td>
                            </tr>
                            <tr>
                            <td>New Password: </td>
                            <td><input type="text" name="new_password" value="" required></td>
                            </tr>
                            <tr>
                            <td>Confirm Password: </td>
                            <td><input type="text" name="confirm_password" value="" required></td>
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
    // Get Current Password From Request
    $current_password = $_POST['current_password'];
    // Get New Password From Request
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    if ($new_password == $confirm_password) {
        //  Query to Get  Current Password From Database
        $query = "SELECT password FROM tbl_admin WHERE id = '$id'";
        //  Execute Query
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
        // fetchData
        $getData = $res->fetch_assoc();
        if ($res == true) {
            //  Query Executed Successfully
            // Compare Passwords
            if ($getData['password'] == md5($current_password)) {
                $query2 = "UPDATE tbl_admin SET password = '$new_password' WHERE id = $id";
                //  Execute Query
                $res = mysqli_query($conn, $query2) or die(mysqli_error($conn));
                if ($res == true) {
                    $_SESSION['success'] = "<div class = 'success'>Admin Password Updated Successfully</div>";
                    header("Location: " . $SITE_URL . "manage-admin.php");
                } else {
                    $_SESSION['error'] = "<div class = 'error'>Admin Password could'nt be Updated </div>";
                    header("Location: " . $SITE_URL . "manage-admin.php");

                }
            } else {
                $_SESSION['error'] = "<div class = 'error'>Admin Password is Incorrect, Please enter the right password !!  </div>";
                header("Location: " . $SITE_URL . "change-password-admin.php?id=$id");

            }
        } else {
            //  Query Failed
            $_SESSION['error'] = "<div class = 'error'>Some Error Happened , Try Again Later ! </div>";
            header("Location: " . $SITE_URL . "manage-admin.php");
        }

    } else {
        $_SESSION['error'] = "<div class = 'error'>Admin Password Miss match, Please enter the right password !!  </div>";
        header("Location: " . $SITE_URL . "change-password-admin.php?id=$id");
    }

} else {
    // Error Happened in submit
    // $_SESSION['success'] = "<div class = 'success'>Admin Info Update Successfully</div>";
    // header("Location: " . $SITE_URL . "manage-admin.php");
}

?>