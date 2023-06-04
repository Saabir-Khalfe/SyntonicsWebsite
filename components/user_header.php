
<?php
if (isset($message) && is_array($message)) {
   foreach ($message as $msg) {
      echo '
      <div class="message">
         <span>'.$msg.'</span>
      </div>
      ';
   }
}
?>



<header class="header">

   <section class="flex">

      <a href="home.php"class="logo">Syntonics Tech</a>
</section>
<section class="flex">
      <nav class="navbar">
      <a href="search_page.php"><span>Search</span></a>
      <a href="shop.php">Category</a>
         <a href="orders.php">My Orders</a>
         <a href="wishlist.php"><span>MyWishList</span></a>
         <a href="cart.php"><span>MyCart</span></a> 
      </nav>

      <div class="icons">  
         <div id="menu-btn"></div>
       <div id="user-btn"><span>MyProfile</span></div>
      </div>

      <div class="profile">
         <?php          
            $select_profile = $conn->prepare("SELECT * FROM `clients` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><strong>Hi <?= $fetch_profile["Clients_Name"]; ?></strong></p>
         <p>Would you like to:</p>
         <a href="update_user.php" class="btn">update profile</a>
         <p>OR</p>
         <a href="components/user_logout.php" class="delete-btn">logout</a> 
         <?php
            }else{
         ?>
         <p>First Login or Register</p>
         <div class="flex-btn">
            <a href="user_register.php" class="btn">Register</a>
            <a href="user_login.php" class="option-btn">Login</a>
         </div>
         <?php
            }
         ?>      
         
         
      </div>

   </section>

</header>