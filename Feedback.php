<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `clientfeedback` WHERE Client_Name = ? AND Email_Address = ? AND Phone_Number = ? AND Feedback = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'already sent message!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `clientfeedback`(user_id, Client_Name, Email_Address, Phone_Number, Feedback) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'Thank You For Your Feedback';

   }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Send Us Your Feedback</title>


   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="contact">

   <form action="" method="post">
      <h3>Please Give Us Your Feedback</h3>
      <input type="text" name="name" placeholder="Please Enter Your Name" required maxlength="20" class="box">
      <input type="email" name="email" placeholder="Please Enter Your Email" required maxlength="50" class="box">
      <input type="number" name="number" min="0" max="9999999999" placeholder="Please Enter Your Number" required onkeypress="if(this.value.length == 10) return false;" class="box">
      <textarea name="msg" class="box" placeholder="Please Enter Your FeedBack" cols="30" rows="10"></textarea>
      <input type="submit" value="send feedback" name="send" class="btn">
   </form>

</section>


<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>