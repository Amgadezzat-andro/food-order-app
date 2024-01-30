<?php include("partials/menu.php") ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>
        <br></br>
        <a href="add-category.php" class="btn-primary">Add Category</a>
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
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
            <?php
            //  SQL QUERY
            $sql = "SELECT * FROM tbl_category";
            // Response
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            // If Response Returns True
            if ($res == true) {
                // Count Rows to Check whether we have data in database 
                $rowsNum = mysqli_num_rows($res); // Get Rows Number
                $id = 0;
                if ($rowsNum > 0) {
                    // there is Data
                    foreach ($res as $cat) {
                        // Check if image has image or not
                        $imageURL = $cat['image_name'];
                        if ($imageURL == "") $imageURL = "<div class='error'>No Image Added</div>";
                        else {
                            $imageURL = "<img style = 'width:85px;' src=" . SITE_URL . "images/category_images/{$cat['image_name']} alt=''>";
                        }
                        $id++;
                        echo <<<"AdminDataTable"
                               <tr>
                                <td>{$id}</td>
                                <td>{$cat['title']}</td>
                                <td>{$imageURL}</td>
                                <td>{$cat['featured']}</td>
                                <td>{$cat['active']}</td>
                                <td>
                                <a href="update-category.php?id={$cat['id']}" class="btn-secondary">Edit</a>
                                <a href="delete-category.php?id={$cat['id']}&image_name={$cat['image_name']}" class="btn-danger">Delete</a>
                                </td>
                              </tr>
                        AdminDataTable;
                    }

                } else {
                    echo <<<"NoDataFound"
                   <tr>
                   <td>No Categories Added Yet .. Create One !!</td>
                   
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