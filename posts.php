<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";


$search     =   '';
$page       =   (isset($_GET['page']))? $_GET['page'] : 1;
$limit      =   2;
$skip       =   ($page - 1) * $limit;
$sql        =   "SELECT * FROM posts ";
$sqlCount   =   "SELECT COUNT(*) totalRows FROM posts ";

if (isset($_GET['search'])) {

   $search       = $connect->real_escape_string($_GET['search']);
    $sql        .= "WHERE title LIKE '$search%' OR brgy LIKE '$search%' OR address LIKE '$search%' ";
    $sqlCount   .= "WHERE title LIKE '$search%' OR brgy LIKE '$search%' OR address LIKE '$search%' ";
}

if (isset($_GET['userDelete'])) {
    deleteUser($connect, $_GET['userDelete']);
}

$sql .= "LIMIT $skip, $limit";

$result         =   postList($connect, $sql);
$total_rows     =   totalRows($connect, $sqlCount);
$total_pages    =   ceil($total_rows / $limit)

?> 
<html>
    <head>
        <title>Posts | E - Donate Mo</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">	
        <link rel="stylesheet" type="text/css" href="css/donations.css">	
        <link rel="stylesheet" type="text/css" href="css/user.css"> 
    </head>

    <body>
        <?php 
        include 'header.php';
        ?>
        <div class="wrapper">
            <div class="titleBar">
                <h2 style="color: #fff;">Posts</h2>
                <a class="addBtn" href="post-create.php" >Create a Post</a>
            </div>
            
            <form class="searchBarContainer" action="posts.php" method="get">
                <input class="searchbar" type="text" name="search" placeholder="Search users..." value="<?php echo $search; ?>"> 
                <button class="searchBtn" type="submit"><i class='bx bx-search-alt-2' ></i></button>
            </form>

            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Phone</th>
                    <th>Brgy</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?=$row['id'] ?></td>
                        <td><?= substr($row['title'], 0, 100) . (strlen($row['title']) > 100 ? '...' : ''); ?></td>
                        <td><?= substr($row['description'], 0, 100) . (strlen($row['description']) > 100 ? '...' : ''); ?></td>
                        <td><?=$row['phone'] ?></td>
                        <td><?=$row['brgy'] ?></td>
                        <td><?=$row['address'] ?></td>
                        <td>
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
            function confirmDelete(userId) {
                var confirmation = confirm("Are you sure you want to delete this post?")

                if(confirmation) {
                    window.location.href = "function.php?postDelete=" + userId
                }
            }
        </script>
        <?php 
        include 'footer.php';
        ?>
    </body>
</html>