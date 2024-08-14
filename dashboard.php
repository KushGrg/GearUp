
<?php
require('connection.php');
session_start();
//if try to login directly to admindashboard
    if(!isset($_SESSION['Adminname'])){
        header("Location: login.php?error=Login first");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>
   <link rel="stylesheet" href="css/dashboard.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

</head>
<body>
   
<?php @include 'adminheader.php'; ?>

<section class="dashboard">

   <h1 class="title">Admin Dashboard : </h1>

   <div class="box-container">

      <div class="box">
         
         <p>Pending payments</p><br/>
         <?php
            $select_status = mysqli_query($con, "SELECT status FROM `orders` where status='pending'") or die('query failed');
            $pending_status = mysqli_num_rows($select_status);
         ?>
         <h3><?php echo $pending_status; ?></h3>
      </div>
   

      <div class="box">
         
         <p>Completed payments</p><br/>
         <?php
            $select_status = mysqli_query($con, "SELECT status FROM `orders` where status='completed'") or die('query failed');
            $pending_status = mysqli_num_rows($select_status);
         ?>
         <h3><?php echo $pending_status; ?></h3>
      </div>

      <div class="box">
        
         <p>Orders placed</p><br/>
         <?php
            $orders = mysqli_query($con, "SELECT * FROM `orders` ") or die('query failed');
            $number_of_orders = mysqli_num_rows($orders);
         ?>
         <h3><?php echo $number_of_orders; ?></h3>
     
      </div>

      <div class="box">
         <p>Products added</p><br/>
         <?php
            $select_products = mysqli_query($con, "SELECT * FROM `products`") or die('query failed');
            $number_of_products = mysqli_num_rows($select_products);
         ?>
         <h3><?php echo $number_of_products; ?></h3>
      </div>

      <div class="box">
         <p>Normal users</p><br/>
      <?php
            $users = mysqli_query($con, "SELECT * FROM `registered_user` WHERE UserType = 'user'") or die('query failed');
            $numofusers = mysqli_num_rows($users);
         ?>
         <h3><?php echo $numofusers; ?></h3>
      </div>

      <div class="box">
         <p>Admin users</p><br/>
      <?php
            $admin = mysqli_query($con, "SELECT * FROM `registered_user` WHERE UserType = 'Admin'") or die('query failed');
            $numofadmin = mysqli_num_rows($admin);
         ?>
         <h3><?php echo $numofadmin; ?></h3>
      </div>

      <div class="box">
         <p>Total accounts</p><br/>
      <?php
            $totalaccount = mysqli_query($con, "SELECT * FROM `registered_user`") or die('query failed');
            $numofaccount = mysqli_num_rows($totalaccount);
         ?>
         <h3><?php echo $numofaccount; ?></h3>
      </div>

      <div class="box">
      <p>New messages</p><br/>
      <?php
            $select_messages = mysqli_query($con, "SELECT * FROM `message`") or die('query failed');
            $number_of_messages = mysqli_num_rows($select_messages);
         ?>
         <h3><?php echo $number_of_messages; ?></h3>
         
      </div>
      <div class="box">
      <p>Quotes</p><br/>
      
      <?php
            $select_quote = mysqli_query($con, "SELECT * FROM `quote`") or die('query failed');
            $number_of_quote = mysqli_num_rows($select_quote);
         ?>
         <h3><?php echo $number_of_quote; ?></h3>
      </div>


   </div>


  

</section>



</body>
</html>