
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login And Registration</title>
   <link rel="stylesheet" href="css/register.css?v=10">
    <style>
           
            .formerror{

                color:red;
                text-align: center;
                margin-bottom: -20px;
                margin-top: 5px;
                

            }
        
        </style>
</head>
<body>
<?php
    @include 'header.php';
    ?>
<div class="popup-container" id="registerpopup" >
    <div class="popup">
    <form action ="login_register.php" name="myForm" onsubmit="return validateForm()" method="post">


                            <h2>User Register</h2>
                  
                
                <?php
                if(isset($_GET['error'])){?>
                    <p class="formerror" >*<?php echo $_GET['error'];?></p>
               <?php };
                ?>
      
            <div class="input_boxR" id="fullname">
                 <i class="fa-solid fa-user"></i>
                 <input type="text" placeholder="Enter Full Name" name="fullname" id="Fullname"> 
            </div>
            <div class="input_boxR" id="username">
                <i class="fa-solid fa-user"></i>
                <input type="text" placeholder="Enter User Name" name="username" ><br/>
            </div>
            <div class="input_boxR" id="email">
            <i class="fa-solid fa-envelope"></i>
                <input type="email" placeholder="Enter Email" name="email"  /><br/>
            </div>
            <div class="input_boxR"id="password">
            <i class="fa-solid fa-lock"></i>
                <input type="password" placeholder="Password" name="password" />
            </div>
            <div class="input_boxR" id="cpassword">
            <i class="fa-solid fa-lock"></i>
                <input type="password" placeholder="Confirm Password" name="cpassword" />
                <!-- <input type="hidden" value="User" name="type" readonly /><br/> -->
            </div>
                <button type="Submit" id="RegButton" name="register" >Register Now</button>
                <div id="Register_signup">Already have account ? <a href="login.php">Login now</a></div>

    </form>
        </div>
        </div>
</body>

</html>

