<?php
session_start();
include 'check-session.php';
include 'function.php';
require 'db-connect.php';

$show = isset($_GET['load']) && $_GET['load'] != '' ? $_GET['load'] : '';

$id = isset($_GET['donationEdit']) ? $_GET['donationEdit'] : '';

$donation = isset($id) ? getDonationById($connect, $id) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    updateDonationRecord($connect, $_POST);
}
?>
<html>

<head>
    <title>Donation | E - Donate Mo</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/donation-create.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php
    include 'header.php';
    ?>
    <div class="wrapper">
        <div class="titleBar">
            <h2 style="color: #fff;">Edit Record</h2>
        </div>
        <div class="formWrapper">
            <form action="<?=$_SERVER['PHP_SELF'] ?>" method="POST" class="custom-form">
                <input type="hidden" name="id" value="<?= $donation['id'] ?>">
                <label for="name">name:</label>
                <input type="text" value="<?=$donation['name'] ?>" id="name" name="name" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required><?=$donation['description']?></textarea>

                <label for="phone">Phone:</label>
                <input type="number" value="<?=$donation['phone']?>" id="phone" name="phone" maxlength="11" required>

                <label for="email">Email:</label>
                <input type="email" value="<?=$donation['email']?>" id="email" name="email" required>

                <label for="donationType">Donation Type:</label>
                <select id="donationType" name="donationType" required>
                    <option value="monetary">Monetary</option>
                    <option value="goods">Goods</option>
                </select>

                <label for="donation">Donation:</label>
                <input type="text" value="<?=$donation['donation']?>" id="donation" name="donation" required>

                <button type="submit">Save</button>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>

</body>

</html>
