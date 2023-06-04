<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = $_POST['flat'] .', '. $_POST['province'] .', '. $_POST['city'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `clientcart` WHERE Client_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, Client_Name, Phone_Number, Email_Address, Payment_Method, Address, Total_Products, Total_Price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `clientcart` WHERE Client_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'Your order has been placed successfully!';
   }else{
      $message[] = 'Your cart is empty';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">
   <form action="" method="POST">
      <h3>Your Cart</h3>
      <div class="display-orders">
         <?php
            $grand_total = 0;
            $cart_items = array();
            $select_cart = $conn->prepare("SELECT * FROM `clientcart` WHERE Client_id = ?");
            $select_cart->execute([$user_id]);
            if ($select_cart->rowCount() > 0) {
               while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                  $cart_items[] = $fetch_cart['Product_Name'].' ('.$fetch_cart['Product_Price'].' x '.$fetch_cart['Product_Quantity'].') - ';
                  $total_products = implode($cart_items);
                  $grand_total += ($fetch_cart['Product_Price'] * $fetch_cart['Product_Quantity']);
         ?>
        <p style="color: lime"><?= $fetch_cart['Product_Name']; ?> <span style="color: lightblue">(<?= 'R'.$fetch_cart['Product_Price'].'/- x '.$fetch_cart['Product_Quantity']; ?>)</span></p>

         <?php
               }
            } else {
               echo '<p class="empty">Your cart is empty!</p>';
            }
         ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
         <div class="grand-total">Final Price: <span>R<?= $grand_total; ?></span></div>
      </div>
      <h3>Please Fill in Your Details</h3>
      <div class="flex">
         <div class="inputBox">
            <span>Full Name:</span>
            <input type="text" name="name" placeholder="Please enter your name" class="box" maxlength="30" required>
         </div>
         <div class="inputBox">
            <span>Phone Number:</span>
            <input type="number" name="number" placeholder="Please enter your number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
         </div>
         <div class="inputBox">
            <span>Email:</span>
            <input type="email" name="email" placeholder="Please enter your email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Payment Method:</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">Cash on delivery</option>
               <option value="credit card">Credit Card on delivery</option>
               <option value="Pay in Store">Pay in Store</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Address:</span>
            <input type="text" name="flat" placeholder="e.g. 41 Fake Street" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>City:</span>
            <input type="text" name="city" placeholder="e.g. Johannesburg" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Province:</span>
            <select name="province" class="box" required>
               <option value="Gauteng">Gauteng</option>
               <option value="North West">North West</option>
               <option value="Northern Cape">Northern Cape</option>
               <option value="Eastern Cape">Eastern Cape</option>
               <option value="Limpopo">Limpopo</option>
               <option value="KwaZulu-Natal">KwaZulu-Natal</option>
               <option value="Western Cape">Western Cape</option>
               <option value="Free State">Free State</option>
               <option value="Mpumalanga">Mpumalanga</option>
            </select>
         </div>
      </div>
      <input type="submit" name="order" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" value="Place Order">
   </form>
</section>


<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
