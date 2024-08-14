<?php
require_once "connection.php";
if(isset($_POST['add'])){
    $quote = $_POST['quote'];


    $query = "INSERT INTO quote (quote) values('$quote')";
    $exec = mysqli_query($conn,$query);
    if($exec){
        echo"<br>Inserted successfully";
    }
    else{
        echo"Vayena Vayena";

    }



}




