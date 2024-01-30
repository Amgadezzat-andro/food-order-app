<?php include("partials/menu.php") ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <!-- Add Admin Button -->
        <br></br>
        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br></br>

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

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Full Name</th>
                <th>UserName</th>
                <th>Actions</th>
            </tr>

            <?php
            //  SQL QUERY
            $sql = "SELECT id,full_name,username FROM tbl_admin";
            // Response
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            // If Response Returns True
            if ($res == true) {
                // Count Rows to Check whether we have data in database 
                $rowsNum = mysqli_num_rows($res); // Get Rows Number
                $id = 0;
                if ($rowsNum > 0) {
                    // there is Data
                    foreach ($res as $admin) {
                        $id++;
                        echo <<<"AdminDataTable"
                               <tr>
                                <td>{$id}</td>
                                <td>{$admin['full_name']}</td>
                                <td>{$admin['username']}</td>
                                <td>
                                <a href="update-admin.php?id={$admin['id']}" class="btn-secondary">Edit</a>
                                <a href="delete-admin.php?id={$admin['id']}" class="btn-danger">Delete</a>
                                <a href="change-password-admin.php?id={$admin['id']}" class="btn-orange">Change Password</a>
                                </td>
                              </tr>
                        AdminDataTable;
                    }

                } else {
                    echo <<<"NoDataFound"
                   <tr>
                   <td>No Admins Create One !!</td>
                   
                   </tr>
                   NoDataFound;
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


    </div>
</div>
<!-- Main Content Section Ends -->

<?php include("partials/footer.php") ?>