<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

$userId = $_SESSION['user']['id'];
$isUser = $_SESSION['user']['access_type']  === 'user';

if($isUser) {
    $filteredQuery = "WHERE user_id = $userId";
} else {
    $filteredQuery = "";
}

$search     =   '';
$page       =   (isset($_GET['page'])) ? $_GET['page'] : 1;
$limit      =   10;
$skip       =   ($page - 1) * $limit;
$sql        =   "SELECT * FROM posts $filteredQuery";
$sqlCount   =   "SELECT COUNT(*) totalRows FROM posts";

if (isset($_GET['search'])) {
   $search       = $connect->real_escape_string($_GET['search']);
    $sql        .= "WHERE title LIKE '$search%' OR brgy LIKE '$search%' OR address LIKE '$search%'";
    $sqlCount   .= "WHERE title LIKE '$search%' OR brgy LIKE '$search%' OR address LIKE '$search%'";
}

if (isset($_GET['userDelete'])) {
    deleteUser($connect, $_GET['userDelete']);
}

$sql .= " LIMIT $skip, $limit";

$result         =   postList($connect, $sql);
$total_rows     =   totalRows($connect, $sqlCount);
$total_pages    =   ceil($total_rows / $limit);

if(isset($_GET['updateStatus'])) {
    $postId     =   $_GET['updateStatus'];
    $status     =   "approved";
    $table      =   "posts";
    $redirect   =   "posts.php";

    updateStatus($connect, $table, $postId, $status, $redirect);
}

if(isset($_GET['disapproved'])) {
    $postId     =   $_GET['disapproved'];
    $status     =   "disapproved";
    $table      =   "posts";
    $redirect   =   "posts.php";

    updateStatus($connect, $table, $postId, $status, $redirect);
}

if(isset($_GET['postDelete'])) {
    $postId = $_GET['postDelete'];
    postDelete($connect, $postId);
}
// $currentDate = date("Y-m-d");
// $sqlQuery = "UPDATE posts SET status = 'expired' WHERE expiry_date <= '$currentDate'";
// $result = $connect->query($sqlQuery);
updateExpirationDate($connect);
get_alert_Message();
?>
<html>
    <head>
        <title>Posts | E - Donate Mo</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/donations.css">
        <link rel="stylesheet" type="text/css" href="css/user.css">
        <style type="text/css">
            .add-btn {
                color: #fff;
                background-color: #0e9d24;
                padding: 8px 12px;
                font-size: 18px!important;
                width: 145px !important;
            }
        </style>
    </head>

    <body>
        <?php
        include 'header.php';
        ?>
        <div class="wrapper">
            <div class="titleBar">
                <h2 style="color: #fff;">My Posts</h2>
                <!-- <a class="addBtn" href="post-create.php" >Create a Post</a> -->
            </div>

            <form class="searchBarContainer" action="posts.php" method="get">
                <input class="searchbar" type="text" name="search" placeholder="Search users..." value="<?php echo $search; ?>">
                <button class="searchBtn" type="submit"><i class='bx bx-search-alt-2' ></i></button>
                <a class="searchBtn add-btn" href="post-create.php">Create a Post</a>
            </form>

            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Expiration</th>
                    <th>status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?=$row['id'] ?></td>
                        <td><?= substr($row['title'], 0, 50) . (strlen($row['title']) > 100 ? '...' : ''); ?></td>
                        <td><?= substr($row['description'], 0, 50) . (strlen($row['description']) > 100 ? '...' : ''); ?></td>
                        <td><?=$row['phone'] ?></td>
                        <td><?=$row['address'] ?></td>
                        <td><?=$row['expiry_date'] ?></td>
                        <td style="color:<?= $row['status'] === 'approved' ? '#fff' : ($row['status'] === 'pending' ?  '#FFC300' : '#ff0000') ?>;"><?=ucfirst($row['status']) ?></td>
                        <td colspan="3">

                            <?php if(!$isUser): ?>
                                <a style="font-size: 20px;color: #fff;" class="actionBtn" href="javascript:void(0)" onclick="approvePost(<?=$row['id']?>)"><i class='bx bx-check'></i></a>
                                <a style="font-size: 20px;color: #fff;" class="actionBtn" href="javascript:void(0)" onclick="disapproved(<?=$row['id']?>)"><i class='bx bx-x'></i></a>
                            <?php endif; ?>

                            <a style="font-size: 20px;color: #fff;" class="actionBtn" href="post-edit.php?id=<?=$row['id'] ?>"><i class='bx bx-edit-alt'></i></a>
                            <a style="font-size: 20px;color: #fff;" class="actionBtn" href="javascript:void(0)" onclick="confirmDelete(<?=$row['id']?>)"><i class='bx bx-trash-alt'></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table><br>
            <center>
                <?=postPagination($page, $total_pages, $search); ?>
            </center>
        </div>
        <script>
            function confirmDelete(userId, title) {
                var message = confirm("Are you sure you want to delete this post?")

                if(message) {
                    window.location.href = "posts.php?postDelete=" + userId
                }
            }

            function approvePost(userId) {

                var message = confirm("This post will added to the feed");
                if(message) {
                    window.location.href = "posts.php?updateStatus=" + userId
                }
            }

            function disapproved(userId) {
                
                var message = confirm("Are you sure you want to disapproved this post?");
                if(message) {
                    window.location.href = "posts.php?disapproved=" + userId
                }
            }
        </script>
        <?php #include 'footer.php'; ?>
    </body>
</html>