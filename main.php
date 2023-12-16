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
    <link rel="stylesheet" type="text/css" href="css/posts-feed.css">
    <style type="text/css">
        .feed-item img {
            width: 300px;
            height: 200px;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="feed-wrapper">
        <?php
        while ($row = $result->fetch_assoc()) :
            $img_placeholder = 'https://placehold.jp/300x200.png';
            $user = getUserDetails($connect, $row['user_id']);
        ?>
            <div class="feed-item">
                <img src="<?= ((empty($row['image']))? $img_placeholder : $row['image']) ?>" alt="Post Image">
                    <h5><?=$row['title'] ?></h5>
                <div class="description"><?= substr($row['description'], 0, 80) . (strlen($row['description']) > 100 ? '...' : ''); ?></div>
                <p style=" padding: 5px;"><?=$row['address'] ?></p>
                <p style=" padding: 5px;"><?=$row['brgy']?></p>
                <p style=" padding: 5px;"><?=$row['city']?></p>
                <small><?= $row['created_at'] ?></small>
                <a href="post-feed-info.php?feed_id=<?=$row['id']?>" class="donate-button">Donate</a>
            </div>
        <?php endwhile; ?>
    </div>
    <?php
    include 'footer.php';
    ?>
</body>

</html>
