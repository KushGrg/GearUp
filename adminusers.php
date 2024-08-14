<?php
require('connection.php');
session_start();

// If trying to login directly to admindashboard
if (!isset($_SESSION['Adminname'])) {
    header("Location: login.php?error=Login first");
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($con, "DELETE FROM `registered_user` WHERE email = '$delete_id'") or die('query failed');
    header('location:adminusers.php');
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

    <div class="users">
        <h1 class="title">Users Account:</h1>

        <table class="user-table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_users = mysqli_query($con, "SELECT * FROM `registered_user`") or die('query failed');
                if (mysqli_num_rows($select_users) > 0) {
                    while ($fetch_users = mysqli_fetch_assoc($select_users)) {
                        ?>
                        <tr>
                            <td><?php echo $fetch_users['Username']; ?></td>
                            <td><?php echo $fetch_users['Email']; ?></td>
                            <td style="color:<?php if ($fetch_users['UserType'] == "Admin" || $fetch_users['UserType'] == "User") {
                                                echo 'red';
                                            }; ?>"><?php echo $fetch_users['UserType']; ?></td>
                            <td>
                            <a href="adminusers.php?delete=<?php echo $fetch_users['Email']; ?>"class="delete-btn">Delete</a>
                            </td>
                        </tr>
                <?php
                    }
                }
                echo'no users';
                ?>
            </tbody>
        </table>

        <div class="delete-box">
            <p>Are you sure you want to delete?</p>
            <button class="confirm-btn">Delete</button>
            <button class="cancel-btn">Cancel</button>
        </div>
    </div>

    <script src="js/adminusersproductdelete.js"></script>
    
</body>

</html>
