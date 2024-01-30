<?php
include('partials-front/menu.php');
include('partials-front/search.php');
?>




<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">

    <div class="container">
        <h2 class="text-center">Food Menu</h2>
        <?php
        $sql2 = "SELECT * FROM tbl_food WHERE featured = 'Yes' AND active = 'Yes'";
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
        ?>


        <div class="clearfix"></div>



    </div>

</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>