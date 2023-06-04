<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);



   $productsImg = $_FILES['productsImg']['name'];
   $productsImg = filter_var($productsImg, FILTER_SANITIZE_STRING);
   $productimage= $_FILES['productsImg']['size'];
   $image_tmp_name_01 = $_FILES['productsImg']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$productsImg;

   $select_products = $conn->prepare("SELECT * FROM `inventory` WHERE Product_Name = ? AND category = ?");
   $select_products->execute([$name, $category]);

   if($select_products->rowCount() > 0){
      $message[] = 'This Product Already Exist';
   }else{

      $insert_products = $conn->prepare("INSERT INTO `inventory`(Product_Name,Product_Description,Product_Price,Product_Image, category ) VALUES(?,?,?,?,?)");
      $insert_products->execute([$name, $details, $price, $productsImg, $category]);

      if($insert_products){
         if($productimage> 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            $message[] = 'new product added!';
         }

      }

   }  

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
   header('location:products.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

  
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="add-products">
   <h1 class="heading">Add Product</h1>
   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>Product Name</span>
            <input type="text" class="box" required maxlength="100" placeholder="Please enter product name" name="name">
         </div>
         <div class="inputBox">
            <span>Product Price</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="Please enter product price" onkeypress="if(this.value.length == 10) return false;" name="price">
         </div>
         <div class="inputBox">
            <span>Product Category</span>
            <select name="category" class="box" required>
               <option value="">Select Category</option>
               <option value="television">Television</option>
               <option value="games">Games</option>
               <option value="cookers">Cookers</option>
               <option value="smartphones">Smartphones</option>
               <option value="laptops">Laptops</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Product Image</span>
            <input type="file" name="productsImg" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
         </div>
         <div class="inputBox">
            <span>Product Description</span>
            <textarea name="details" placeholder="Please enter product details" class="box" required maxlength="500" cols="30" rows="10"></textarea>
         </div>
      </div>
      <input type="submit" value="add product" class="btn" name="add_product">
   </form>
</section>


<script src="../js/admin_script.js"></script>
   
</body>
</html>
