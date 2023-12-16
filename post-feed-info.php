<?php
    session_start();

    include "check-session.php";
    include "function.php";
    require "db-connect.php";

    if(isset($_POST['submit'])) {

        if($_SERVER['REQUEST_METHOD'] === "POST") {
            $userId = $_SESSION['user']['id'];
            $userData = userList($connect, "SELECT * FROM users WHERE id = $userId")->fetch_assoc();
            $name = isset($userData['name']) ? $userData['name'] : '';
            $address = isset($userData['address']) ? $userData['address'] : '';
            $phone = isset($userData['contact']) ? $userData['contact'] : '';
            $email = isset($userData['email']) ? $userData['email'] : '';
            $donationType = isset($_POST['donation_type']) ? $_POST['donation_type'] : '';
            $donation = isset($_POST['donation']) ? $_POST['donation'] : '';
            $image = isset($_FILES['image']) ? $_FILES['image'] : '';

            donate(
                $connect,
                $name,
                $address,
                $phone,
                $email,
                $donationType,
                $donation,
                $image
            );
            exit;
        }
    }

    $postId = $_GET['feed_id'];
    $sql = "SELECT * FROM posts WHERE id = $postId ORDER BY id DESC LIMIT 500";
    $result = postList($connect, $sql);

   
?>

<html>
<head>
    <title>Posts | E - Donate Mo</title>
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/donations.css">
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link rel="stylesheet" type="text/css" href="css/post-feed-info.css">
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

                    <div style="margin: 10px;">
                        <h1><?= ucfirst($row['title']) ?></h1>
                        <small>
                            <?=$row['description'] . '<br><br>' . 'Phone: ' . $row['phone'] . '<br>'. 'Address: ' . $row['address'] .' ' . $row['brgy'] .' ' . $row['city'] . '<br><br>' . 'Created at: ' .$row['created_at'] ?>
                        </small>
                    </div>

                    <form action="<?=htmlentities($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
                        <select name="donation_type" id="donationType" onchange="updateAmountPlaceholder()" required>
                            <option value="monetary">Monetary (Upload the reciept)</option>
                            <option value="goods">Goods</option>
                        </select>

                        <input type="text" id="amountInput" name="donation" placeholder="Amount">
                        <input type="file" name="image" id="image" style="display: none;">
                        
                        <button name="submit" type="submit" class="donate-button">Donate</button>
                        <a href="posts-feed.php" type="submit">Back</a>
                   
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
