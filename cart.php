<?php

@include 'connection.php';

session_start();
if(!isset($_SESSION['username'])){
    header('location:login.php?error=You need to Login first!!');
} else {
    $email = $_SESSION['useremail'];
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($con, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('location:cart.php?error=Product deleted successfully!');
}

if(isset($_GET['delete_all'])){
    mysqli_query($con, "DELETE FROM `cart` WHERE email = '$email'") or die('query failed');
    header('location:cart.php?error=All products deleted successfully!');
};

if(isset($_POST['update_quantity'])){
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    $product_availableQuantity = $_POST['product_availableQuantity'];
    
    if ($cart_quantity > $product_availableQuantity) {
        header("Location: cart.php?error=Requested quantity exceeds available quantity in stock!!!");
        exit();
    } else {
        mysqli_query($con, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
        header("Location: cart.php?error=Cart quantity updated!");
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
    <link rel="stylesheet" href="css/stal2.css?v=2">
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

        .disabled {
            opacity: 0.5;
            pointer-events: none;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading"></section>

<section class="shopping-cart">
    <h1 class="title">Cart</h1>
    <div class="box-container">
        <?php if(isset($_GET['error'])): ?>
            <?php
            $errorMessage = $_GET['error'];
            $errorClass = ($errorMessage === 'Cart quantity updated!' || $errorMessage === 'All products deleted successfully!' || $errorMessage === 'Product deleted successfully!') ? 'success' : 'failed';
            ?>
            <div class="error-container <?php echo $errorClass; ?>">
                <p class="formerror"><?php echo $errorMessage; ?></p>
            </div>
        <?php endif; ?>

        <?php
        $grand_total = 0;
        $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE email = '$email'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0) {
            while($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                $product_id = $fetch_cart['pid'];
                $select_product = mysqli_query($con, "SELECT p_quantity FROM `products` WHERE id = '$product_id'") or die('query failed');
                if(mysqli_num_rows($select_product) > 0) {
                    $fetch_product = mysqli_fetch_assoc($select_product);
                    $product_availableQuantity = $fetch_product['p_quantity'];
                }
                else {
                    $product_availableQuantity = 0;
                }
        ?>
        <div class="box">
            <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="" class="image">
            <div class="name"><?php echo $fetch_cart['name']; ?></div>
            <div class="price">₹<?php echo $fetch_cart['price']; ?>/-</div>
                 <div id="deletebuttonbox">
                 <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="delete-btn" onclick="return confirm('Delete this from cart?');">Delete</a>
            <!-- <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>"class="delete-btn">Delete</a> -->

                 </div>
            
            
            <form action="" method="post">
                <input type="hidden" value="<?php echo $fetch_cart['id']; ?>" name="cart_id">
                <input type="hidden" name="product_availableQuantity" value="<?php echo $product_availableQuantity; ?>">
                <input type="number" min="1" value="<?php echo $fetch_cart['quantity']; ?>" name="cart_quantity" class="qty">
                <input type="submit" value="Update" class="option-btn" name="update_quantity">
            </form>
            <div class="sub-total"> sub-total : <span>रु<?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
        </div>
        <?php
            $grand_total += $sub_total;
            }
        }
        else {
            echo '<p class="empty">Your cart is empty</p>';
        }
        ?>
    </div>
    <div class="cart-more-option">

          <div class="more-btn">
        <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('Delete all from cart?');">Delete all</a>
          </div>

         <div class="cart-total">
        <p>Grand total : <span>रु<?php echo $grand_total; ?>/-</span></p>
        <a href="product.php" class="option-btn">Continue shopping</a>
        <a href="order.php" class="btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">Order</a>
         </div>
    </div>
</section>

<?php @include 'footer.html'; ?>
</body>
</html>
