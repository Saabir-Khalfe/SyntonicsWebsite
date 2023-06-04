<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    .footer {
   background-color: #333;
   color: #fff;
   padding: 20px;
   width: 100%;
   position: fixed;
   bottom: 0;
   left: 0;
 }
 
  
  .footer .grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(27rem, 1fr));
    gap: 1.5rem;
    align-items: flex-start;
  }
  
  .footer .grid .box h3 {
    font-size: 2rem;
    color: #fff;
    margin-bottom: 2rem;
    text-transform: capitalize;
  }
  
  .footer .grid .box a {
    display: block;
    margin: 1.5rem 0;
    font-size: 1.7rem;
    color: #fff;
  }
  
  .footer .grid .box a i {
    padding-right: 1rem;
    color: #fff;
    transition: 0.2s linear;
  }
  
  .footer .grid .box a:hover {
    color: #fff;
  }
  
  .footer .grid .box a:hover i {
    padding-right: 2rem;
  }
  
  .footer .credit {
    text-align: center;
    padding: 2.5rem 2rem;
    border-top: 2px solid #000;
    font-size: 2rem;
    color: #fff;
  }
  
  .footer .credit span {
    color: #fff;
  }
    </style>

</head>

<footer class="footer">

      <div class="box">

      <h3>Navigation</h3>
      <a href="../admin/AdminHomePage.php">Home</a>
         <a href="../admin/products.php">Products</a>
         <a href="../admin/placed_orders.php">Orders</a>
         <a href="../admin/admin_accounts.php">Admins</a>
         <a href="../admin/users_accounts.php">Users</a>
         <a href="../admin/Client_messages.php">Messages</a>
         </div>
</footer>