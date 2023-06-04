<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `clients` WHERE Clients_EmailAddress = ?");
   $select_user->execute([$email]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if ($select_user->rowCount() > 0) {
      $message[] = 'Email already exists! Please try another email address';
   } else {
      if ($pass != $cpass) {
         $message[] = 'Passwords do not match';
      } else {
         $insert_user = $conn->prepare("INSERT INTO `clients`(Clients_Name, Clients_EmailAddress, Clients_Password) VALUES(?,?,?)");
         $insert_user->execute([$name, $email, $cpass]);
         $message[] = 'Registered successfully! Please login now.';
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
   <title>Register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
      .message {
         padding: 10px;
         margin-bottom: 10px;
         text-align: center;
      }

      .message.success {
         background-color: green;
         color: black;
      }

      .message.error {
         background-color: red;
         color: black;
         
      }
      .option-btn {
         display: block;
   width: 100%;
   margin-top: 1rem;
   border-radius: .5rem;
   padding: 1rem 3rem;
   font-size: 1.7rem;
   text-transform: capitalize;
   color: var(--white);
   cursor: pointer;
   text-align: center;
   background-color: #2980b9;
         
      }
      .option-btn:hover {
         background-color: #094e7c;
         
      }
      
   </style>
</head>

<body>
   <?php if (isset($message)): ?>
      <?php foreach ($message as $msg): ?>
         <div class="message <?php echo ($select_user->rowCount() > 0 || $pass != $cpass) ? 'error' : 'success'; ?>">
            <?php echo $msg; ?>
         </div>
      <?php endforeach; ?>
   <?php endif; ?>

   <header class="header">
   <section class="flex">
      <a class="logo">Welcome To Syntonics<span></span></a>
</section>
<section class="flex">
         <section class="form-container">
            <form action="" method="post">
               <h3>Register</h3>
               <input type="text" name="name" required placeholder="Please enter your username" maxlength="20" class="box">
               <input type="email" name="email" required placeholder="Please enter your email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               <input type="password" name="pass" required placeholder="Please enter your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               <input type="password" name="cpass" required placeholder="Please confirm your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
               <input type="submit" value="Register" class="btn" name="submit">
               <p>Already have an account?</p>
               <a href="user_login.php" class="option-btn">Login</a>
            </form>
         </section>
      </section>
   </header>

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
