<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

$show = (isset($_GET['load']) && $_GET['load'] !='') ? $_GET['load'] : '';

$name = $_SESSION['user']['name'];
$email = $_SESSION['user']['email'];
$contact = $_SESSION['user']['contact'];
$address = $_SESSION['user']['address'];
$signup_success = '';

if (isset($_POST['updateUserBtn'])) {

    $name = $connect->real_escape_string($_POST['name']);
    $email = $connect->real_escape_string($_POST['email']);
    $contact = $connect->real_escape_string($_POST['contact']);
    $address = $connect->real_escape_string($_POST['address']);
    $user_id = $_SESSION['user']['id'];
    #var_dump($_POST);

    $error = [];

    if (empty($name)) {
        $error['name'] = 'Name is required!';
    }
    
    if (empty($email)) {
        $error['email'] = 'Email is required!';
    } elseif (check_user_email_except_user($connect, $email, $user_id)) {
        $error['email'] = 'Email already exists!';
    }

    if (empty($contact)) {
        $error['contact'] = 'Contact is required!';
    }

    if (empty($address)) {
        $error['address'] = 'Address is required!';
    }

    if (count($error) <= 0) {

        $sql = "UPDATE users SET name='$name', email='$email', contact='$contact', address='$address' WHERE id='$user_id'";

        if ($connect->query($sql) === TRUE) {
            $signup_success = 'Record successfully updated!';
        } else {
            $signup_success = "Error: " . $sql . "<br>" . $connect->error;
        }

        $connect->close();
    }
}
?> 
<html>
    <head>
        <title>User Form | E - Donate Mo</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">	
    </head>

    <body>
        <?php 
        include 'header.php';
        ?>
        <div class="wrapper">
            
		    <form action="user-edit.php" method="post">

		        <?php
		        if ($signup_success != '') {
		            echo $signup_success;
		        }
		        ?>

		        <label for="name">Name: <?php echo (isset($error['name']))? $error['name'] : '';?></label>
		        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br>

		        <label for="email">Email: <?php echo (isset($error['email']))? $error['email'] : '';?></label>
		        <input type="text" id="email" name="email" value="<?php echo $email; ?>" required><br>

		        <label for="contact">Contact: <?php echo (isset($error['contact']))? $error['contact'] : '';?></label>
		        <input type="text" id="contact" name="contact" value="<?php echo $contact; ?>" required><br>

		        <label for="address">Address: <?php echo (isset($error['address']))? $error['address'] : '';?></label>
		        <input type="text" id="address" name="address" value="<?php echo $address; ?>" required><br>

		        <input type="submit" value="Update" name="updateUserBtn">

		    </form>

        </div>
        <?php 
        include 'footer.php';
        ?>
    </body>
</html>