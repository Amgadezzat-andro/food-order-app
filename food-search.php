<?php include('partials-front/menu.php'); ?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <?php
        $search = mysqli_real_escape_string($conn, $_POST['search']);
        ?>

        <h2>Foods on Your Search <a href="#" class="text-white">"
                <?php echo isset($search) ? $search : "" ?>"
            </a></h2>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->





<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>
        <?php
        if (isset($search)) {
            $sql2 = "SELECT * FROM tbl_food WHERE title LIKE " . "'%" . $search . "%'" . "OR description LIKE" . "'%" . $search . "%'";
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
            // var_dump($search); 
            $_SESSION['not-found'] = "</br></br><div class = 'error'>You Have To Use Search Item </div>";
            header("Location: " . SITE_URL);
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