<?php include("partials/menu.php") ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'] . "</br></br>";
            unset($_SESSION['login']);
        }
        ?>

        <h1>Dashboard</h1>

        <div class="col-4 text-center">
            <?php
            $sql = "SELECT * from tbl_category";
            $sql2 = "SELECT * from tbl_category WHERE active = 'Yes'";
            $sql3 = "SELECT * from tbl_category WHERE featured = 'Yes'";
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
            $res3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));

            $catCount = mysqli_num_rows($res);
            $catActiveCount = mysqli_num_rows($res2);
            $catFeaturedCount = mysqli_num_rows($res3);

            ?>
            <h1>
                <?php echo $catCount; ?>
            </h1>
            <br>
            Total Categories
            <h1> </br>
                <?php echo $catActiveCount; ?>
            </h1>
            </br>
            <label style="color: green;">Active Categories</label>
            </br>
            <h1> </br>
                <?php echo $catFeaturedCount; ?>
            </h1>
            </br>
            <label style="color: orange;">Featured Categories</label>
        </div>

        <div class="col-4 text-center">
            <?php
            $sql = "SELECT * from tbl_food";
            $sql2 = "SELECT * from tbl_food WHERE active = 'Yes'";
            $sql3 = "SELECT * from tbl_food WHERE featured = 'Yes'";
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
            $res3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
            $catCount = mysqli_num_rows($res);
            $catActiveCount = mysqli_num_rows($res2);
            $catFeaturedCount = mysqli_num_rows($res3);

            ?>
            <h1>
                <?php echo $catCount; ?>
            </h1>
            <br>
            Total Foods
            <h1> </br>
                <?php echo $catActiveCount; ?>
            </h1>
            </br>
            <label style="color: green;">Active Foods</label>
            </br>
            <h1> </br>
                <?php echo $catFeaturedCount; ?>
            </h1>
            </br>
            <label style="color: orange;">Featured Foods</label>
            <br>
        </div>

        <div class="col-4 text-center">
            <?php
            $sql = "SELECT * from tbl_order";
            $sql2 = "SELECT * FROM tbl_order WHERE status ='Ordered' ";
            $sql3 = "SELECT * FROM tbl_order WHERE status ='On Delivery' ";
            $sql4 = "SELECT * FROM tbl_order WHERE status ='Delivered' ";
            $sql4 = "SELECT * FROM tbl_order WHERE status ='Cancelled' ";
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
            $res3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
            $res4 = mysqli_query($conn, $sql4) or die(mysqli_error($conn));
            $res5 = mysqli_query($conn, $sql4) or die(mysqli_error($conn));
            $count = mysqli_num_rows($res);
            $count2 = mysqli_num_rows($res2);
            $count3 = mysqli_num_rows($res3);
            $count4 = mysqli_num_rows($res4);
            $count5 = mysqli_num_rows($res5);
            ?>
            <h1>
                <?php echo $count; ?>
            </h1>
            <br>
            Total Orders
            <h1> </br>
                <?php echo $count2; ?>
            </h1>
            </br>
            <label style="color: green;">Ordered Stauts</label>
            </br>
            <h1> </br>
                <?php echo $count3; ?>
            </h1>
            </br>
            <label style="color: teal;">On Delivery Stauts</label>
            </br>
            <h1> </br>
                <?php echo $count4; ?>
            </h1>
            </br>
            <label style="color: purple;">Delivered Stauts</label>
            </br>
            <!-- <h1> </br>
                <?php echo $count5; ?>
            </h1>
            </br>
            <label style="color: red;">Cancelled Ordered</label> -->
        </div>
        <div class="col-4 text-center">
            <?php
            $sql = "SELECT SUM(total) AS Total FROM tbl_order WHERE status ='Delivered' ";
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $row = $res->fetch_assoc();


            ?>
            <h1>
                <?php echo $row['Total'] ?>$
            </h1>
            <br>
            Revenue Generated
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include("partials/footer.php") ?>