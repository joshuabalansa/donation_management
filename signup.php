<?php
require "db-connect.php";
require "function.php";
#$db = new DataBase();
$name = '';
$email = '';
$password = '';
$password_confirm = '';
$contact = '';
$address = '';
$signup_success = '';

if (isset($_POST['signupBtn'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    #var_dump($_POST);

    $error = [];

    if (empty($name)) {
        $error['name'] = 'Name is required!';
    }

    if (empty($email)) {
        $error['email'] = 'Email is required!';
    } elseif (check_user_email($connect, $email)) {
        $error['email'] = 'Email already exists!';
    }

    if (empty($password)) {
        $error['password'] = 'Password is required!';
    } elseif ($password != $password_confirm) {
        $error['password'] = 'Password does not match!';
    }
    if (empty($contact)) {
        $error['contact'] = 'Contact is required!';
    }

    if (empty($address)) {
        $error['address'] = 'Address is required!';
    }

    if (count($error) <= 0) {

        $sql = "INSERT INTO users (name, email, password, contact, address, token, created_at) VALUES ('$name', '$email', '".md5($password)."', '$contact', '$address', '', NOW())";

        if ($connect->query($sql) === TRUE) {
            $signup_success = 'New record created successfully';
        } else {
            $signup_success = "Error: " . $sql . "<br>" . $connect->error;
        }

        $connect->close();
        
        $name = '';
        $email = '';
        $password = '';
        $password_confirm = '';
        $contact = '';
        $address = '';
        $signup_success = '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <title>Sign Up</title>
</head>
<body>
<header>
        <img src="images/edlogo.png" alt="Logo">
        <h1>E - Donate Mo</h1>
    </header>
    <h2>Sign Up</h2>
    <form action="signup.php" method="post">

        <?php
        if ($signup_success != '') {
            echo $signup_success;
        }
        ?>

        <label for="name">Name: <?php echo (isset($error['name']))? $error['name'] : '';?></label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br>

        <label for="email">Email: <?php echo (isset($error['email']))? $error['email'] : '';?></label>
        <input type="text" id="email" name="email" value="<?php echo $email; ?>" required><br>

        <label for="password">Password: <?php echo (isset($error['password']))? $error['password'] : '';?></label>
        <input type="password" id="password" name="password" value="<?php echo $password; ?>" required><br>

        <label for="password_confirm">Confirm Password:</label>
        <input type="password" id="password_confirm" name="password_confirm" value="<?php echo $password_confirm; ?>" ><br>

        <label for="contact">Contact: <?php echo (isset($error['contact']))? $error['contact'] : '';?></label>
        <input type="text" id="contact" name="contact" value="<?php echo $contact; ?>" required><br>

        <label for="address">Address: <?php echo (isset($error['address']))? $error['address'] : '';?></label>
        <input type="text" id="address" name="address" value="<?php echo $address; ?>" required><br>

        <input type="submit" value="Submit" name="signupBtn">
    </form>
</body>
</html>
