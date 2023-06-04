<?php

include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $password = $_POST['pass'];
   $password = filter_var($password, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $password]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if($select_admin->rowCount() > 0){
      $_SESSION['admin_id'] = $row['id'];
      header('location:AdminHomePage.php');
   }else{
      $message[] = 'Incorrect username and/or password!';
   }
   

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php
if (isset($message)) {
   foreach ($message as $message) {
      echo '
      <div class="message">
         <span>' . $message . '</span>
         <button class="close-btn">X</button>
      </div>
      ';
   }
}
?>


<section class="form-container">

   <form action="" method="post">
      <h3>Login</h3>
      <input type="text" name="name" required placeholder="Please enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="pass" required placeholder="Please enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login" class="btn" name="submit">
   </form>

</section>
   
</body>
</html>

<script>
 
   var closeButtons = document.getElementsByClassName('close-btn');

 
   for (var i = 0; i < closeButtons.length; i++) {
    
      closeButtons[i].addEventListener('click', function () {
         this.parentNode.style.display = 'none';
      });
   }
</script>
