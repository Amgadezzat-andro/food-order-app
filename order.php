<?php include('partials-front/menu.php'); ?>

<?php
if (isset($_GET['id'])) {

    // Check If ID is Empty & Only Integer Value
    if ($_GET['id'] == '' || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
        $_SESSION['not-found'] = "</br></br><div class = 'error text-center'>Can't Find This Food ID </div>";
        header("Location: " . SITE_URL);
    }
    // Check If ID Exists In Database 
    $sql = "SELECT TRUE FROM tbl_food WHERE id =" . $_GET['id'];
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $exists = $res->fetch_assoc();
    if (!$exists) {
        $_SESSION['not-found'] = "</br></br><div class = 'error text-center'>Can't Find This Food ID </div>";
        header("Location: " . SITE_URL);
    }
    // Get Food Id 
    $foodID = $_GET['id'];
    $sql2 = "SELECT * FROM tbl_food WHERE id = $foodID";
    $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
    $count2 = mysqli_num_rows($res2);
    if ($count2 == 1) {
        foreach ($res2 as $food):
            $title = $food['title'];
            $price = $food['price'];
            $image_name = $food['image_name'];
        endforeach;

    } else {
        $_SESSION['not-found'] = "</br></br><div class = 'error text-center'>Can't Find This Food Data </div>";
        header("Location: " . SITE_URL);
    }
} else {
    // Redirect Page to Home
    $_SESSION['not-found'] = "</br></br><div class = 'error text-center'>Can't Find This Order </div>";
    header("Location: " . SITE_URL);
}
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">

        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" class="order" method="post">
            <fieldset>
                <legend>Selected Food</legend>
                <?php
                if ($image_name == "") {
                    echo "<div class='error'>image Not Available</div>";
                } else {
                    ?>
                    <div class="food-menu-img">
                        <img src="images/food_images/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza"
                            class="img-responsive img-curve">
                    </div>
                    <?php
                }
                ?>

                <div class="food-menu-desc">
                    <h3>
                        <?= $title ?>
                    </h3>
                    <input type="hidden" name="food" value="<?php echo $title; ?>">
                    <p class="food-price">$
                        <?= $price ?>
                    </p>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>

                </div>

            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive"
                    required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>

    </div>
</section>

<?php
if (isset($_POST['submit'])) {

    $food = $_POST['food'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $total = $price * $qty;
    $order_date = date("y-m-d h:i:s");
    $status = "Ordered";
    $customer_name = $_POST['full-name'];
    $customer_contact = $_POST['contact'];
    $customer_email = $_POST['email'];
    $customer_address = $_POST['address'];

    $sql3 = "INSERT INTO tbl_order SET 
    food = '$food' ,
    price = $price ,
    qty = $qty ,
    total = $total ,
    order_date = '$order_date' ,
    status = '$status' ,
    customer_name = '$customer_name',
    customer_email = '$customer_email',
    customer_contact = '$customer_contact',
    customer_address = '$customer_address' ";
    $res3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
    if($res3==true){
        // Query Executed & Order Saved 
        $_SESSION['success'] = "</br></br><div class = 'success text-center'>Food is Ordered ! </div>";
        header("Location: " . SITE_URL);

    }else {
        // Failed
        $_SESSION['error'] = "</br></br><div class = 'error text-center'>Failed To Order ! </div>";
        header("Location: " . SITE_URL);
    }
}

?>
<!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-front/footer.php'); ?>