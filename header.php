<?php
require('connection.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head> 
<script src="https://kit.fontawesome.com/72f30a4d56.js" crossorigin="anonymous"></script>
    <link rel="icon" href="favIcon.png" type="image/png">
    <link rel="stylesheet" href="css/stal.css?v=5">
</head>
<body>

<section id="header">
        <div class="logo--">
            <a href="index.php"><img src="img/Hastakalalogo.jpg.png" class="logo" height="50px" alt=""> </a>

        </div>
        <div class="search-container">

            <form action="search.php" method="POST">

                <input type="text" name="searchKeyword" id="search-input" placeholder="Search">
                <button type="submit" name="search" class="search-icon"><i class="fas fa-search"></i></button>
            </form>

          </div>
           

        <div>


        <div>

            <ul id="navbar">
                <li><a  href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="product.php">Product</a></li>
                <li><a href="FAQs.php">FAQs</a></li>
                <li><a href="contact.php">contact</a></li>

                <?php
                if(isset($_SESSION['loggedin']) ==true)    
                {
                        echo'<li><a href="logout.php">Logout</a></li>';
                        $user = $_SESSION['fullname'];
                        echo $user;
                        ?>
                        
                        <?php
                        

                }
                else{
                    echo'<li><a href="login.php">Login</a></li>';
                     }
                    ?>
               <li> <a href="cart.php"> <i class="fa-solid fa-cart-shopping"></i></a></li>
            </ul>
        </div>
         </div>
         <?php
                if(isset($_SESSION['loggedin']) ==true)    
                {?>
         <div class="name_logo">
             <p id="name_log">
             <?php
                 $email = $_SESSION['useremail'];
                 $trimmedemail = trim($email); // Trim any whitespace from the beginning and end of the user's full name
                 $firstLetter = substr($trimmedemail, 0, 1); // Retrieve the first character of the trimmed user's full name
                 $firstLetterCap = ucfirst($firstLetter);
                 echo $firstLetterCap;
             ?>
            </p>
        </div>
               <?php }?>
    </section>
</body>
</html>

                <!-- // if(isset($_SESSION['loggedin']) ==true)    
                // {
                        // echo"<li><a id='user_btn' class='fas fa-user'>Logout</a></li>";
                // }
                // else{
                    // echo"<li><a id='lr_btn' class='fas fa-user'></a></li>";
                    //  } -->
                <!-- ?>
               <li> <a href="#MainCart"> <i class="fa-solid fa-cart-shopping"></i></a></li>
            </ul>
        </div>
    </section>
    <div class="loginregister-box">
        <a href="login.php" class="delete-btn">Login</a>
        <a href="register.php" class="delete-btn">Register</a>
    </div> -->

    <!-- also user logout popup box manage  -->
    <!-- <script src="user.js"></script>
    <script src="js/admin.js"></script> --> 
