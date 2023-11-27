<?php
require "db-connect.php";
#$db = new DataBase();
$name = '';
$email = '';
$password = '';
$password_confirm = '';
$contact = '';
$address = '';

if (isset($_POST['signupBtn'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    #var_dump($_POST);

    $sql = "INSERT INTO users (name, email, password, contact, address, token, created_at) VALUES ('$name', '$email', '".md5($password)."', '$contact', '$address', '', NOW())";

    if ($connect->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $connect->error;
    }

    $connect->close();
    /*if ($db->dbConnect()) {
        if ($db->signUp("users", $_POST['username'], $_POST['phonenum'], $_POST['email'], $_POST['password'])) {
            echo "Sign Up Success";
        } else echo "Sign up Failed";
    } else echo "Error: Database connection";*/
} //else echo "All fields are required";
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

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo $email; ?>" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?php echo $password; ?>" required><br>

        <label for="password_confirm">Confirm Password:</label>
        <input type="password" id="password_confirm" name="password_confirm" value="<?php echo $password_confirm; ?>" required><br>

        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" value="<?php echo $contact; ?>" required><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" value="<?php echo $address; ?>" required><br>

        <input type="submit" value="Submit" name="signupBtn">
    </form>
</body>
</html>
