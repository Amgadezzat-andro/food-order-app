<?php include("partials/menu.php") ?>



<div class="main-content">
    <div class="wrapper">
        <h1>Update Order Info</h1>
        </br> </br>
        <form action="" method="POST">
            <table class="tbl-30">
                <?php

                function getOption($order)
                {
                    switch ($order['status']) {
                        case 'Ordered':
                            $optionStat = "<option value='Ordered' selected>Ordered</option>
                            <option value='On Delivery'>On Delivery</option>
                            <option value='Delivered'>Delivered</option>
                            <option value='Cancelled'>Cancelled</option>";
                            break;
                        case 'On Delivery':
                            $optionStat = "<option value='Ordered'>Ordered</option>
                            <option value='On Delivery' selected> On Delivery</option>
                            <option value='Delivered'>Delivered</option>
                            <option value='Cancelled'>Cancelled</option>";
                            break;
                        case 'Delivered':
                            $optionStat = "<option value='Ordered' >Ordered</option>
                            <option value='On Delivery'>On Delivery</option>
                            <option value='Delivered' selected>Delivered</option>
                            <option value='Cancelled'>Cancelled</option>";
                            break;
                        case 'Cancelled':
                            $optionStat = "<option value='Ordered' >Ordered</option>
                            <option value='On Delivery'>On Delivery</option>
                            <option value='Delivered'>Delivered</option>
                            <option value='Cancelled' selected>Cancelled</option>";
                            break;

                        default:
                            $optionStat = "<option value='Ordered'>Ordered</option>
                        <option value='On Delivery'>On Delivery</option>
                        <option value='Delivered'>Delivered</option>
                        <option value='Cancelled'>Cancelled</option>";
                            break;
                    }
                    return $optionStat;
                }

                if (isset($_GET['id'])) {
                    // Validate ID
                    $sql = "SELECT TRUE FROM tbl_order WHERE id = {$_GET['id']}";
                    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    $exists = $res->fetch_assoc();
                    if (!$exists) {
                        $_SESSION['not-found'] = "<div class = 'error'>Not Found! <br>There is no such an Order </div>";
                        header("Location: " . $SITE_URL . "manage-order.php");
                    }
                    // Get ID
                    $id = $_GET['id'];
                    //  SQL QUERY
                    $sql = "SELECT * FROM tbl_order where id = $id";
                    // Response
                    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    // Get Order Info
                    $order_info = $res->fetch_assoc();
                    // Options from function 
                    $options = getOption($order_info);
                    if ($res == true) {
                        echo <<<"OrderDataTable"
                            <tr>
                            <td>Food Name: </td>
                            <td><b>{$order_info["food"]}</b></td>
                            </tr>
                            <tr>
                            <td>Price</td>
                            <td><b>{$order_info["price"]}</b></td>
                            </tr>
                            <tr>
                            <td>Quatnity</td>
                            <td><input type="number" name="qty" value="{$order_info["qty"]}" required></td>
                            </tr>
                            <tr>
                            <td>Total</td>
                            <td><b>{$order_info["total"]}</b></td>
                            </tr>
                            <tr>
                            <td>Status</td>
                            <td>
                            <select name="status"> $options </select>
                            </td>
                            </tr>
                            <tr>
                            <td>Customer Name</td>
                            <td><input type="name" name="customer_name" value="{$order_info["customer_name"]}" required></td>
                            </tr>
                            <tr>
                            <td>Customer Contact</td>
                            <td><input type="name" name="customer_contact" value="{$order_info["customer_contact"]}" required></td>
                            </tr>
                            <tr>
                            <td>Customer Email</td>
                            <td><input type="name" name="customer_email" value="{$order_info["customer_email"]}" required></td>
                            </tr>
                            <tr>
                            <td>Customer Address</td>
                            <td><textarea type="name" name="customer_address"  cols="30" rows = "5" required>{$order_info["customer_address"]}</textarea></td>
                            </tr>
                            <tr>
                            <td colspan="2">
                            <input type="submit" name="submit" value="Update Order" class="btn-primary" required>
                            <input type="hidden" name="id" value = "{$order_info["id"]}">
                            <input type="hidden" name="price" value = "{$order_info["price"]}">
                            </td>
                            </tr>
                        OrderDataTable;

                    } else {
                        echo <<<"ErrorDB"
                        <tr>
                        <td>Error Happened !! Can not Get Order Info !</td>
                        
                        </tr>
                        ErrorDB;


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
    $id = $_POST['id'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $total = $price * $qty;
    $status = $_POST['status'];
    $customer_name = $_POST['customer_name'];
    $customer_contact = $_POST['customer_contact'];
    $customer_email = $_POST['customer_email'];
    $customer_address = $_POST['customer_address'];

    // SQL Query To Insert Data
    $sqlQuery = "UPDATE tbl_order
                 SET
                    qty = $qty ,
                    total  = $total,
                    status  = '$status',
                    customer_name  = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address' 
                 WHERE id = $id ";

    // Execute Query
    $res = mysqli_query($conn, $sqlQuery) or die(mysqli_error($conn));

    if ($res == true) {
        // create session variable
        $_SESSION['success'] = "<div class = 'success'>Order Info Updated Successfully</div>";
        // Redirect Page
        header("Location: " . SITE_URL . "admin/manage-orders.php");
    } else {
        // create session variable
        $_SESSION['error'] = "<div class = 'error'>Order Info Couldn't be Updated </div>";
        // Redirect Page
        header("Location: " . SITE_URL . "admin/update-order.php");
    }


} else {

}

?>