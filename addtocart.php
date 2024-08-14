<?php

@include 'connection.php';

// session_start();

// $email = $_SESSION['useremail'];

// if(!isset($email)){
//    header('location:login.php?error:You need to Login First !!');
// };

session_start();
if(!isset($_SESSION['username'])){
    header('location:login.php?error=You need to Login first!!');
}else{
    $email = $_SESSION['useremail'];
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($con, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('location:cart.php?error=product deleted successfully!');
}

if(isset($_GET['delete_all'])){
    mysqli_query($con, "DELETE FROM `cart` WHERE email = '$email'") or die('query failed');
    header('location:cart.php?error=All product deleted successfully!');
};

if(isset($_POST['update_quantity'])){
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($con, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
    header("Location: cart.php?error=cart quantity updated!");

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <script src="https://kit.fontawesome.com/72f30a4d56.js" crossorigin="anonymous"></script>
    <link rel="icon" href="favIcon.png" type="image/png">
    <link rel="stylesheet" href="css/stal2.css">
    <style>
        
        .error-container {
         /* text-align: center; */
         /* margin: 10px 0; */
         }

      .error-container.success {
         background-color: lightgreen;
          }

      .error-container.failed {
         background-color: lightcoral;
         }
         .disabled {
  opacity: 0.5; /* Adjust the styling as per your requirements */
  pointer-events: none;
  cursor: not-allowed;
}
    
    </style>
</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
</section>

<section class="shopping-cart">

    <h1 class="title">products added</h1>

    <div class="box-container">
    <?php
                  if(isset($_GET['error'])): ?>
                    <?php
                    $errorMessage = $_GET['error'];
                    $errorClass = ($errorMessage === 'cart quantity updated!'||$errorMessage === 'All product deleted successfully!'||$errorMessage === 'product deleted successfully!') ? 'success' : 'failed';
                    ?>
                    <div class="error-container <?php echo $errorClass; ?>">
                       <p class="formerror"><?php echo $errorMessage; ?></p>
                    </div>
                    <?php endif; ?>
    <?php
        $grand_total = 0;
        $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE email = '$email'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
    ?>
    <div  class="box">
        <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="" class="image">
        <div class="name"><?php echo $fetch_cart['name']; ?></div>
        <div class="price">₹<?php echo $fetch_cart['price']; ?>/-</div>
        <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="delete-btn" onclick="return confirm('delete this from cart?');">Delete</a>
        <form action="" method="post">
            <input type="hidden" value="<?php echo $fetch_cart['id']; ?>" name="cart_id">
            <input type="number" min="1" value="<?php echo $fetch_cart['quantity']; ?>" name="cart_quantity" class="qty">
            <input type="submit" value="update" class="option-btn" name="update_quantity">
        </form>
        <div class="sub-total"> sub-total : <span>रु<?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
    </div>
    <?php
    $grand_total += $sub_total;
        }
    }else{
        echo '<p class="empty">your cart is empty</p>';
    }
    ?>
    </div>

    <div class="more-btn">
        <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled' ?>" onclick="return confirm('delete all from cart?');">delete all</a>
    </div>

    <div class="cart-total">
        <p>grand total : <span>रु<?php echo $grand_total; ?>/-</span></p>
        <a href="product.php" class="option-btn">continue shopping</a>
        <a href="order.php" class="btn  <?php echo ($grand_total > 1)?'':'disabled' ?>">order</a>
    </div>

</section>






<?php @include 'footer.html'; ?>

<div class="delete-box">
            <p>Are you sure you want to delete?</p>
            <button class="confirm-btn">Delete</button>
            <button class="cancel-btn">Cancel</button>
        </div>
    </div>

    <script src="js/adminusersproductdelete.js"></script>
</body>
</html>

