<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    try {
        $select_user = $conn->prepare("SELECT * FROM `clients` WHERE Clients_EmailAddress = ? AND Clients_Password = ?");
        $select_user->execute([$email, $pass]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);

        if ($email == "admin@admin") {
            header('Location: admin/admin_login.php');
            exit();
        }

        if ($select_user->rowCount() > 0) {
            $_SESSION['user_id'] = $row['id'];
            header('Location: home.php');
            exit();
        } else {
            $message = 'Your username and/or password is incorrect';
        }
    } catch (Exception $e) {
        // Handle the exception here, such as logging the error or displaying a generic error message
        $message = 'An error occurred. Please try again later.';
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
   
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
      .message {
         background-color: Red;
         color: Black;
         padding: 10px;
         margin-bottom: 10px;
         text-align: center;
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
   <div class="message">
      <?php echo $message; ?>
   </div>
<?php endif; ?>

<header class="header">
   <section class="flex">
      <a class="logo">Welcome To Syntonics<span></span></a>
</section>
      <section class="flex">
      <section class="form-container">
         <form action="" method="post">
            <h3>Please Login or Register</h3>
            <input type="email" name="email" required placeholder="Please enter your email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="pass" required placeholder="Please enter your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="Login" class="btn" name="submit">
            <p>Need an account?</p>
            <a href="user_register.php" class="option-btn">Register</a>
         </form>
      </section>
   </section>
</header>

<script src="js/script.js"></script>

<!-- JavaScript to close the message after a certain time -->
<script>
   setTimeout(function () {
      var messageElement = document.querySelector('.message');
      if (messageElement) {
         messageElement.style.display = 'none';
      }
   }, 7000);
</script>

</body>
</html>
