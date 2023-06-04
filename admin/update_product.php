

<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update'])){

   $pid = $_POST['pid'];
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $update_product = $conn->prepare("UPDATE `inventory` SET Product_Name = ?, Product_Price = ?, Product_Description = ? WHERE id = ?");
   $update_product->execute([$name, $price, $details, $pid]);

   $message[] = 'product updated successfully!';

   $old_Product_Image = $_POST['old_Product_Image'];
   $Product_Image = $_FILES['Product_Image']['name'];
   $Product_Image = filter_var($Product_Image, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['Product_Image']['size'];
   $image_tmp_name_01 = $_FILES['Product_Image']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$Product_Image;

   if(!empty($Product_Image)){
      if($image_size_01 > 2000000){
         $message[] = 'Image Size Is Too Large!';
      }else{
         $update_Product_Image = $conn->prepare("UPDATE `inventory` SET Product_Image = ? WHERE id = ?");
         $update_Product_Image->execute([$Product_Image, $pid]);
         move_uploaded_file($image_tmp_name_01, $image_folder_01);
         unlink('../uploaded_img/'.$old_Product_Image);
         $message[] = 'Product Image Updated Successfully!';
      }
   }

   
   }



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Product</title>

  

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="update-product">

   <h1 class="heading">Update Product</h1>

   <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `inventory` WHERE id = ?");
      $select_products->execute([$update_id]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="old_Product_Image" value="<?= $fetch_products['Product_Image']; ?>">
   
      <div class="image-container">
         <div class="main-image">
            <img src="../uploaded_img/<?= $fetch_products['Product_Image']; ?>" alt="">
         </div>
         <div class="sub-image">
            <img src="../uploaded_img/<?= $fetch_products['Product_Image']; ?>" alt="">
         </div>
      </div>
      <span>Product name</span>
      <input type="text" name="name" required class="box" maxlength="100" placeholder="enter product name" value="<?= $fetch_products['Product_Name']; ?>">
      <span>Product price</span>
      <input type="number" name="price" required class="box" min="0" max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" value="<?= $fetch_products['Product_Price']; ?>">
      <span>Product details</span>
      <textarea name="details" class="box" required cols="30" rows="10"><?= $fetch_products['Product_Description']; ?></textarea>
      <span>Update Product Image</span>
      <input type="file" name="Product_Image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      
         <input type="submit" name="update" class="btn" value="update">
         <a href="products.php" class="option-btn">go back</a>
      </div>
   </form>
   
   <?php
         }
      }else{
         echo '<p class="empty">No product found!</p>';
      }
   ?>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>