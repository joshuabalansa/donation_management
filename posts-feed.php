<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";


$search     =   '';
$page       =   (isset($_GET['page']))? $_GET['page'] : 1;
$limit      =   2;
$skip       =   ($page - 1) * $limit;
$sql        =   "SELECT * FROM posts ORDER BY id DESC LIMIT 500";

$result     =   postList($connect, $sql);

?> 
<html>
    <head>
        <title>Posts | E - Donate Mo</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">	
        <link rel="stylesheet" type="text/css" href="css/donations.css">	
        <link rel="stylesheet" type="text/css" href="css/user.css">
        <style type="text/css">
            .feed-item {
                border: 1px solid #fff;
                padding: 10px;
                margin-bottom: 20px;
                background-color: #fff;
            }
            .feed-item .description {
                padding: 5px;
                background-color: #eee;
                margin: 10px 0;
            }
        </style>
    </head>

    <body>
        <?php 
        include 'header.php';
        ?>
        <div class="wrapper">
            <?php 
                while ($row = $result->fetch_assoc()): 
                $user = getUserDetails($connect, $row['user_id']);
            ?>
                <div class="feed-item">
                    <h3><?=$user['name'] ?></h3>
                    <h5><?=$row['title'] ?> - Brgy. <?=$row['brgy'] ?></h5>
                    <p class="description"><?=$row['description'] ?></p>
                    <p><small><?=$row['created_at'] ?></small></p>
                </div>
            <?php endwhile; ?>
        </div>
        <script>
            function confirmDelete(userId) {
                var confirmation = confirm("Are you sure you want to delete this post?")

                if(confirmation) {
                    window.location.href = "user.php?userDelete=" + userId
                }
            }
        </script>
        <?php 
        include 'footer.php';
        ?>
    </body>
</html>