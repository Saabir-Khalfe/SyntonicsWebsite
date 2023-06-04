<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   $update_profile = $conn->prepare("UPDATE `clients` SET Clients_Name = ?, Clients_EmailAddress = ? WHERE id = ?");
   $update_profile->execute([$name, $email, $user_id]);

   $empty_pass = '';
   $prev_pass = $_POST['prev_pass'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   if($old_pass == $empty_pass){
      $message[] = 'Please Enter Your Old Password';
   }elseif($old_pass != $prev_pass){
      $message[] = 'Your Old Password Is Incorrect';
   }elseif($new_pass != $cpass){
      $message[] = 'Your Confirmed Password Does Not Match';
   }else{
      if($new_pass != $empty_pass){
         $update_admin_pass = $conn->prepare("UPDATE `clients` SET Clients_Password = ? WHERE id = ?");
         $update_admin_pass->execute([$cpass, $user_id]);
         $message[] = 'Password Updated Successfully!';
      }else{
         $message[] = 'Please Enter A New Password!';
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
   <title>register</title>
   

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Update</h3>
      <input type="hidden" name="prev_pass" value="<?= $fetch_profile["Clients_Password"]; ?>">
      <input type="text" name="name" required placeholder="Please enter your username" maxlength="20"  class="box" value="<?= $fetch_profile["Clients_Name"]; ?>">
      <input type="email" name="email" required placeholder="Please enter your email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile["Clients_EmailAddress"]; ?>">
      <input type="password" name="old_pass" placeholder="Please enter your old password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="Please enter your new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" placeholder="Please confirm your new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="update now" class="btn" name="submit">
   </form>

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