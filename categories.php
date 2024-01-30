<?php include('partials-front/menu.php'); ?>

<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Food Categories</h2>

        <?php
        $sql = "SELECT * FROM tbl_category WHERE active = 'Yes'";
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $count = mysqli_num_rows($res);
        if ($count > 0) {
            foreach ($res as $cat):
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
            endforeach;

        } else {
            echo "<div class='error' >No Categories Available</div>";
        }
        ?>







        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->


<?php include('partials-front/footer.php'); ?>