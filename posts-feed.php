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
