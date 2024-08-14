<?php
require('connection.php');
session_start();

// Redirect to login page if not logged in as admin
if (!isset($_SESSION['Adminname'])) {
    header("Location: login.php?error=Login first");
    exit();
}

if (isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    mysqli_query($con, "UPDATE `orders` SET status = '$update_payment' WHERE id = '$order_id'") or die('query failed');
    echo 'Payment status has been updated!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($con, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
    header('location:adminorder.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="css/dashboard.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
    <?php @include 'adminheader.php'; ?>
    <section>
        <h1 class="title">Orders :</h1>

        <div class="box-container">
            <?php
            $select_orders = mysqli_query($con, "SELECT * FROM `orders`") or die('query failed');
            if (mysqli_num_rows($select_orders) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
            ?>
                    <div class="box">
                        <p> Order id : <span><?php echo $fetch_orders['id']; ?></span> </p>
                        <p> Placed on : <span><?php echo $fetch_orders['date']; ?></span> </p>
                        <p> Email : <span><?php echo $fetch_orders['email']; ?></span> </p>
                        <p> Full Name : <span><?php echo $fetch_orders['Full_name']; ?></span> </p>
                        <p> Phone number : <span><?php echo $fetch_orders['number']; ?></span> </p>
                        <p> Address : <span><?php echo $fetch_orders['address']; ?></span> </p>
                        <p> Total products : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
                        <p> Total price : <span>रु<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
                        <p> Payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
                        <form action="" method="post">
                            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                            <p>Status : </p>
                            <select name="update_payment">
                                
                                <option><?php echo $fetch_orders['status']; ?></option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                            </select><br />
                            <input type="submit" name="update_order" value="Update" class="option-btn">
                            <a href="adminorder.php?delete=<?php echo $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">Delete</a>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">No orders placed yet!</p>';
            }
            ?>
        </div>
    </section>
</body>

</html>
