<?php

    include "connection.php";

    function getRandomQuote(){
        global $con;  

        $query = "Select quote from quote";
        $exec = mysqli_query($con,$query);
        $arr=array();
        while($quoteArray = mysqli_fetch_assoc($exec)){
            array_push($arr,$quoteArray);
        }

        $randomNum = rand(0,sizeof($arr)-1);
        
        
        return $arr[$randomNum]['quote'];
        
    }

 



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .display{
            height: 30wh;
            width: 100%;
            background-color: aliceblue;
        }
    </style>

    <title>Document</title>
</head>
<body>
    <div class="display">
        <?= getRandomQuote()?>

    </div>
</body>
</html>