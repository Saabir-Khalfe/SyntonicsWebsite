<?php
include 'components/connect.php';
session_start();
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
} else {
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
   <title>Product Type</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      
 .wishlistbtn {
  background-color: blue; 
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

<section class="products">
   <h1 class="heading">Products</h1>

   <div class="box-container">
   <?php
     $category = $_GET['category'];
     $select_products = $conn->prepare("SELECT * FROM `inventory` WHERE category = ?");
     $select_products->execute([$category]);
     
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['Product_Name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['Product_Price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['Product_Image']; ?>">
      <button class="wishlistbtn" type="submit" name="add_to_wishlist">WishList</button>
      <img src="uploaded_img/<?= $fetch_product['Product_Image']; ?>" alt="">
      <div class="name"><?= $fetch_product['Product_Name']; ?></div>
      <div class="product-details"><?= $fetch_product['Product_Description']; ?></div>
      <div class="flex">
      
         <div class="price"><span>R</span><?= $fetch_product['Product_Price']; ?></div>
         
        
    <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
   
   </div>
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   } else {
      echo '<p class="empty">This Product is Not Available... yet</p>';
   }
   ?>
   </div>
</section>

<script src="js/script.js"></script>

</body>
</html>
