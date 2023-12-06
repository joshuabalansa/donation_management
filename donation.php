<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

    $show = (isset($_GET['load']) && $_GET['load'] !='') ? $_GET['load'] : '';
?> 
<html>
    <head>
        <title>Donation | E - Donate Mo</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">	
        <link rel="stylesheet" href="css/donations.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
        <?php 
        include 'header.php';
        ?>
        <div class="wrapper">
            <div class="titleBar">
                <h2 style="color: #fff;">Donation Information</h2>
                <a class="addBtn" href="javascript:void(0)" >Manually Add a Record</a>
            </div>
            <table>
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Description</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Donation Type</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                    </tr>
                </tbody>

            </table>
        </div>
        <?php 
        include 'footer.php';
        ?>
    </body>
</html>