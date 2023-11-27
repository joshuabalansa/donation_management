<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

    $show = (isset($_GET['load']) && $_GET['load'] !='') ? $_GET['load'] : '';
?> 
<html>
    <head>
        <title>Messages | E - Donate Mo</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">	
    </head>

    <body>
        <?php 
        include 'header.php';
        ?>
        <div class="wrapper">
            
        </div>
        <?php 
        include 'footer.php';
        ?>
    </body>
</html>