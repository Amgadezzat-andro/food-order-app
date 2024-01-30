<?php include('partials-front/menu.php'); ?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        <?php
        $sqls = "SELECT title from tbl_category WHERE id =" . $_GET['id'];
        $res = mysqli_query($conn, $sqls) or die(mysqli_error($conn));
        $catTitle = $res->fetch_assoc();
        ?>

        <h2>Foods on <a href="#" class="text-white">"<?= $catTitle['title']?>"</a></h2>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">

    <div class="container">
        <h2 class="text-center">Food Menu</h2>
        <?php
        if (isset($_GET['id'])) {
            // Check If Category Exists
            $sql = "SELECT TRUE FROM tbl_category WHERE id =" . $_GET['id'];
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $exists = $res->fetch_assoc();
            if (!$exists) {
                $_SESSION['not-found'] = "</br></br><div class = 'error'>Can't Find This Category </div>";
                header("Location: " . SITE_URL);
            }
            // Get Foods Where Category id = ** 
            $sql2 = "SELECT * FROM tbl_food WHERE category_id = " . $_GET['id'];
            $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
            $count2 = mysqli_num_rows($res2);
            if ($count2 > 0) {
                foreach ($res2 as $food):
                    $id = $food['id'];
                    $title = $food['title'];
                    $price = $food['price'];
                    $description = $food['description'];
                    $image_name = $food['image_name'];
                    ?>

                    <div class="food-menu-box">

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
                            <h4>
                                <?php echo $title; ?>
                            </h4>
                            <p class="food-price">$
                                <?php echo $price; ?>
                            </p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href="order.php?id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>

                    <?php


                endforeach;

            } else {
                echo "<div class='error'> No Foods Available</div>";
            }

        } else {
            // Redirect Page to Home
            $_SESSION['not-found'] = "</br></br><div class = 'error'>Can't Find This Category </div>";
            header("Location: " . SITE_URL);
        }

        ?>

        <div class="clearfix"></div>



    </div>

</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>