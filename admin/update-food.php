<?php include("partials/menu.php") ?>



<div class="main-content">
    <div class="wrapper">
        <h1>Update Food Info</h1>
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

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM tbl_food WHERE id = $id";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $description = $row['description'];
                $price = $row['price'];
                $current_image = $row['image_name'];
                $category_id = $row['category_id'];
                $featured = $row['featured'];
                $active = $row['active'];
            } else {
                // Redirect Page if no food id found
                $_SESSION['error'] = "<div class = 'error'>No Food Found</div>";
                header("Location: " . SITE_URL . "admin/manage-food.php");
            }


        } else {
            // Redirect to Manage Food
            header("Location: " . SITE_URL . "admin/manage-food.php");
        }

        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td><textarea name="description" cols="30" rows="5"
                            placeholder="Describe Food ! "><?php echo $description; ?></textarea></td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                        if ($current_image == "")
                            echo "<div class='error'>No Image Added</div>";
                        else {
                            echo "<img style = 'width:85px;' src=" . SITE_URL . "images/food_images/{$current_image} alt=''>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image: </td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td>
                        <select name="category">
                            <?php
                            // Get Categories From Database
                            $sql = "SELECT id,title FROM tbl_category WHERE active = 'Yes'";
                            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                            $count = mysqli_num_rows($res);
                            if ($count > 0) {
                                foreach ($res as $cat):
                                    if ($cat['id'] == $category_id) {
                                        echo <<<"FoodCATS"
                                        <option value="{$cat['id']}" selected>{$cat['title']} </option>
                                        FoodCATS;
                                    } else {
                                        echo <<<"FoodCATS"
                                        <option value="{$cat['id']}">{$cat['title']}</option>
                                        FoodCATS;
                                    }
                                endforeach;

                            } else {
                                echo <<<"FoodCATS"
                                    <option value="0">No Categories Added</option>
                                    FoodCATS;
                            }

                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured</td>
                    <td>

                        <input type="radio" name="featured" value="Yes" <?php echo $featured == 'Yes' ? 'checked' : ''; ?>>
                        Yes
                        <input type="radio" name="featured" value="No" <?php echo $featured == 'No' ? 'checked' : ''; ?>>
                        No
                    </td>
                </tr>
                <tr>
                    <td>Active</td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php echo $active == 'Yes' ? 'checked' : ''; ?>>Yes
                        <input type="radio" name="active" value="No" <?php echo $active == 'No' ? 'checked' : ''; ?>> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-primary" required>
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>
<?php
// Process Values & Store it in database

// Check Whetter the submit button is clicked or not
if (isset($_POST['submit'])) {

    // Validate Data
    // Get Data From Post Request
    $id = $_POST['id'];
    $current_image = $_POST['current_image'];
    $title = $_POST['title'];
    $description = $_POST['description'] ? $_POST['description'] : "";
    $price = $_POST['price'];
    $category = $_POST['category'];
    $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
    $active = isset($_POST['active']) ? $_POST['active'] : "No";


    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        // Get Image Name
        $image_name = $_FILES['image']['name'];
        // Get Image Extension
        $tmp = explode('.', $image_name);
        $ext = end($tmp);
        // Rename the Image
        $image_name = "Food_" . rand(000, 999) . '.' . $ext;
        // Get Source Path
        $source_path = $_FILES['image']['tmp_name'];
        // Set Destination Path
        $destination_path = "../images/food_images/$image_name";
        // Upload Image
        $upload = move_uploaded_file($source_path, $destination_path);
        // Check if Image is Uploaded or not
        if ($upload == false) {
            // create session variable
            $_SESSION['error'] = "<div class = 'error'>Image Can not be uploaded</div>";
            // Redirect Page
            header("Location: " . SITE_URL . "admin/update-food.php");
            // Stop The Process
            die();
        }
        if ($current_image != '') {
            $remove = unlink("../images/food_images/$current_image");
            if ($remove == false) {
                // create session variable
                $_SESSION['error'] = "<div class = 'error'>Can not Complete Update </div>";
                // Redirect Page
                header("Location: " . SITE_URL . "admin/update-food.php");
                // Stop The Process
                die();
            }
        }



    } else {
        $image_name = $current_image;
    }


    // SQL Query To Update Database
    $sqlQuery2 = "UPDATE tbl_food
                  SET title      = '$title'     ,
                      description = '$description',
                      price = '$price',
                      category_id = '$category',
                      image_name = '$image_name',
                      featured   = '$featured'  ,
                      active     = '$active'    
                  WHERE id = $id  ";

    // Execute Query
    $res2 = mysqli_query($conn, $sqlQuery2) or die(mysqli_error($conn));

    if ($res2 == true) {
        // create session variable
        $_SESSION['success'] = "<div class = 'success'>Food Updated Successfully</div>";
        // Redirect Page
        header("Location: " . SITE_URL . "admin/manage-food.php");
    } else {
        // create session variable
        $_SESSION['error'] = "<div class = 'error'>Food Couldn't be Updated </div>";
        // Redirect Page
        header("Location: " . SITE_URL . "admin/update-food.php");
    }


}

?>


<?php include("partials/footer.php") ?>


