<?php

@include 'connection.php';

session_start();
if(isset($_SESSION['username'])){
    $email = $_SESSION['useremail'];
}


if(isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_availableQuantity = $_POST['product_availableQuantity'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($con, "SELECT * FROM `cart` WHERE name = '$product_name' AND email = '$email'") ;

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        header("Location: view.php?error=Already added to cart");
    } elseif ($product_quantity > $product_availableQuantity) {
        // Requested quantity exceeds the available quantity, display error message
        header("Location: view.php?error=Requested quantity exceeds available quantity in stock!!");
        exit();
    } else {
        mysqli_query($con, "INSERT INTO `cart` (email, pid, name, price, quantity, image) VALUES ('$email', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        header("Location: view.php?error=Product added to cart");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>search page</title>
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

<section class="quick-view">
    <?php
    if(isset($_GET['error'])): ?>
        <?php
        $errorMessage = $_GET['error'];
        $errorClass = ($errorMessage === 'Product added to cart') ? 'success' : 'failed';
        ?>
        <div class="error-container <?php echo $errorClass; ?>">
            <p class="formerror"><?php echo $errorMessage; ?></p>
        </div>
    <?php endif; ?>






      <?php
        if(isset($_POST['search'])){
         $search_box = mysqli_real_escape_string($con, $_POST['searchKeyword']);
         $select_products = mysqli_query($con, "SELECT * FROM `products` WHERE name LIKE '%{$search_box}%'") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <form action="" method="POST" class="viewbox">
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image"><br/>
         <div class="detail">
         <div class="name"><label class="label">Name : </label><?php echo $fetch_products['name']; ?></div>
        <div class="type"><label class="label">Product Type : </label><?php echo $fetch_products['type']; ?></div>
          <div class="price"><label class="label">Price : </label>₹<?php echo $fetch_products['price']; ?>/-</div>
        <div class="cart-qty"> <?php
         
                if(isset($_SESSION['loggedin']) ==true)    
                {
                    echo'<input type="number" name="product_quantity" value="1" min="1" class="qty"><br/>';
                        echo'<input type="submit" value="Add to cart" name="add_to_cart" class="btn">';
                }
                
             ?>
             </div>
        <div class="details"><label class="label">Product Detail: </label><?php echo $fetch_products['details']; ?></div>
        <!-- <input type="number" name="product_quantity" value="1" min="0" class="qty"><br/> -->
         <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
         <input type="hidden" name="product_type" value="<?php echo $fetch_products['type']; ?>">
         <input type="hidden" name="product_availableQuantity" value="<?php echo $fetch_products['p_quantity']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
         <!-- <input type="submit" value="add to cart" name="add_to_cart" class="btn"> -->

             </div>

      </form>
    <?php
            }
        }else{
            echo '<p style="margin-left: 25%;">Sorry, ' . $_POST['searchKeyword'] . ' products is currently unavailable!</p>';
        }
        
    }
    ?>

    <!-- <div class="option-btn">
        <a href="product.php" class="option-btn">Back</a>
    </div> -->
    <div class="option-btn">
   <!-- <a href="javascript:history.back();" class="option-btn">Continue Shopping</a> -->
   <a href="product.php" class="option-btn">Continue Shopping</a>
</div>

</section>






<?php @include 'footer.html'; ?>


</body>
</html>