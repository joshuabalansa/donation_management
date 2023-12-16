<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

$id = $_GET['feed_id'];

$sql = "SELECT * FROM posts WHERE id = $id ORDER BY id DESC LIMIT 500";
$result = postList($connect, $sql);
?>

<html>

<head>
    <title>Posts | E - Donate Mo</title>
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/donations.css">
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <style type="text/css">
        .feed-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }

        .feed-item {
            display: flex;
            max-width: 800px; 
            border: 1px solid #e5e5e5;
            margin: 10px;
            background-color: #fff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            border-radius: 2px;
            overflow: hidden;
        }

        .feed-item img {
            width: 50%;
            height: auto;
            border-right: 1px solid #e5e5e5;
        }

        .donation-form {
            flex: 1;
            padding: 20px;
        }

        .donation-form input,
        .donation-form select {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
            box-sizing: border-box;
        }

        .donate-button {
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            text-align: center;
            margin: 5px;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="feed-wrapper">
        <?php
        while ($row = $result->fetch_assoc()) :
            $user = getUserDetails($connect, $row['user_id']);
        ?>
            <div class="feed-item">
                <img src="<?= $row['image'] ?>" alt="Post Image">
                <div class="donation-form">
                    <h5><?= $row['title'] ?></h5>
                    <form action="process_donation.php" method="post">
                        <input type="text" name="name" placeholder="Your Name" required>
                        <input type="text" name="address" placeholder="Your Address" required>
                        <input type="tel" name="phone" placeholder="Your Phone Number" required>
                        <input type="email" name="email" placeholder="Your Email" required>
                        <select name="donation_type" id="donationType" onchange="updateAmountPlaceholder()" required>
                            <option value="">Select Donation Type</option>
                            <option value="monetary">Monetary</option>
                            <option value="goods">Goods</option>
                        </select>
                        <input type="number" id="amountInput" name="amount" placeholder="Amount" step="0.01">
                        <input type="file" name="image" id="image" style="display: none;">
                        <button type="submit" class="donate-button">Donate</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        
        function updateAmountPlaceholder() {
            var donationType = document.getElementById('donationType');
            var amountInput = document.getElementById('amountInput');
            var image = document.getElementById('image');

            if (donationType.value === 'goods') {
                amountInput.placeholder = 'Enter type of Goods';
                image.style.display = 'none';
            } else {
                amountInput.placeholder = 'Enter Amount';
                image.style.display = 'block';

            }
        }
       
        document.getElementById('donationType').addEventListener('change', updateAmountPlaceholder);
       
        updateAmountPlaceholder();
    });
</script>
    <?php include 'footer.php'; ?>
</body>

</html>
