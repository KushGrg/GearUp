<?php
require('connection.php');
session_start();
if(isset($_SESSION['username'])){
    $email = $_SESSION['useremail'];
}
// else{
//     header("Location: login.php?error=Login first");
// }?>
 <?php




if(isset($_POST['add_to_cart'])){

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    // $check_cart_numbers = mysqli_query($con, "SELECT * FROM `cart` WHERE name = '$product_name'") or die('query failed');
    $check_cart_numbers = mysqli_query($con, "SELECT * FROM `cart` WHERE name = '$product_name' AND email = '$email'") or die('query failed');

    if(mysqli_num_rows($check_cart_numbers) > 0){
        // "error=Already added to cart";
        header("Location: product.php?error=Already added to cart");
        
    }else{
        
        
        mysqli_query($con, "INSERT INTO `cart`(email,pid, name, price, quantity, image) VALUES('$email','$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        header("Location: product.php?error=product added to cart");
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>product</title>
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
    
    </style>
</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>Catagories</h3>
</section>

<section class="products">

<?php
    if(isset($_GET['error'])): ?>
      <?php
      $errorMessage = $_GET['error'];
      $errorClass = ($errorMessage === 'product added to cart'||$errorMessage === 'Product added to cart') ? 'success' : 'failed';
      ?>
      <div class="error-container <?php echo $errorClass; ?>">
         <p class="formerror"><?php echo $errorMessage; ?></p>
      </div>
      <?php endif; ?>
   <div class="box-container">
  
      <?php

         $select_products = mysqli_query($con, "SELECT * FROM `products`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
        ?>
      <form action="" method="POST" class="box" >
          <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
          <div class="price">₹<?php echo $fetch_products['price']; ?>/-</div>
          <div class="name"><?php echo $fetch_products['name']; ?></div>
          <!-- <div class="type"><?php echo $fetch_products['type']; ?></div> -->
          <a href="view.php?pid=<?php echo $fetch_products['id']; ?>" class="view">view</a>
          <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
          <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
          <input type="hidden" name="product_type" value="<?php echo $fetch_products['type']; ?>">
          <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
          <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
          
          <?php
                if(isset($_SESSION['loggedin']) ==true)    
                {
                    echo'<input type="number" name="product_quantity" value="1" min="0" class="qty"><br/>';
                        echo'<input type="submit" value="add to cart" name="add_to_cart" class="btn">';
                }
                
             ?>

         <!-- <input type="submit" value="add to cart" name="add_to_cart" class="btn"> -->
      </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

   </div>

</section>






<?php @include 'footer.php'; ?>


</body>
</html>


















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
    $product_availableQuantity=$_POST['product_availableQuantity'];
    if ($cart_quantity > $product_availableQuantity) 
    {
    // Requested quantity exceeds the available quantity, display error message
    header("Location: cart.php?error=Requested quantity exceeds available quantity in stock!!");
    exit();
    } 
    else
    {
    mysqli_query($con, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
    header("Location: cart.php?error=cart quantity updated!");
    }
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
         /* background-color: lightgreen; */
         color:lightgreen;
         text-align:center;
         font-weight: bold;
          font-size: 20px;
         
          }

      .error-container.failed {
         /* background-color: lightcoral; */
         color:lightcoral;
         text-align:center;
         font-weight: bold;
         font-size: 20px;
         }
         .disabled {
        opacity: 0.5; /* Adjust the styling as per  requirements */
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
            <input type="hidden" name="product_availableQuantity" value="<?php echo $fetch_cart['p_quantity']; ?>">
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


</body>
</html>

