<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

$show = (isset($_GET['load']) && $_GET['load'] !='') ? $_GET['load'] : '';

$name = '';
$email = '';
$contact = '';
$address = '';
$access = '';
$signup_success = '';

if (isset($_POST['updateUserBtn'])) {

    $name = $connect->real_escape_string($_POST['name']);
    $email = $connect->real_escape_string($_POST['email']);
    $contact = $connect->real_escape_string($_POST['contact']);
    $address = $connect->real_escape_string($_POST['address']);
    $access = $connect->real_escape_string($_POST['access']);
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

        $sql = "INSERT INTO users (name, email, contact, address, access_type, created_at) VALUES ('$name', '$email', '$contact', '$address', '$access', NOW())";

        if ($connect->query($sql) === TRUE) {
            $signup_success = 'Record successfully added!';
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
        <link rel="stylesheet" type="text/css" href="css/profile.css">
    </head>

    <body>
        <?php 
        include 'header.php';
        ?>
        <div class="wrapper">
            
            <div class="flex-center">
                <div class="profile">
                    <div class="title">  
                        <h2>New User</h2>
                    </div>
        		    <form action="user-create.php" method="post">

        		        <?php
        		        if ($signup_success != '') {
        		            echo $signup_success;
        		        }
        		        ?>

                        <div class="profile-item">
                            <label for="name">Name: <?php echo (isset($error['name']))? $error['name'] : '';?></label>
                            <input type="text" id="name" class="name" name="name" value="<?php echo $name; ?>" required><br>
                        </div>

                        <div class="profile-item">
                            <label for="email">Email: <?php echo (isset($error['email']))? $error['email'] : '';?></label>
                            <input type="text" id="email" class="name" name="email" value="<?php echo $email; ?>" required><br>
                        </div>

                        <div class="profile-item">
                            <label for="contact">Contact: <?php echo (isset($error['contact']))? $error['contact'] : '';?></label>
                            <input type="text" id="contact" class="name" name="contact" value="<?php echo $contact; ?>" required><br>
                        </div>

                        <div class="profile-item">
                            <label for="address">Address: <?php echo (isset($error['address']))? $error['address'] : '';?></label>
                            <input type="text" id="address" class="name" name="address" value="<?php echo $address; ?>" required><br>
                        </div>

                        <div class="profile-item">
                            <label for="address">Access: <?php echo (isset($error['access']))? $error['access'] : '';?></label>
                            <select id="access" class="name" name="access" required><?php echo $access; ?>
                                <option value="user" <?php echo ($access == 'user')? 'selected="selected"' : '';?>>USER</option>
                                <option value="admin" <?php echo ($access == 'admin')? 'selected="selected"' : '';?>>ADMIN</option>
                            </select>
                        </div>

                        <div class="profile-item">
                            <input type="submit" value="Submit" name="updateUserBtn" class="access-type" >
                        </div>

        		    </form>

                </div>

            </div>
        </div>
        <?php 
        include 'footer.php';
        ?>
    </body>
</html>