<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_item = $conn->prepare("DELETE FROM `clientcart` WHERE id = ?");
   $delete_item->execute([$cart_id]);
}


if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `clientcart` SET Product_Quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'Quantity Updated';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Cart</title>

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products shopping-cart">

   <h3 class="heading">My Cart</h3>

   <div class="box-container">

   <?php
      $grand_total = 0;
      $select_cart = $conn->prepare("SELECT * FROM `clientcart` WHERE Client_id = ?");
      $select_cart->execute([$user_id]);
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
     
      <img src="uploaded_img/<?= $fetch_cart['Product_Image']; ?>" alt="">
      <div class="name"><?= $fetch_cart['Product_Name']; ?></div>
      <div class="flex">
         <div class="price">R<?= $fetch_cart['Product_Price']; ?></div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['Product_Quantity']; ?>">
       
      </div>
      <div class="sub-total"> Sub Total : <span>R<?= $sub_total = ($fetch_cart['Product_Price'] * $fetch_cart['Product_Quantity']); ?></span> </div>
      <button type="submit" name="update_qty" class = "btn">Update</button>
      <input type="submit" value="delete item" class="delete-btn" name="delete">
   </form>
   <?php
   $grand_total += $sub_total;
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   </div>

   <div class="cart-total">
      <p>Final Price: <span>R<?= $grand_total; ?></span></p>
      <a href="shop.php" class="option-btn">Continue Shopping</a>
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
<script>
      setTimeout(function () {
         var messageElements = document.querySelectorAll('.message');
         if (messageElements) {
            messageElements.forEach(function (element) {
               element.style.display = 'none';
            });
         }
      }, 7000);
   </script>
</body>
</html>