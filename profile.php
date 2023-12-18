<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

$access_type = $_SESSION['user']['access_type'];
$user_id =  $_SESSION['user']['id'];

$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $connect->query($sql);
$row = $result->fetch_assoc();

if (is_null($row)) {
    exit;
}

$contact = $row['contact'];
$address = $row['address'];
$signup_success = '';

if (isset($_POST['updateUserBtn'])) {
    $contact = $connect->real_escape_string($_POST['contact']);
    $address = $connect->real_escape_string($_POST['address']);
    $mission = $connect->real_escape_string($_POST['mission']);
    $vision = $connect->real_escape_string($_POST['vision']);
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

        $sql = "UPDATE users SET contact='$contact', address='$address', mission='$mission', vision='$vision' WHERE id='$user_id'";

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
        <title>Posts | E - Donate Mo</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">	
        <link rel="stylesheet" type="text/css" href="css/profile.css">
        <style type="text/css">
          #vision, #mission {
            width: 100%;
          }
        </style>
    </head>

    <body>
        <?php 
        include 'header.php';
        ?>
        <div class="flex-center">
            <div class="profile">
              <div class="title">  
                <h2>My Profile</h2>
              </div> <br>
              <form action="profile.php" method="post">
                <div class="profile-item">
                  <label for="name">Name:</label>
                  <input type="text" id="name" class="name" name="name" value="<?=ucfirst($row['name']) ?>" readonly>
                </div>

                <div class="profile-item">
                  <label for="email">Email:</label>
                  <input type="email" id="email" class="email" name="email" value="<?= $row['email']?>" readonly>
                </div>

                <div class="profile-item">
                  <label for="address">Contact:</label>
                  <input type="text" id="address" class="contact" name="contact" value="<?=$row['contact']?>" readonly>
                </div>

                <div class="profile-item">
                  <label for="address">Address:</label>
                  <input type="text" id="address" class="contact" name="address" value="<?=$row['address']?>" readonly>
                </div>

                <div class="profile-item">
                  <label for="accessType">Mission:</label><br>
                  <textarea id="mission" name="mission"><?=$row['mission']?></textarea>
                </div>

                <div class="profile-item">
                  <label for="accessType">Vision:</label><br>
                  <textarea id="vision" name="vision"><?=$row['vision']?></textarea>
                </div>

                <div class="profile-item">
                    <input type="submit" value="Update" name="update" class="access-type" >
                </div>
              </form>
            </div>

          </div>
        <?php include 'footer.php'; ?>
    </body>
</html>