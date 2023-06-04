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
   <title>Search Products</title>

   <link rel="stylesheet" href="css/style.css">
   <style>
      .wishlistbtn {
  background-color: green; 
  border: none; 
  color: white; 
  padding: 10px 20px; 
  text-align: center; 
  text-decoration: none;
  display: inline-block; 
  font-size: 16px; 
  cursor: pointer; 
  border-radius: 4px; 
}

.wishlistbtn:hover {
  background-color: #45a049; 
}
.product-details {
   background-color: lightblue;
   color: blue;
   padding: 10px;
   margin-top: 10px;
   border: 1px solid blue;
   border-radius: 5px;
   font-family: Arial, sans-serif;
   font-size: 15px; 
}

.product-details h2 {
   font-size: 19px; 
   margin-bottom: 5px;
}

.product-details p {
   font-size: 18px; 
   margin-top: 0;
   line-height: 1.5;
}
</style>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search_box" placeholder="Search Products..." maxlength="100" class="box" required>
      <button type="submit" name="search_btn">Search</button>
   </form>
</section>

<section class="products" style="padding-top: 0; min-height:100vh;">

   <div class="box-container">

   <?php
     if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
     $search_box = $_POST['search_box'];
     $select_products = $conn->prepare("SELECT * FROM `inventory` WHERE Product_Name LIKE '%{$search_box}%'"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>

   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['Product_Name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['Product_Price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['Product_Image']; ?>">
      <button type="submit" class= "wishlistbtn" name="add_to_wishlist">WishList</button>
      <img src="uploaded_img/<?= $fetch_product['Product_Image']; ?>" alt="">
      <div class="name"><?= $fetch_product['Product_Name']; ?></div>
      <div class="product-details"><?= $fetch_product['Product_Description']; ?></div>
      <div class="flex">
         <div class="price"><span>R</span><?= $fetch_product['Product_Price']; ?><span></span></div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">no products found!</p>';
      }
   }
   ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>