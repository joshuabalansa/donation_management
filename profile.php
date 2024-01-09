<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

$access_type = $_SESSION['user']['access_type'];
$user_id =  $_SESSION['user']['id'];
$signup_success = '';

if (isset($_POST['updateUserBtn'])) {
    $name = $connect->real_escape_string($_POST['name']);

    $error = [];

    if (empty($name)) {
        $error['name'] = 'Name is required!';
    }

    if (count($error) <= 0) {

        $sql = "UPDATE users SET name='$name' WHERE id='$user_id'";

        if ($connect->query($sql) === TRUE) {
            $signup_success = 'Record successfully updated!';
        } else {
            $signup_success = "Error: " . $sql . "<br>" . $connect->error;
        }
    }
}

$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $connect->query($sql);
$row = $result->fetch_assoc();

if (is_null($row)) {
    exit;
}

$name = $row['name'];
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
                  <input type="text" id="name" class="name" name="name" value="<?=ucfirst($row['name']) ?>">
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
                    <input type="submit" value="Update" name="updateUserBtn" class="access-type" >
                </div>
              </form>
            </div>

          </div>
        <?php include 'footer.php'; ?>
    </body>
</html>