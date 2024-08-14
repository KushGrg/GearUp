<?php
@include 'connection.php';

session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php?error=You need to Login first!!');
} else {
    $email = $_SESSION['useremail'];
}

if (isset($_POST['order'])) {
    $name = mysqli_real_escape_string($con, $_POST['Full_name']);
    $order_email = mysqli_real_escape_string($con, $_POST['email']);
    $number = mysqli_real_escape_string($con, $_POST['number']);
    $method = mysqli_real_escape_string($con, $_POST['method']);
    $address = mysqli_real_escape_string($con, $_POST['address'] . ', ' . $_POST['district'] . ', ' . $_POST['country']);
    $date = date('Y-m-d');


    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = mysqli_query($con, "SELECT * FROM `cart` WHERE email = '$email'") or die('query failed');
    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }


    // concatenates the elements of an array into a single string
    $total_products = implode('- ', $cart_products);

    $order_query = mysqli_query($con, "SELECT * FROM `orders` WHERE Full_name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');
    
    if ($cart_total == 0) {
        echo 'Your cart is empty!';
    } elseif (mysqli_num_rows($order_query) > 0) {
        echo 'Order already placed!';
    } else {
        $insert_query = "INSERT INTO `orders` (email, Full_name, number, method, address, total_products, total_price, date) VALUES ('$email', '$name', '$number', '$method', '$address', '$total_products', '$cart_total', '$date')";
    
        if (mysqli_query($con, $insert_query)) {

            
            // Update product quantities in the product
        $cart_query = mysqli_query($con, "SELECT * FROM `cart` WHERE email = '$email'") or die('query failed');
        if (mysqli_num_rows($cart_query) > 0) {
            while ($cart_item = mysqli_fetch_assoc($cart_query)) {
                $product_id = $cart_item['pid'];
                $cart_quantity = $cart_item['quantity'];
                mysqli_query($con, "UPDATE `products` SET p_quantity = p_quantity - '$cart_quantity' WHERE id = '$product_id'") or die('query failed');
            }
        }
            // Clear the cart after successful order placement
            mysqli_query($con, "DELETE FROM `cart` WHERE email = '$email'") or die('query failed');
            echo 'Order placed successfully!';
        } else {
            echo 'Failed to place order. Please try again.';
        }
    }
}
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

    <script src="https://kit.fontawesome.com/72f30a4d56.js" crossorigin="anonymous"></script>
    <link rel="icon" href="favIcon.png" type="image/png">
    <link rel="stylesheet" href="css/stal2.css">
    <style>
        .error-container {
            color: lightgreen;
            text-align: center;
            font-weight: bold;
            font-size: 20px;
        }

        .error-container.failed {
            color: lightcoral;
        }
    </style>
</head>

<body>
    <?php @include 'header.php'; ?>

    
    <?php if (isset($_GET['error'])) : ?>
        <?php
        $errorMessage = $_GET['error'];
        $errorClass = ($errorMessage === 'Cart quantity updated!' || $errorMessage === 'All products deleted successfully!' || $errorMessage === 'Product deleted successfully!') ? 'success' : 'failed';
        ?>
        <div class="error-container <?php echo $errorClass; ?>">
            <p class="formerror"><?php echo $errorMessage; ?></p>
        </div>
    <?php endif; ?>
    <section class="heading">
   
        <h3>Your order  collection</h3>
    </section>
    <section class="orders">
        
        <?php
        $grand_total = 0;
        $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE email = '$email'") or die('query failed');
        if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
                $grand_total += $total_price;
        ?>
                <p><?php echo $fetch_cart['name'] ?> <span> : <?php echo ' रु ' . $fetch_cart['price'] . ' * ' . $fetch_cart['quantity']  ?></span></p>
        <?php
            }
        } else {
            echo '<p class="empty">your cart is empty</p>';
        }
        ?>
        <div class="grand-total">Grand Total : <span>रु <?php echo $grand_total; ?></span></div>
    </section>

    <section class="checkout">
        <form action="" method="POST">
            <h3>Your order </h3>
            <div class="orderForm">
            <?php
                $select_user = mysqli_query($con, "SELECT * FROM `registered_user` WHERE email = '$email'") or die('query failed');
                $registered_user = mysqli_fetch_assoc($select_user);
                ?>
                <div class="input">
                    <span>Full Name :</span>
                    <input type="hidden" name="Full_name" class="box" value="<?php echo isset($registered_user['Full_name']) ? $registered_user['Full_name'] : ''; ?>" required>
                    <?php echo isset($registered_user['Full_name']) ? $registered_user['Full_name'] : ''; ?>
                </div>
                <div class="input">
                    <span>Email :</span>
                    <input type="hidden" name="email" class="box" value="<?php echo isset($registered_user['Email']) ? $registered_user['Email'] : ''; ?>" required>
                    <span><?php echo isset($registered_user['Email']) ? $registered_user['Email'] : ''; ?></span>
                </div>
            <div class="input">
            <span>Number :</span>
            <input type="text" id="phone" name="number" pattern="[0-9]{10}" maxlength="10" placeholder="Enter your phone number" required>
            <script>
                // JavaScript numeric validation
                document.getElementById("phone").addEventListener("input", function(evt) {
                    var input = evt.target.value;
                    var numericInput = input.replace(/[^0-9]/, ''); // Remove non-numeric characters

                    if (numericInput.length !== input.length) {
                        evt.target.style.color = "red"; // Set the text color to red for wrong input
                    } else {
                        evt.target.style.color = "green"; // Set the text color to green for correct input
                    }

                    evt.target.value = numericInput;
                });
            </script>
        </div>

             
                <div class="input">
                    <span>country :</span>
                    <input type="text" id="country" name="country" placeholder="Enter country name">
                    <script>
                        // JavaScript numeric validation
                        document.getElementById("country").addEventListener("input", function(evt) {
                            var input = evt.target.value;
                            input = input.replace(/[^A-Za-z ]/g, ''); // Remove non-numeric characters
                            evt.target.value = input;
                        });
                    </script>
                </div>
                <div class="input">
                    <span>District :</span>
                    <input type="text" id="district" name="district" placeholder="Enter district name">
                    <script>
                        // JavaScript numeric validation
                        document.getElementById("district").addEventListener("input", function(evt) {
                            var input = evt.target.value;
                            input = input.replace(/[^A-Za-z ]/g, ''); // Remove numeric characters
                            evt.target.value = input;
                        });
                    </script>
                </div>
               
                <div class="input">
                    <span>Delivery Address :</span>
                    <input type="text" name="address" placeholder="Enter Your Address">
                </div>
                <div class="input">
                    <span>Payment method :</span>
                    <select name="method">
                        <option value="cash on delivery">Cash on delivery</option>
                        <option value="credit card">Credit card</option>
                    </select>
                </div>
                <input type="submit" name="order" value="Order now" class="btn">
            </div>
        </form>
    </section>

    <?php @include 'footer.php'; ?>

</body>

</html>
