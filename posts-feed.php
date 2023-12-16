<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

$search = '';
$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
$limit = 2;
$skip = ($page - 1) * $limit;
$sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 500";

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
            justify-content: start;
            padding: 20px;
        }

        .feed-item {
            max-width: 300px;
            border: 1px solid #e5e5e5;
            margin: 10px;
            background-color: #fff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            display: flex; 
            flex-direction: column;
            justify-content: space-between;
        }

        .feed-item img {
            width: 100%;
            height: auto;
            border-bottom: 1px solid #e5e5e5;
        }

        .feed-item h5 {
            font-size: 1.2em;
            margin: 10px;
        }

        .feed-item .description {
            padding: 10px;
            border-top: 1px solid #e5e5e5;
            margin: 10px 0;
        }

        .feed-item small {
            display: block;
            color: #999;
            margin: 10px;
        }
        .donate-button {
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            text-align:center;
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
                    <h5><?=$row['title'] ?></h5>
                <div class="description"><?= substr($row['description'], 0, 80) . (strlen($row['description']) > 100 ? '...' : ''); ?></div>
                <p style="  padding: 10px;"><?=$row['address'] . ' ' . $row['brgy'] . ' ' . $row['city']?></p>
                <small><?= $row['created_at'] ?></small>
                <a href="post-feed-info.php?feed_id=<?=$row['id']?>" class="donate-button">Donate</a>
            </div>
        <?php endwhile; ?>
    </div>
    <script>
        function confirmDelete(userId) {
            var confirmation = confirm("Are you sure you want to delete this post?")

            if (confirmation) {
                window.location.href = "user.php?userDelete=" + userId
            }
        }
    </script>
    <?php
    include 'footer.php';
    ?>
</body>

</html>
