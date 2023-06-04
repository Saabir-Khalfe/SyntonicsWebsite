<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Orders</title>

   <link rel="stylesheet" href="css/style.css">
   <style>
      .box-container {
         overflow-x: auto;
      }

      .box {
         border: 1px solid #ccc;
         padding: 10px;
         margin-bottom: 20px;
         display: inline-block;
         white-space: nowrap;
      }

      .box p {
         margin: 5px 0;
      }

      @media (max-width: 768px) {
         .box {
            padding: 5px;
         }
      }
   </style>
</head>
<body class="orders_bg">
   
<?php include 'components/user_header.php'; ?>
<section></section>
<section class="orders">

   <h1 class="heading">Your Orders</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">To see your orders, please login</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>

   <div class="box">
      <p>Order Date: <span><?= $fetch_orders['Order_Date']; ?></span></p>
      <p>Your Name: <span><?= $fetch_orders['Client_Name']; ?></span></p>
      <p>Email Address: <span><?= $fetch_orders['Email_Address']; ?></span></p>
      <p>Phone Number: <span><?= $fetch_orders['Phone_Number']; ?></span></p>
      <p>Address: <span><?= $fetch_orders['Address']; ?></span></p>
      <p>Payment Method: <span><?= $fetch_orders['Payment_Method']; ?></span></p>
      <p>Your Orders: <span><?= $fetch_orders['Total_Products']; ?></span></p>
      <p>Total Price: <span>R<?= $fetch_orders['Total_Price']; ?></span></p>
      <p>Payment Status: <span style="color:<?php if($fetch_orders['Payment_Status'] == 'Order Pending'){ echo 'red'; }else{ echo 'lime'; }; ?>"><?= $fetch_orders['Payment_Status']; ?></span> </p>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">Please place your order</p>';
      }
      }
   ?>

   </div>

</section>
<section></section>
<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>
