    <?php


session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

    $show = (isset($_GET['load']) && $_GET['load'] !='') ? $_GET['load'] : '';
    ?> 

    <html>
    <head>
        <title>E - Donate Mo</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">	
    </head>

    <body>
        <div class="header">
            <div class="edonatemo"><h1>E - DONATE MO | Admin page</h1></div>
            <div class="main">
            <img class="logo" src="images/edlogo.png">
                <nav>
                    <ul class="nav1">
                        <li><a href="main.php?load=users">Users</a></li>
                        <li><a href="main.php?load=donations">Donations</a></li>
                        <li><a href="main.php?load=messages">Messages</a></li>
                        <li><a href="main.php?load=post">Posts</a></li>
                        <li><a href="main.php?load=about">About</a></li>
                    </ul>
                </nav>
                
            
                <a class="start" href="logout.php">Logout</a>
            </div>
        </div>
        
        <div class="wrapper">
        <?php

    switch ($show) {
        case 'donations':
            include_once 'donations.php';
            break;
        case 'messages':
            include_once 'messages.php';
            break;
        case 'post':
            include_once 'posts.php';
            break;
        case 'about':
            include_once 'about.php';
            break;    
        default:
            include_once 'users.php'; 
            break;
        }
        
    ?>
        </div>

        <div class="footer">
        <p>&copy; 2023 University of St. La Salle</p>
        </div>

    </body>
    </html>