<?php include("partials/menu.php") ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Orders</h1>

        <br></br>
        <a href="#" class="btn-primary">Add Order</a>
        <br></br>
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

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Action</th>
            </tr>
            <?php
            $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            if ($res == true) {
                $count = mysqli_num_rows($res);
                $id = 0;
                if ($count > 0) {

                   
                    // there is Data
                    foreach ($res as $order) {
                        if ($order['status'] == 'Ordered') {
                            $order['status'] = "<label style ='color:green;'>Ordered</label>";
                        }
                        if ($order['status'] == 'Cancelled') {
                            $order['status'] = "<label style ='color:red;'>Cancelled</label>";
                        }
                        if ($order['status'] == 'Delivered') {
                            $order['status'] = "<label style ='color:orange;'>Delivered</label>";
                        }
                        if ($order['status'] == 'On Delivery') {
                            $order['status'] = "<label style ='color:blue;'>On Delivery</label>";
                        }
                        $id++;
                        echo <<<"OrderDataTable"
                               <tr>
                                <td>{$id}.</td>
                                <td>{$order['food']}</td>
                                <td>{$order['price']}</td>
                                <td>{$order['qty']}</td>
                                <td>{$order['total']}</td>
                                <td>{$order['order_date']}</td>
                                <td>{$order['status']}</td>
                                <td>{$order['customer_name']}</td>
                                <td>{$order['customer_contact']}</td>
                                <td>
                                <a href="update-order.php?id={$order['id']}" class="btn-secondary">Update Order</a>
                                <a href="delete-order.php?id={$order['id']}" class="btn-danger">Delete Order</a>                                </td>
                              </tr>
                        OrderDataTable;
                    }

                } else {
                    echo <<<"NoDataFound"
                    <tr>
                    <td>No Orderes Wait Till Someone Orders One !!</td>
                    
                    </tr>
                    NoDataFound;
                }
            } else {
                echo <<<"ErrorDB"
                   <tr>
                   <td>Error Happened !! Refresh The Page !</td>
                   
                   </tr>
                   ErrorDB;
            }

            ?>

        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include("partials/footer.php") ?>