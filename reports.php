<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

?>
<html>

<head>
    <title>Reports | E - Donate Mo</title>
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include 'header.php'; ?>
        <div class="wrapper">
            <form method="get" action="report-generate-1.php" target="_blank">
                
                <div class="profile">
                    <div class="profile-item">
                        <label for="date_from">From:</label>
                        <input type="date" id="date_from" class="name" name="date_from" value="" required><br>
                    </div>
                    <div class="profile-item">
                        <label for="date_to">To:</label>
                        <input type="date" id="date_to" class="name" name="date_to" value="" required><br>
                    </div>

                    <div class="profile-item">
                        <input type="submit" value="Generate" name="updateUserBtn" class="access-type" >
                    </div>
                </div>
            </form>
        </div>
    <?php include 'footer.php'; ?>
</body>

</html>
