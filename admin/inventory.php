<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `inventory` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['Product_Image']);

   $delete_product = $conn->prepare("DELETE FROM `inventory` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `clientcart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `clientswishlist` WHERE pid = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:inventory.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Inventory</title>

  
   <link rel="stylesheet" href="../css/admin_style.css">
<style>
   .show-products .box-container {
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
   grid-gap: 2rem;
   margin-top: 2rem;
 }
 
 .show-products .box {
   background-color: #000;
   border: 1px solid blue;
   padding: 1rem;
 }
   </style>
</head>
<body>
   

<?php include '../components/admin_header.php'; ?>

<section class="show-products">

   <h1 class="heading">Inventory</h1>

   <div class="box-container">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `inventory`");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['Product_Image']; ?>" alt="">
      <div class="name"><?= $fetch_products['Product_Name']; ?></div>
      <div class="price">R<span><?= $fetch_products['Product_Price']; ?></span></div>
      <div class="details"><span><?= $fetch_products['Product_Description']; ?></span></div>
      <div class="flex-btn">
         <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="inventory.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn">delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No products added...yet</p>';
      }
   ?>
   
   </div>

</section>