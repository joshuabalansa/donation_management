<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

$search = '';
$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
$limit = 10;
$skip = ($page - 1) * $limit;

$sql = "SELECT 
        users.name, 
        posts.title, 
        posts.image, 
        posts.description, 
        posts.id,
        posts.created_at 
        FROM users JOIN posts 
        ON users.id = posts.user_id 
        WHERE status = 'approved' ORDER BY id DESC";

$result = postList($connect, $sql);

?>
<html>
<head>
    <title>Posts | E - Donate Mo</title>
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/donations.css">
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
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
        if (isset($_GET['forum'])) {
            
            while ($row = $result->fetch_assoc()) :
                $img_placeholder = 'https://placehold.co/600x400?text=e-donate+mo';
                $user = getUserDetails($connect, $row['id']);
        ?>
            <div class="feed-item">

                <img src="<?= ((empty($row['image']))? $img_placeholder : $row['image']) ?>" alt="Post Image">
                    <h5><?=$row['title'] ?></h5>
                <div class="description"><?= substr($row['description'], 0, 80) . (strlen($row['description']) > 100 ? '...' : ''); ?></div>
                <small><?= $row['created_at'] ?> - <?= $row['name'] ?></small>

                    <a href="post-feed-info.php?feed_id=<?=$row['id']?>" class="donate-button">Donate</a>

            </div>
        <?php endwhile; 
        }
        ?>
    </div>
    <?php # include 'footer.php'; ?>
</body>

</html>
