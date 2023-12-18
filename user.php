<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

$search 	= 	'';
$page 		= 	(isset($_GET['page']))? $_GET['page'] : 1;
$limit 		= 	2;
$skip 		= 	($page - 1) * $limit;
$sql 		= 	"SELECT * FROM users ";
$sqlCount 	= 	"SELECT COUNT(*) totalRows FROM users ";

if (isset($_GET['search'])) {

   $search 		 = $connect->real_escape_string($_GET['search']);
	$sql 		.= "WHERE name LIKE '$search%' OR email LIKE '$search%' OR contact LIKE '$search%' ";
	$sqlCount 	.= "WHERE name LIKE '$search%' OR email LIKE '$search%' OR contact LIKE '$search%' ";
}

if (isset($_GET['userDelete'])) {
    deleteUser($connect, $_GET['userDelete']);
}

$sql .= "LIMIT $skip, $limit";

$result 		= 	userList($connect, $sql);
$total_rows		= 	totalRows($connect, $sqlCount);
$total_pages 	= 	ceil($total_rows / $limit)
?> 
<html>
    <head>
        <title>User | E - Donate Mo</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">	
        <link rel="stylesheet" type="text/css" href="css/user.css">	
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<style type="text/css">
			.add-btn {
				color: #fff;
				background-color: #0e9d24;
				padding: 8px 12px;
				font-size: 18px!important;
			}
		</style>
    </head>

    <body> 
        <?php include 'header.php'; ?>
       
        <div class="wrapper">
            
		    <form class="searchBarContainer" action="user.php" method="get">
		    	<input class="searchbar" type="text" name="search" placeholder="Search users..." value="<?php echo $search; ?>"> 
				<button class="searchBtn" type="submit"><i class='bx bx-search-alt-2' ></i></button>
				<a class="searchBtn add-btn" href="user-create.php">New</a>
		    </form>
		    <table style="margin-bottom: 20px;" width="100%">
		    	<thead>
		    		<tr>
						<th>Name</th>
		    			<th>Email</th>
		    			<th>Contact</th>
		    			<th>Action</th>
		    		</tr>
		    	</thead>
		    	<tbody>
		    		<?php
		    		while ($row = $result->fetch_assoc()): ?>
					<tr>
						<td><?=$row['name'] ?></td>
						<td><?=$row['email'] ?></td>
						<td><?=$row['contact'] ?></td>
						<td>
							<a style="font-size: 20px;color: #fff;" class="actionBtn" href="user-edit.php?id=<?=$row['id'] ?>"><i class='bx bx-edit-alt'></i></a>
							<!-- <a style="font-size: 20px;color: #fff;" class="actionBtn" href="javascript:void(0)" onclick="confirmDelete(<?=$row['id']?>)"><i class='bx bx-trash-alt'></i></a> -->
						</td>
					</tr>
		    		<?php endwhile; ?>
		    	</tbody>
		    </table>
			<center>
		    	<?=pagination($page, $total_pages, $search); ?>
			</center>
        </div>
		<script>
			function confirmDelete(userId) {
				var confirmation = confirm("Are you sure you want to delete this user?")

				if(confirmation) {
					window.location.href = "user.php?userDelete=" + userId
				}
			}
		</script>
        <?php 
        include 'footer.php';
			$connect->close();
        ?>
    </body>
</html>