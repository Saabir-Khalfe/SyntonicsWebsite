<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `clientfeedback` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:Client_messages.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Client Messages</title>


   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="contacts">

<h1 class="heading">Client FeedBacks</h1>

<div class="box-container">

   <?php
      $select_messages = $conn->prepare("SELECT * FROM `clientfeedback`");
      $select_messages->execute();
      if($select_messages->rowCount() > 0){
         while($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
   <p> user id : <span><?= $fetch_message['user_id']; ?></span></p>
   <p> Name : <span><?= $fetch_message['Client_Name']; ?></span></p>
   <p> Email Address : <span><?= $fetch_message['Email_Address']; ?></span></p>
   <p> Phone number : <span><?= $fetch_message['Phone_Number']; ?></span></p>
   <p> Feedback : <span><?= $fetch_message['Feedback']; ?></span></p>
   <a class = "delete-btn" href="Client_messages.php?delete=<?= $fetch_message['id']; ?>">delete feedback</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">you have no messages</p>';
      }
   ?>

</div>

</section>


<script src="../js/admin_script.js"></script>
   
</body>
</html>