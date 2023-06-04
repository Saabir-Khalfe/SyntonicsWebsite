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
   <title>About Syntonics</title>

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>
<section></section>

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/aboutUs.png" alt="">
      </div>

      <div class="content">
         <h3>Who Are We?</h3>
         <p>
   Leading technology firm Syntonics is headquartered in Johannesburg, South Africa. We have a long history that dates back to 1987, and since that time, we have been at the forefront of technical advancement, offering innovative solutions to both businesses and people.
</p>
<p>
   In order to empower our clients and foster their success, we at Syntonics are passionate about utilizing technology. Our hardworking team of professionals combines technological know-how with extensive industry understanding to create custom solutions that take on difficult problems and open up fresh possibilities.
</p>
<p>
   Software development, site design, mobile app development, cloud solutions, and digital marketing are just a few of the many services we provide. With a customer-centric approach, we work to comprehend the specific needs of our clients and provide solutions that go above and beyond their expectations. We embrace innovation as a technology-driven business and always try to be one step ahead.
</p>
<p>
   Our dedication to excellence, dependability, and client pleasure has given us a solid name in the sector. We take pleasure in building lasting relationships with our clients that help them accomplish their business objectives and prosper in the digital era.
</p>

         <a href="Feedback.php" class="btn">Send Us Your Feedback</a>
      </div>

   </div>

</section>


<section></section>


<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>


</body>
</html>