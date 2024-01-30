<?php include("partials/menu.php") ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>

        <br></br>
        <a href="add-food.php" class="btn-primary">Add Food</a>
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
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Category</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
            <?php
            //  SQL QUERY
            $sql = "SELECT f.id , f.title , f.description , f.price , f.image_name , c.title AS category ,f.featured,f.active FROM `tbl_food` f , `tbl_category` c WHERE f.category_id = c.id;";
            // Response
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            // If Response Returns True
            if ($res == true) {
                // Count Rows to Check whether we have data in database 
                $rowsNum = mysqli_num_rows($res); // Get Rows Number
                $id = 0;
                if ($rowsNum > 0) {
                    // there is Data
                    foreach ($res as $food) {
                        // Check if image has image or not
                        $imageURL = $food['image_name'];
                        if ($imageURL == "")
                            $imageURL = "<div class='error'>No Image Added</div>";
                        else {
                            $imageURL = "<img style = 'width:85px;' src=" . SITE_URL . "images/food_images/{$food['image_name']} alt=''>";
                        }
                        $id++;
                        echo <<<"AdminDataTable"
                               <tr>
                                <td>{$id}</td>
                                <td>{$food['title']}</td>
                                <td>{$food['description']}</td>
                                <td>{$food['price']}</td>
                                <td>{$imageURL}</td>
                                <td>{$food['category']}</td>
                                <td>{$food['featured']}</td>
                                <td>{$food['active']}</td>
                                <td>
                                <a href="update-food.php?id={$food['id']}" class="btn-secondary">Edit</a>
                                <a href="delete-food.php?id={$food['id']}&image_name={$food['image_name']}" class="btn-danger">Delete</a>
                                </td>
                              </tr>
                        AdminDataTable;
                    }

                } else {
                    echo <<<"NoDataFound"
                   <tr>
                   <td>No Foods Added Yet .. Create One !!</td>
                   
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