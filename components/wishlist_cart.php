<?php
if (isset($_POST['add_to_wishlist'])) {
    if ($user_id == '') {
        header('location:user_login.php');
    } else {
        $pid = $_POST['pid'];
        $pid = filter_var($pid, FILTER_SANITIZE_STRING);
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $image = $_POST['image'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);

        $check_wishlist_numbers = $conn->prepare("SELECT * FROM `clientswishlist` WHERE Product_Name = ? AND user_id = ?");
        $check_wishlist_numbers->execute([$name, $user_id]);

        $check_cart_numbers = $conn->prepare("SELECT * FROM `clientcart` WHERE Product_Name = ? AND Client_id = ?");
        $check_cart_numbers->execute([$name, $user_id]);

        if ($check_wishlist_numbers->rowCount() > 0) {
         $message = '<span style="color: lime; font-size: 20px;">Already Added to Wishlist!</span>';
     } elseif ($check_cart_numbers->rowCount() > 0) {
         $message = '<span style="color: lime; font-size: 20px;">Already Added To Cart</span>';
     } else {
         $insert_wishlist = $conn->prepare("INSERT INTO `clientswishlist`(user_id,pid,Product_Name,Product_Price,Product_Image) VALUES(?,?,?,?,?)");
         $insert_wishlist->execute([$user_id, $pid, $name, $price, $image]);
         $message = '<span style="color: lime; font-size: 20px;">Added To Wishlist</span>';
     }
 }
 }
    


if (isset($_POST['add_to_cart'])) {
    if ($user_id == '') {
        header('location:user_login.php');
    } else {
        $pid = $_POST['pid'];
        $pid = filter_var($pid, FILTER_SANITIZE_STRING);
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $image = $_POST['image'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $qty = $_POST['qty'];
        $qty = filter_var($qty, FILTER_SANITIZE_STRING);


        $check_cart_numbers = $conn->prepare("SELECT * FROM `clientcart` WHERE Product_Name = ? AND Client_id = ?");
        $check_cart_numbers->execute([$name, $user_id]);

        if ($check_cart_numbers->rowCount() > 0) {
         $message = '<span style="color: lime; font-size: 20px;">Already Added To Cart</span>';
        } else {
            $check_wishlist_numbers = $conn->prepare("SELECT * FROM `clientswishlist` WHERE Product_Name = ? AND user_id = ?");
            $check_wishlist_numbers->execute([$name, $user_id]);

            if ($check_wishlist_numbers->rowCount() > 0) {
                $delete_wishlist = $conn->prepare("DELETE FROM `clientswishlist` WHERE Product_Name = ? AND user_id = ?");
                $delete_wishlist->execute([$name, $user_id]);
            }

            $insert_cart = $conn->prepare("INSERT INTO `clientcart`(Client_id, pid, Product_Name, Product_Price, Product_Quantity, Product_Image) VALUES(?,?,?,?,?,?)");
            $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
            $message = '<span style="color: lime; font-size: 20px;">Added To Cart</span>';
    }
}
}
?>

<!-- Displaying the message -->
<?php if (isset($message)): ?>
    <div id="message" style="background-color: grey; padding: 10px; margin-bottom: 10px;">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<!-- JavaScript to close the message after a certain time -->
<script>
    setTimeout(function () {
        var messageElement = document.getElementById('message');
        if (messageElement) {
            messageElement.style.display = 'none';
        }
    }, 5000);
</script>