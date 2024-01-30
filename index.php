<?php
include('partials-front/menu.php');
include('partials-front/search.php');
?>

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


<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
        $sql = "SELECT * from tbl_category WHERE active= 'Yes' AND featured = 'Yes' LIMIT 3  ";
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $count = mysqli_num_rows($res);
        if ($count > 0) {
            foreach ($res as $cat) {
                $id = $cat['id'];
                $title = $cat['title'];
                $image_name = $cat['image_name'];
                ?>

                <a href="<?php echo SITE_URL . "category-foods.php" . "?id=" . $id; ?>">
                    <div class="box-3 float-container">
                        <?php
                        if ($image_name == "") {
                            echo "<div class='error'>image Not Available</div>";
                        } else {
                            ?>
                            <img src="images/category_images/<?php echo $image_name; ?>" alt="Pizza"
                                class="img-responsive img-curve">
                            <?php
                        }
                        ?>

                        <h3 class="float-text text-white">
                            <?php echo $title; ?>
                        </h3>
                    </div>
                </a>

                <?php
            }

        } else {
            // Categories Not Available
            echo "<div class='error text-center' > Category Not Added</div>";
        }
        ?>



        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>
        <?php
        $sql2 = "SELECT * FROM tbl_food WHERE featured = 'Yes' AND active = 'Yes' LIMIT 6";
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
            echo "<div class='error text-center'> No Foods Available</div>";
        }
        ?>





        <div class="clearfix"></div>



    </div>

    <p class="text-center">
        <a href=<?php echo SITE_URL . "foods.php" ?>>See All Foods</a>
    </p>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>