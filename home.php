<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

   <section class="category">
      <h1 class="heading">Categories</h1>
</section>
      <section class="category">
      <a href="category.php?category=smartphones" class="slide">
         <img src="images/phone_icon.png" alt="Smart Phones">
         <h3>Smart Phones</h3>
      </a>

      <a href="category.php?category=laptops" class="slide">
         <img src="images/Icon_laptop.png" alt="Laptops">
         <h3>Laptops</h3>
      </a>
      <a href="category.php?category=television" class="slide">
         <img src="images/television.png" alt="Tv image">
         <h3>Televisions</h3>
      </a>
      <a href="category.php?category=cookers" class="slide">
         <img src="images/cooker.png" alt="Cooker">
         <h3>Cookers</h3>
      </a>
      <a href="category.php?category=games" class="slide">
         <img src="images/vrheadset_icon.png" alt="Games image">
         <h3>Games</h3>
      </a>
   </section>

<div class="home-bg">

<section class="home">
   
   <div>

      <div class="slide">
         <div>
            <img src="images/Laptop Pic.jpg" alt=""style="max-width: 100%; height: auto;">
         </div>
         <div class="content">
           
            <h3>Hot off the Shevels Deals</h3>
            <a href="shop.php" class="btn">shop now</a>
         </div>
      </div>

</section>

</div>
<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>