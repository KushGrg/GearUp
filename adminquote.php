<?php
include "connection.php";
if(isset($_POST['add'])){
    $quote = $_POST['quote'];


    $query = "INSERT INTO quote (quote) values('$quote')";
    $exec = mysqli_query($con,$query);
    if($exec){
        echo"<br>Inserted successfully";
    }
    else{
        echo"Vayena Vayena";

    }



}?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>quote</title>
    <style>

  
.quott {

  height:40%;
  width: 100%;
  margin: 2px ;
  margin-left:5px;
  align-items: center;
  /* padding: 10px; */
  /* display:flex; */
  /* background-color: #f2f2f2; */
}
.box {
  width: 40%;
  margin-top: 50px;
  margin-left: 50px;
  padding: 20px;
  background-color: #f2f2f2;
  border: 1px solid #ccc;
}

label {
  font-weight: bold;
  /* margin-bottom: 10px; */
}

.input{
  width: 100%;
  height: 100px;
  padding: 5px;
  margin-bottom: 10px;
  margin-top: 10px;
}

.option_btn {
  background-color: #4CAF50;
  color: white;
  padding: 9px 20px;
  border: none;
  cursor: pointer;
}

.option_btn:hover {
  background-color: #45a049;
}




        </style>
   <link rel="stylesheet" href="css/dashboard.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body>
   
    <?php @include 'adminheader.php'; ?>
    <div class="quott">
<h1 class="title">Add New Quote : </h1>
<div class="box">
    
    <form action="" method="POST" ><br/>
        <label for="addqoute" >Quote::</label>
        <input type="textarea" placeholder="add quote" name="quote" class="input"><br/>
        <input type="submit" name="add" value="Add" class="option_btn">
    </form>
</div>
</div>
</body>
</html>