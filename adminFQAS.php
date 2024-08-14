<?php
require('connection.php');
session_start();

if (!isset($_SESSION['Aloggedin'])) {
    header("Location: login.php?error=Login first");
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($con, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');
    header('location:adminFQAS.php');
}
if (isset($_POST['update_reply_submit'])) {
   $reply_id = $_POST['mid'];
   $update_reply = $_POST['update_reply'];
   mysqli_query($con, "UPDATE `message` SET Reply = '$update_reply' WHERE id = '$reply_id'") or die('query failed');
   echo 'Reply has been updated!';
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>
   <link rel="stylesheet" href="css/dashboard.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body>
   
<?php @include 'adminheader.php'; ?>
<section>
   <h1 class="title">FQAS :</h1>

   <div class="box-container">
      <?php
      if (isset($_POST['submit'])) {
         $messageID = $_POST['mid'];
         // Get the reply from the form
         $reply = mysqli_real_escape_string($con, $_POST['reply']);
     
         mysqli_query($con, "UPDATE `message` SET Reply = '$reply' WHERE id = '$messageID'") or die('query failed');
     
         // Redirect to the same page to prevent form resubmission
         header("Location: adminFQAS.php");
         exit();
      }

      $select_message = mysqli_query($con, "SELECT * FROM `message`order by id desc") or die('query failed');
      
      if (mysqli_num_rows($select_message) > 0) {
         while ($fetch_message = mysqli_fetch_assoc($select_message)) {
      ?>
         <div class="box">
            <p>Name: <span><?php echo $fetch_message['name']; ?></span></p>
            <p>Email: <span><?php echo $fetch_message['email']; ?></span></p>
            <p>Question: <span><?php echo $fetch_message['question']; ?></span></p>
            <?php if ($fetch_message['Reply']) { ?>
               <p>Reply: <span><?php echo $fetch_message['Reply']; ?></p>
               </form>
               <form action="" method="POST">
                  <input type="hidden" name="mid" value="<?php echo $fetch_message['id']; ?>">
                  <input type="text" name="update_reply" placeholder="Update the reply" required>
                  <input type="submit" value="Update" name="update_reply_submit" class="option-btn">
               </form>
            <?php } else { ?>
               <form action="" method="POST">
                  <input type="hidden" name="mid" value="<?php echo $fetch_message['id']; ?>">
                  <input type="text" name="reply" placeholder="Your reply to this question?" required>
                  <input type="submit" value="Submit" name="submit" class="option-btn" style="background-color:pink;">
              
            <?php } ?>
          
            <!-- <input type="submit" name="update_reply" value="Update" class="option-btn"> -->
            <a href="adminFQAS.php?delete=<?php echo $fetch_message['id']; ?>" class="delete-btn">Delete</a>
         </div>
      <?php
         }
      } else {
         echo '<p class="empty">You have no messages!</p>';
      }
      ?>
   </div>
</section>
<div class="delete-box">
   <p>Are you sure you want to delete?</p>
   <button class="confirm-btn">Delete</button>
   <button class="cancel-btn">Cancel</button>
</div>
<script src="js/adminusersproductdelete.js"></script>
</body>
</html>
