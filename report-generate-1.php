<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

$date_from = '';
$date_to = '';
if (!isset($_GET['date_from']) && !isset($_GET['date_to'])) {
    exit;
}
$date_from = $_GET['date_from'];
$date_to = $_GET['date_to'];

$date_from = date('Y-m-d 00:01', strtotime($date_from));
$date_to = date('Y-m-d 23:59', strtotime($date_to));

$sql = "SELECT *, " . 
        "(SELECT name FROM users WHERE id=user_id LIMIT 1) donor, " . 
        "(SELECT name FROM users WHERE id=(SELECT user_id FROM posts WHERE id=donations.post_id LIMIT 1) LIMIT 1) donee " . 
        "FROM donations WHERE created_at >= '$date_from' AND created_at <= '$date_to' ORDER BY created_at ASC";

$result = $connect->query($sql);
?>
<html>

    <head>
        <title>Reports | E - Donate Mo</title>
        <meta http-equiv="X-UA-Compatible" content="IE=7">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
        <h4>From <?= date('F d, Y', strtotime($date_from)) ?><br>
            To <?= date('F d, Y', strtotime($date_to)) ?>
        </h4>
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th>Post ID</th>
                    <th>Donee</th>
                    <th>Donor</th>
                    <th>Donation Type</th>
                    <th>Donation</th>
                    <th>Donated At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?=$row['post_id'] ?></td>
                    <td><?=$row['donee'] ?></td>
                    <td><?=$row['donor'] ?></td>
                    <td><?=$row['donation_type'] ?></td>
                    <td><?=$row['donation'] ?></td>
                    <td><?=$row['created_at'] ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

    </body>

</html>
