<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '
        <div class="message">
            <span>' . $message . '</span>
        </div>
        ';
    }
    echo '
    <script>
        setTimeout(function() {
            var messages = document.getElementsByClassName("message");
            for (var i = 0; i < messages.length; i++) {
                messages[i].remove();
            }
        }, 3000);
    </script>
    ';
}
?>
<style>
.header {
  background-color:lightblue;
  padding: 1rem;
}

.flex {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.logo {
  color: blue;
  text-decoration: none;
  font-size: 20px;
}

.logo span {
  font-weight: bold;
}

.navbar a {
  color: blue;
  text-decoration: none;
  margin-right: 1rem;
}

.icons {
  display: flex;
  align-items: center;
}

.icons div {
  color: #fff;
  margin-right: 1rem;
  cursor: pointer;
}

.profile p {
  color: #fff;
  margin-right: 1rem;
}

.profile a {
  color: blue;
  text-decoration: none;
  margin-right: 1rem;
}

.profile a.btn {
  background-color: blue;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  color: #fff;
}

.profile a.delete-btn {
  background-color: red;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  color: #fff;
}



    </style>
<header class="header">

   <section class="flex">

      <a href="../admin/AdminHomePage.php" class="logo"><span>Syntonics</span></a>
</section>
      <section class="flex">
      
      <nav class="navbar">
         <a href="../admin/AdminHomePage.php">Home</a>
         <a href="../admin/products.php">Products</a>
         <a href="../admin/placed_orders.php">Orders</a>
         <a href="../admin/admin_accounts.php">Admins</a>
         <a href="../admin/users_accounts.php">Users</a>
         <a href="../admin/Client_messages.php">FeedBacks</a>
         <a href="../admin/inventory.php">Inventory</a>
         <a href="../user_login.php">User Login</a>
         </nav>
        
         <div class="icons">
         <div id="menu-btn"></div>
         
         <div id="user-btn">Profile</div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p>Hi <?= $fetch_profile['name']; ?></p>
         <p>Would You Like To</p>
         <a href="../admin/update_profile.php" class="btn">update profile</a>
         <p>OR</p>
         <a href="../components/admin_logout.php" class="delete-btn">logout</a> 
      </div>
      
   </section>

</header>