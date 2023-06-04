<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

$message = []; // Initialize the message array

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $update_profile_name = $conn->prepare("UPDATE `admin` SET name = ? WHERE id = ?");
    $update_profile_name->execute([$name, $admin_id]);

    $empty_pass = '';
    $prev_pass = $_POST['prev_pass'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = sha1($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

    if ($old_pass == $empty_pass) {
        $message[] = 'Please enter the old password!';
    } elseif ($old_pass != $prev_pass) {
        $message[] = 'Old password does not match!';
    } elseif ($new_pass != $confirm_pass) {
        $message[] = 'Confirm password does not match!';
    } else {
        if ($new_pass != $empty_pass) {
            $update_admin_pass = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ?");
            $update_admin_pass->execute([$confirm_pass, $admin_id]);
            $message[] = 'Password updated successfully!';
        } else {
            $message[] = 'Please enter a new password!';
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
    <title>Update Profile</title>

    <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="form-container">

        <form action="" method="post">
            <h3>Update Profile</h3>
            <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">
            <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" required placeholder="Please enter your username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="old_pass" placeholder="Please enter old password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="new_pass" placeholder="Please enter new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="confirm_pass" placeholder="Please confirm new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="Update Now" class="btn" name="submit">
        </form>

    </section>

    <script src="../js/admin_script.js"></script>

    <script>
    // Delayed message display
    setTimeout(function() {
        var messageContainer = document.createElement('div');
        messageContainer.innerHTML = '<?php echo implode("<br>", $message); ?>';
        messageContainer.style.backgroundColor = 'lightblue';
        messageContainer.style.padding = '10px';
        document.body.appendChild(messageContainer);

        // Remove the message after 5 seconds
        setTimeout(function() {
            messageContainer.remove();
        }, 5000); // Remove the message after 5 seconds (adjust the duration as needed)
    },)
</script>


</body>

</html>
