<?php
session_start();
include 'check-session.php';
include 'function.php';
require 'db-connect.php';

$show = isset($_GET['load']) && $_GET['load'] != '' ? $_GET['load'] : '';
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
            <h2 style="color: #fff;">Add Record</h2>
        </div>
        <div class="formWrapper">
        <form action="#" method="post" class="custom-form">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="donationType">Donation Type:</label>
            <select id="donationType" name="donationType" required>
                <option value="monetary">Monetary</option>
                <option value="goods">Goods</option>
            </select>

            <label for="status">Status:</label>
            <input type="text" id="status" name="status" required>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*">

            <button type="submit">Submit</button>
        </form>
        </div>
    </div>
    <?php
    include 'footer.php';
    ?>
    
</body>

</html>
