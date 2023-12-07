<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

    $show = (isset($_GET['load']) && $_GET['load'] !='') ? $_GET['load'] : '';

    $sql = "SELECT * FROM donations";
    $results = $connect->query($sql);

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
                <a class="addBtn" href="donation-create.php" >Manually Add a Record</a>
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
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php while($row = $results->fetch_assoc()): ?>
                    <tr>
                        <td><?=$row['username']; ?></td>
                        <td><?=$row['description']?></td>
                        <td><?=$row['phone']?></td>
                        <td><?=$row['email']?></td>
                        <td><?=$row['donationType']?></td>
                        <td><?=$row['status']?></td>
                        <td colspan="2">
                        <a  style="font-size: 20px;color: #fff;" href="javascript:void(0)"><i class='bx bx-list-ul'></i></a>
                        <a  style="font-size: 20px;color: #fff;" href="javascript:void(0)"><i class='bx bx-edit-alt'></i></a>
                        <a  style="font-size: 20px;color: #fff;" href="javascript:void(0)"><i class='bx bx-trash-alt'></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>

            </table>
        </div>
        
        <?php 
        include 'footer.php';
        ?>
    </body>
</html>