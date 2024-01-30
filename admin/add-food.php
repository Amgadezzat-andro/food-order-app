<?php include("partials/menu.php") ?>



<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
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
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" placeholder="Enter A Food Title" required></td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td><textarea name="description" cols="30" rows="5" placeholder="Describe Food ! "></textarea></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
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
                                    echo <<<"FoodCATS"
                                        <option value="{$cat['id']}">{$cat['title']}</option>
                                        FoodCATS;
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
                    <td>Active</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Featured</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-primary" required>
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
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
    $active = isset($_POST['active']) ? $_POST['active'] : "No";



    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {

        // Get Image Name
        $image = $_FILES['image']['name'];

        // Get Image Extension
        $tmp = explode('.', $image);
        $ext = end($tmp);

        // Rename the Image
        $image = "Food_" . rand(0000, 9999) . '.' . $ext;

        // Get Source Path
        $source_path = $_FILES['image']['tmp_name'];

        // Set Destination Path
        $destination_path = "../images/food_images/$image";

        // Upload Image
        $upload = move_uploaded_file($source_path, $destination_path);

        // Check if Image is Uploaded or not
        if ($upload == false) {

            // create session variable
            $_SESSION['error'] = "<div class = 'error'>Image Can not be uploaded</div>";

            // Redirect Page
            header("Location: " . SITE_URL . "admin/add-food.php");

            // Stop The Process
            die();
        }

    } else {
        $image = "";
    }

    // SQL Query To Insert Data
    $sqlQuery = "INSERT INTO tbl_food SET
        title      = '$title'     ,
        image_name = '$image'     ,
        description = '$description' ,
        price = $price ,
        category_id = $category ,
        featured   = '$featured'  ,
        active     = '$active'  ";

    // Execute Query
    $res = mysqli_query($conn, $sqlQuery) or die(mysqli_error($conn));

    if ($res == true) {
        // create session variable
        $_SESSION['success'] = "<div class = 'success'>Food Added Successfully</div>";
        // Redirect Page
        header("Location: " . SITE_URL . "admin/manage-food.php");
    } else {
        // create session variable
        $_SESSION['error'] = "<div class = 'error'>food Couldn't be Added </div>";
        // Redirect Page
        header("Location: " . SITE_URL . "admin/add-food.php");
    }


} else {

}

?>