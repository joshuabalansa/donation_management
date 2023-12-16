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

    $name = $connect->real_escape_string($_POST['name']);
    $email = $connect->real_escape_string($_POST['email']);
    $password = $connect->real_escape_string($_POST['password']);
    $password_confirm = $connect->real_escape_string($_POST['password_confirm']);
    $contact = $connect->real_escape_string($_POST['contact']);
    $address = $connect->real_escape_string($_POST['address']);
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
            header('location: index.php');
            exit;
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
    <style type="text/css">
        .sign-up {
            padding: 10px;
            background-color: #0e9d24;
            display: block;
            text-decoration: none;
            font-size: 12px;
        }
        .sign-up:link,
        .sign-up:visited,
        .sign-up:active {
            text-decoration: none;
            color: #fff;
        }
    </style>
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

        <label for="name">Name: <span class="error-msg"><?php echo (isset($error['name']))? $error['name'] : '';?></span></label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br>

        <label for="email">Email: <span class="error-msg"><?php echo (isset($error['email']))? $error['email'] : '';?></span></label>
        <input type="text" id="email" name="email" value="<?php echo $email; ?>" required><br>

        <label for="password">Password: <span class="error-msg"><?php echo (isset($error['password']))? $error['password'] : '';?></span></label>
        <input type="password" id="password" name="password" value="<?php echo $password; ?>" required><br>

        <label for="password_confirm">Confirm Password:</label>
        <input type="password" id="password_confirm" name="password_confirm" value="<?php echo $password_confirm; ?>" ><br>

        <label for="contact">Contact: <span class="error-msg"><?php echo (isset($error['contact']))? $error['contact'] : '';?></span></label>
        <input type="text" id="contact" name="contact" value="<?php echo $contact; ?>" required><br>

        <label for="address">Address: <span class="error-msg"><?php echo (isset($error['address']))? $error['address'] : '';?></span></label>
        <input type="text" id="address" name="address" value="<?php echo $address; ?>" required><br>

        <input type="submit" value="Submit" name="signupBtn">
        <a href="index.php" class="sign-up">Back to Login</a>
    </form>
</body>
</html>
