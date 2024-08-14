
<?php

require('connection.php');
session_start();

if(!isset($_SESSION['Adminname'])){
    header("Location: login.php?error=Login first");
}

if(isset($_POST['add_product'])){
   $name = mysqli_real_escape_string($con, $_POST['name']);
   $type = mysqli_real_escape_string($con, $_POST['type']);
   $price = mysqli_real_escape_string($con, $_POST['price']);
   $details = mysqli_real_escape_string($con, $_POST['details']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_product_name = mysqli_query($con, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');
   if ($type == "Select Product type") {
      $error = "Please select a Product type";
      header("Location: adminproduct.php?error=product name already exist!");
  } elseif (!preg_match('/[a-zA-Z]/', $name)) {
   $error = "Product name must contain at letter";
   header("Location: adminproduct.php?error=$error");
  }else
   if(mysqli_num_rows($select_product_name) > 0){
      header("Location: adminproduct.php?error=product name already exist!");
   }else{
      $insert_product = mysqli_query($con, "INSERT INTO `products`(name, type, details, price, image) VALUES('$name', '$type', '$details', '$price', '$image')") or die('query failed');

      if($insert_product){
         if($image_size > 2000000){
            header("Location: adminproduct.php?error=image size is too large!");
         }else {
            move_uploaded_file($image_tmp_name, $image_folder);
            header("Location: adminproduct.php?error=product added successfully!");
         
         
         } 
         
      }
   }
}

// delete section
if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = mysqli_query($con, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($con, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($con, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
   header('location:adminproduct.php?error=product deleted successfully!');

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>
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
   <link rel="stylesheet" href="css/dashboard.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body>
   
<?php @include 'adminheader.php'; ?>
<!-- add product section -->
<section class="add-products">
   <h1 class="title">Add New Product</h1>

   <form class="form" action="" method="POST" enctype="multipart/form-data">
  
      <?php if(isset($_GET['error'])): ?>
   <?php
   $errorMessage = $_GET['error'];
   $errorClass = ($errorMessage === 'product added successfully!' || $errorMessage === 'product deleted successfully!') ? 'success' : 'failed';
   ?>
   <div class="error-container <?php echo $errorClass; ?>">
      <p class="formerror"><?php echo $errorMessage; ?></p>
   </div>
<?php endif; ?>

      <input type="text" class="box" required placeholder="Enter product name" name="name">
      <input type="number" min="0" max="10000" class="box" required placeholder="Enter product price" name="price">
      <input type="number" min="1" max="10000" class="box" required placeholder="Enter product quantity" name="quantity">
      <!-- <input type="text" class="box" required placeholder="Enter product type" name="type"><span class="formerror"></span> -->
      <!-- <label for="dropdown">Select an option:</label> -->
      <!-- <label style="text-align:left">Select a product type:</label> -->
    <select  class="box" name="type"  placeholder="Enter product type" required>
      <option selected>Select Product type</option>
        <option value="Hamp Product">Hamp Product</option>
        <option value="Singing Bowl">Singing Bowl </option>
        <option value="Pasmina">Pasmina</option>
        <option value="Incense">Incense </option>
        <option value="Crafted Stone">Crafted Stone </option>
        <option value="Others">Others</option>
    </select> <span class="formerror"></span>
      <textarea name="details" class="box" required placeholder="Enter product details" cols="30" rows="10"></textarea><span class="formerror"></span>
      <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image"><span class="formerror"></span>
      <input type="submit" value="Add product" name="add_product" class="btn">
   </form>
<!-- display product section -->
   <div class="show-products">
      <div class="box-container">


<h1 class="title">Product Details</h1>
            <table class="user-table">
            <thead>
                <tr>
                    <th>price</th>
                    <th>Product name</th>
                    <th>Product type</th>
                    <th>Quantity</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Update</th>
                    <th>Delete</th>
                  </tr>
            </thead>
            <tbody>
               
         <?php
            $select_products = mysqli_query($con, "SELECT * FROM `products`") or die('query failed');
            if(mysqli_num_rows($select_products) > 0){
               while($fetch_products = mysqli_fetch_assoc($select_products)){
         ?>
                        <tr>
                            <td><div class="price">Rs. <?php echo $fetch_products['price']; ?>/-</div></td>
                            <td><div class="name"><?php echo $fetch_products['name']; ?></div></td>
                            <td><div class="type"><?php echo $fetch_products['type']; ?></div></td>
                            <td><div class="quantity"><?php echo $fetch_products['p_quantity']; ?></div></td>
                            <td><div class="details"><?php echo $fetch_products['details']; ?></div></td>
                            <td><img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt=""></td>
                            <td><a href="adminproductupdate.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">Update</a></td>
                           
                            <td><a href="adminproduct.php?delete=<?php echo $fetch_products['id']; ?>"class="delete-btn">Delete</a>
                            </td>
                        </tr>
                        
                <?php
                    }
                }else{
                  echo '<p class="empty">No products added yet!</p>';
               }
                ?>
            </tbody>
        </table>





       
       
      </div>
   </div>
</section>
<div class="delete-box">
            <p>Are you sure you want to delete?</p>
            <button class="confirm-btn">Delete</button>
            <button class="cancel-btn">Cancel</button>
        </div>
    </div>
<script src="js/adminusersproductdelete.js"></script>

</body>
</html>