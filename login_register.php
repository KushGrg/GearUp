<?php
require('connection.php');
session_start();

if (isset($_POST['login'])) {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        function validate($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $email = validate($_POST['email']);
        $pass = validate($_POST['password']);

        if (empty($email) || empty($pass)) {
            header("Location: login.php?error=Please fill all the fields!!");
            exit();
        } else {
            $query = "SELECT * FROM `registered_user` WHERE `Email`='$email'";
            $result = mysqli_query($con, $query);
            if ($result) {
                if (mysqli_num_rows($result) == 1) {
                    $result_fetch = mysqli_fetch_assoc($result);
                    if (password_verify($pass, $result_fetch['Password'])) {
                        echo "Correct Password";
                        if ($result_fetch['UserType'] == "Admin" || $result_fetch['UserType'] == "admin") {
                            $_SESSION['Aloggedin'] = true;
                            $_SESSION['Adminname'] = $result_fetch['Username'];
                            $_SESSION['Adminemail'] = $result_fetch['Email'];
                            header("location: dashboard.php");
                            exit();
                        } else {
                            $_SESSION['loggedin'] = true;
                            $_SESSION['username'] = $result_fetch['Username'];
                            $_SESSION['useremail'] = $result_fetch['Email'];
                            header("location: index.php");
                            exit();
                        }
                    } else {
                        header("Location: login.php?error=Incorrect password");
                        exit();
                    }
                } else {
                    header("Location: login.php?error=Email not registered");
                    exit();
                }
            } else {
                header("Location: login.php?error=Cannot run query");
                exit();
            }
        }
    } else {
        header("Location: login.php?error=Please fill all the fields!!");
        exit();
    }
}

if (isset($_POST['register'])) {
    if (isset($_POST['fullname']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['cpassword'])) {
        function validate($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $fname = validate($_POST['fullname']);
        $uname = validate($_POST['username']);
        $email = validate($_POST['email']);
        $pass = validate($_POST['password']);
        $cpass = validate($_POST['cpassword']);

        if (empty($fname) || empty($uname) || empty($email) || empty($pass) || empty($cpass)) {
            header("Location: register.php?error=Please fill all the fields!!");
            exit();
        }elseif (!preg_match('/^[a-zA-Z]+(?: [a-zA-Z]+)*$/', $fname)) {
                $error = "Name must be letter";
            header("Location: register.php?error=$error");
           }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: register.php?error=Invalid email format!!");
            exit();
        } elseif ($pass != $cpass) {
            header("Location: register.php?error=password and confirm password do not match!!");
            exit();
        } else {
            $user_exist_query = "SELECT * FROM `registered_user` WHERE `Username`='$uname' OR `Email`='$email'";
            $result = mysqli_query($con, $user_exist_query);
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    $result_fetch = mysqli_fetch_assoc($result);
                    if ($result_fetch['Username'] == $uname) {
                        header("location:register.php?error=$result_fetch[Username] - User already exists");
                        exit();
                    } else {
                        header("location:register.php?error=$result_fetch[Email] - Email already exists");
                        exit();
                    }
                } else {
                    $password = password_hash($pass, PASSWORD_BCRYPT); //encrypting password using bcrypt algorithm
                    // $cpassword = password_hash($cpass, PASSWORD_BCRYPT); //encrypting confirm password using bcrypt algorithm

                    $query = "INSERT INTO `registered_user`(`Full_name`, `Username`, `Email`, `Password`, `UserType`) VALUES ('$fname','$uname','$email','$password','$_POST[type]')";
                    if (mysqli_query($con, $query)) {
                        header("location: login.php?error=Registration successful! you can now login!!");
                        exit();
                    } else {
                        header("location:register.php?error=Registration failed");
                        exit();
                    }
                }
            }
        }
    } else {
        header("location:register.php");
        exit();
    }
}
?>
