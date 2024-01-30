<?php include("partials/menu.php") ?>



<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
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
                    <td><input type="text" name="title" placeholder="Enter A Category Title" required></td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Featured</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
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
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-primary" required>
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
    $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
    $active = isset($_POST['active']) ? $_POST['active'] : "No";



    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        // Get Image Name
        $image = $_FILES['image']['name'];

        // Get Image Extension
        $tmp = explode('.', $image);
        $ext = end($tmp);
        // Rename the Image
        $image = "Food_Category_" . rand(000, 999) . '.' . $ext;

        // Get Source Path
        $source_path = $_FILES['image']['tmp_name'];

        // Set Destination Path
        $destination_path = "../images/category_images/$image";

        // Upload Image
        $upload = move_uploaded_file($source_path, $destination_path);

        // Check if Image is Uploaded or not
        if ($upload == false) {
            // create session variable
            $_SESSION['error'] = "<div class = 'error'>Image Can not be uploaded</div>";
            // Redirect Page
            header("Location: " . SITE_URL . "admin/add-category.php");
            // Stop The Process
            die();
        }

    } else {
        $image = "";
    }

    // SQL Query To Insert Data
    $sqlQuery = "INSERT INTO tbl_category SET
        title      = '$title'     ,
        image_name = '$image'     ,
        featured   = '$featured'  ,
        active     = '$active'  ";

    // Execute Query
    $res = mysqli_query($conn, $sqlQuery) or die(mysqli_error($conn));

    if ($res == true) {
        // create session variable
        $_SESSION['success'] = "<div class = 'success'>Category Added Successfully</div>";
        // Redirect Page
        header("Location: " . SITE_URL . "admin/manage-category.php");
    } else {
        // create session variable
        $_SESSION['error'] = "<div class = 'error'>Category Couldn't be Added </div>";
        // Redirect Page
        header("Location: " . SITE_URL . "admin/add-category.php");
    }


} else {

}

?>