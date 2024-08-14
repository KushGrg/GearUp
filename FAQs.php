<?php
require('connection.php');
// session_start();
// if(!isset($_SESSION['username'])){
//     header('location:login.php?error=You need to Login first!!');
// }else{
//     $email = $_SESSION['useremail'];
// }

session_start();
$email = '';
if(isset($_SESSION['username'])){
    $email = $_SESSION['useremail'];
}


// Fetch user information and assign it to $registered_user
// $select_user = mysqli_query($con, "SELECT * FROM `registered_user` WHERE email = '$email'") or die('query failed');
$select_user = mysqli_query($con, "SELECT * FROM `registered_user` where email='$email'") or die('query failed');
$registered_user = mysqli_fetch_assoc($select_user);
if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $msg = mysqli_real_escape_string($con, $_POST['message']);

    $select_message = mysqli_query($con, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND question = '$msg'") or die('query failed');

    if(mysqli_num_rows($select_message) > 0){
        echo 'message sent already!';
    }else{
        mysqli_query($con, "INSERT INTO `message`( name, email , question) VALUES( '$name', '$email', '$msg')") or die('query failed');
        echo'message sent successfully!';
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
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
</head>
<body>
    <?php @include 'header.php'; ?>
    
    <section class="fqas">
    <?php 
   
        if ($email) { // Check if user is logged in ?>
    <form action="" method="POST">

        <h3>Your Queries!</h3>
        <input type="hidden" name="name" placeholder="enter your name" class="box" value="<?php echo isset($registered_user['Username']) ? $registered_user['Username'] : ''; ?>" required> 
        <input type="hidden" name="email" placeholder="enter your email" class="box" value="<?php echo isset($registered_user['Email']) ? $registered_user['Email'] : ''; ?>" required>
        <textarea name="message" class="box" placeholder="enter your question" required cols="90" rows="1"></textarea>
        <input type="submit" value="Send" name="submit" class="btn">
    </form>
    <?php } else { ?>
        <p>Please log in to ask Questions .<a href="login.php">Login Now</a></p>
    <?php } ?>
    </section>

    <section>
<h1 class="title">Frequently Asked Question :</h1>

   <div class="box-container">
<?php

 
        $select_message = mysqli_query($con, "SELECT * FROM `message` WHERE Reply IS NOT NULL ORDER BY id DESC LIMIT 5") or die('query failed');
        if (mysqli_num_rows($select_message) > 0) {
            while ($fetch_message = mysqli_fetch_assoc($select_message)) {
                // Display the messages
                echo '<div class="box">';
                echo '<p>User: <span>' . $fetch_message['name'] . '</span></p>';
                // echo '<p>Email: <span>' . $fetch_message['email'] . '</span></p>';
                echo '<p><span>' . $fetch_message['question'] . '</span></p>';
                echo '<p>Reply: <span>' . $fetch_message['Reply'] . '</span></p>';
                echo '</div>';
            }
        } else {
            echo '<p class="empty">No Question Answers!</p>';
        }
    


      ?>
   </div>
</section>
</body>
</html>
