<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

    $show = (isset($_GET['load']) && $_GET['load'] !='') ? $_GET['load'] : '';
    $user_id =  $_SESSION['user']['id'];

    $isAdmin = $_SESSION['user']['access_type'];

    if($_SESSION['user']['access_type'] === 'admin') {

        $sql = "SELECT users.name, users.address, users.contact, users.email, donations.id, donations.status, donations.donation_type, donations.donation
                FROM users JOIN donations ON users.id = donations.user_id";

    } else {
        $sql = "SELECT users.name, users.address, users.contact, users.email, donations.id, donations.status, donations.donation_type, donations.donation
                FROM users JOIN donations ON users.id = donations.user_id WHERE user_id = $user_id";
    }

    $results = $connect->query($sql);

    if (!$results) {
        die("Error: " . $mysqli->error);
    }

    if(isset($_GET['donationDelete'])) {
        $id = $_GET['donationDelete'];
        deleteDonationById($connect, $id);
    }

    if(isset($_GET['success'])) {
        $postId     =   $_GET['success'];
        $status     =   "Successful";
        $table      =   "donations";
        $redirect   =   "donation.php";

        updateStatus($connect, $table, $postId, $status, $redirect);
    }
    if(isset($_GET['failed'])) {
        $postId     =   $_GET['failed'];
        $status     =   "Failed";
        $table      =   "donations";
        $redirect   =   "donation.php";

        updateStatus($connect, $table, $postId, $status, $redirect);
    }
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
                <h2 style="color: #fff;">Contribution Records</h2>
            </div>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Donation Type</th>
                    <th>Status</th>
                    <?php if($isAdmin == "admin"): ?>
                        <th>Action</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                    <?php while($row = $results->fetch_assoc()): ?>
                    <tr>
                        <td><?=$row['id']; ?></td>
                        <td><?=$row['name']?></td>
                        <td><?=$row['address']?></td>
                        <td><?=$row['contact']?></td>
                        <td><?=$row['email']?></td>
                        <td><?=$row['donation_type']?></td>
                        <td style="color: <?= $row['status'] === 'Successful' ? '#00ff00' : '#ff0000' ?>;">
                            <?= $row['status'] ?>
                        </td>
                        <?php if($isAdmin == "admin"): ?>
                            <td colspan="2">
                            <a style="font-size: 20px;color: #fff;" class="actionBtn" href="javascript:void(0)" onclick="approvePost(<?=$row['id']?>)"><i class='bx bx-check'></i></a>
                                <a style="font-size: 20px;color: #fff;" class="actionBtn" href="javascript:void(0)" onclick="disapproved(<?=$row['id']?>)"><i class='bx bx-x'></i></a>
                            </td>
                        <?php endif; ?>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <script>
            function confirmDelete(donationId) {
                 var confirmation = confirm("Are you sure you want to delete?")

                 if (confirmation) {
                    window.location.href = "donation.php?donationDelete=" + donationId
                 }
            }

            function approvePost(userId) {
            var message = confirm("Are you sure you want to confirm this donation?");
                if(message) {
                    window.location.href = "donation.php?success=" + userId
                }
            }

            function disapproved(userId) {

            var message = confirm("Are you sure you want to disapproved donations?");
                if(message) {
                    window.location.href = "donation.php?failed=" + userId
                }
            }
        </script>
        <?php
            include 'footer.php';
            $connect->close();
        ?>
    </body>
</html>