<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

$access_type = $_SESSION['user']['access_type'];
$user_id =  $_SESSION['user']['id'];

$sql = "SELECT * FROM users WHERE id = $user_id";
$row = $connect->query($sql)->fetch_assoc();

// dd($results);

?>
<html>
    <head>
        <title>Posts | E - Donate Mo</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">	
        <link rel="stylesheet" type="text/css" href="css/profile.css">
    </head>

    <body>
        <?php 
        include 'header.php';
        ?>
        <div class="flex-center">
            <div class="profile">
              <div class="title">  
                <h2>My Profile</h2>
                <a href="#">Edit</a>
              </div> <br>
              <div class="profile-item">
                <label for="name">Name:</label>
                <input type="text" id="name" class="name" value="<?=ucfirst($row['name']) ?>" readonly>
              </div>

              <div class="profile-item">
                <label for="email">Email:</label>
                <input type="email" id="email" class="email" value="<?= $row['email']?>" readonly>
              </div>

              <div class="profile-item">
                <label for="contact">Contact Address:</label>
                <input type="text" id="contact" class="contact" value="<?=$row['address']?>" readonly>
              </div>

              <div class="profile-item">
                <label for="accessType">Access Type:</label>
                <input type="text" id="accessType" class="access-type" value="<?= $row['access_type']?>" readonly>
              </div>
            </div>

          </div>
        <?php #include 'footer.php'; ?>
    </body>
</html>