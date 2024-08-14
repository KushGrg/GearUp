<?php
require('connection.php');
session_start();
if(isset($_SESSION['username'])){
    $email = $_SESSION['useremail'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <script src="https://kit.fontawesome.com/72f30a4d56.js" crossorigin="anonymous"></script>
    <link rel="icon" href="favIcon.png" type="image/png">
    <link rel="stylesheet" href="css/stal.css">
    <style>
.leftHero button a{
    text-decoration:none;
    background-color: transparent;
    color: #fbfcfc;
    border: 0;
    padding: 14px 80px 14px 55px;
    cursor: pointer;
    font-weight: 700;
    font-size: 15px;
    z-index: 3;
}
.leftHero button a:hover{
    color: #088178;
    transition: 0.5s;
}
        </style>
</head>
<body>
<?php
    @include 'header.php';
    ?>
    <section id="hero">
        <div class="leftHero">
            <h4>Trade-in-offer</h4>
            <h2>super value deals</h2>
            <h1>on all products</h1>
            <p>save more with coupons & up to 70% off!</p>
            <button><a href="product.php">shop Now</a></button>
            <img src="img/Img3.png" alt="" height="90px" width="150px">

        </div>

    </section>
    <section class="category-title">
        <h1>Categories</h1>

    </section>
    <section id="categories" class="categories-p1">
        <?php
        $select_product_types = mysqli_query($con, "SELECT DISTINCT type FROM `products`") or die('query failed');
        if (mysqli_num_rows($select_product_types) > 0) {
            while ($fetch_product_types = mysqli_fetch_assoc($select_product_types)) {
                $product_type = $fetch_product_types['type'];

                $select_product_image = mysqli_query($con, "SELECT image FROM `products` WHERE type = '$product_type' LIMIT 1") or die('query failed');
                $fetch_product_image = mysqli_fetch_assoc($select_product_image);
                $image_path = 'uploaded_img/' . $fetch_product_image['image'];

                ?>
                <div class="fe-box" onclick='window.location.href="product.php#<?php echo $product_type; ?>"'>

                        <img src="<?php echo $image_path; ?>" alt="<?php echo $product_type; ?>" height="120px" width="100px">
                        <h4><?php echo $product_type; ?></a></h4>
                    </a>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">No product types found!</p>';
        }
        ?>


    </section>
    <section class="hotselling-title">
        <h2>Hot Selling!!!</h2>
        <p>Top collection</p>
    </section>
        <section id="hotselling" class="categories-p1" >
      <?php

         $select_products = mysqli_query($con, "SELECT * FROM `products` ORDER BY id DESC LIMIT 10") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
        ?>
            <form action="" method="POST" class="hot-box" onclick="window.location.href='view.php?pid=<?php echo $fetch_products['id']; ?>'">
          <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="flower" height="120px" width="100 px" class="image">
          <h4><div class="name"><?php echo $fetch_products['name']; ?></div></h4>
          <h5><div class="type"><?php echo $fetch_products['type']; ?></div></h5>
          <h3><div class="price">रु‎<?php echo $fetch_products['price']; ?>/-</div></h3>
          <h6><a href="view.php?pid=<?php echo $fetch_products['id']; ?>" class="view"><i class="fas fa-eye" ></i></a></h6>
          <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
          <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
          <input type="hidden" name="product_type" value="<?php echo $fetch_products['type']; ?>">
          <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
          <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
          
          </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

</div>
    </section>
    <!-- <section id="fun-fact">
        <h1>Random Fact!!!</h1>
        <div class="factText">
            <h3>
            <?php @include 'quote.php';?>
        </h3>
        </div>
    </section> -->
    <?php
    @include 'footer.html';
    ?>
</body>
</html>