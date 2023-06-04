<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home Page</title>

    <link rel="stylesheet" href="../css/admin_style.css">
    <style>
        .selections {
            padding: 20px;
        }

        .selections .heading {
            font-size: 4rem;
            background-color: #00bcd4;
            color: #fff;
            text-align: center;
        }

        .option-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .option {
            width: 250px;
            margin: 20px;
            padding: 20px;
            background-color: #2b2b2b;
            text-align: center;
            color: #fff;
        }

        .option h3 {
            font-size: 2rem;
            color: #00bcd4;
        }

        .option p {
            margin: 10px 0;
            color: #fff;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #00bcd4;
            color: #000;
            text-decoration: none;
            border-radius: 4px;
        }

        @media (max-width: 768px) {
            .option {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="selections">
        <h1 class="heading">Welcome <?= $fetch_profile['name']; ?></h1>
    </section>

    <section class="selections">
        <div class="option-container">
            
            <div class="option">
                <?php
                $select_admins = $conn->prepare("SELECT * FROM `admin`");
                $select_admins->execute();
                $number_of_admins = $select_admins->rowCount()
                ?>
                <p>Admins</p>
                <h3><?= $number_of_admins; ?></h3>
                <a href="admin_accounts.php" class="button">Admins</a>
            </div>
            
            <div class="option">
                <?php
                $select_users = $conn->prepare("SELECT * FROM `clients`");
                $select_users->execute();
                $number_of_users = $select_users->rowCount()
                ?>
                <p>Active Users</p>
                <h3><?= $number_of_users; ?></h3>
                <a href="users_accounts.php" class="button">Users</a>
            </div>
            <div class="option">
                <?php
                $select_messages = $conn->prepare("SELECT * FROM `clientfeedback`");
                $select_messages->execute();
                $number_of_messages = $select_messages->rowCount()
                ?>
                <p>Client FeedBacks</p>
                <h3><?= $number_of_messages; ?></h3>
                <a href="Client_messages.php" class="button">FeedBacks</a>
            </div>

            <div class="option">
                <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders`");
                $select_orders->execute();
                $number_of_orders = $select_orders->rowCount()
                ?>
                <p>Placed Orders</p>
                <h3><?= $number_of_orders; ?></h3>
                <a href="placed_orders.php" class="button">Orders</a>
            </div>

            <div class="option">
                <?php
                $select_products = $conn->prepare("SELECT * FROM `inventory`");
                $select_products->execute();
                $number_of_products = $select_products->rowCount()
                ?>
                 <p>Inventory Total</p>
                <h3><?= $number_of_products; ?></h3>
                <a href="products.php" class="button">Inventory</a>
            </div>



            <div class="option">
                <?php
                $select_POrders = $conn->prepare("SELECT * FROM `orders` WHERE Payment_Status = 'Order Pending'");
                $select_POrders->execute();
                $number_of_Pendings = $select_POrders->rowCount()
                ?>
                 <p>Number Of Orders Pending</p>
                <h3><?= $number_of_Pendings; ?></h3>
                <a href="placed_orders.php" class="button">Orders Pending</a>
            </div>


            <div class="option">
                <?php
                $select_COrders = $conn->prepare("SELECT * FROM `orders` WHERE Payment_Status = 'Order Completed'");
                $select_COrders->execute();
                $number_of_Completed= $select_COrders->rowCount()
                ?>
                 <p>Number Of Orders Completed</p>
                <h3><?= $number_of_Completed; ?></h3>
                <a href="placed_orders.php" class="button">Orders Completed</a>
            </div>

        </div>
    </section>

    <script src="../js/admin_script.js"></script>

</body>

</html>
