<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

$search = '';
$page = (isset($_GET['page']))? $_GET['page'] : 1;
$limit = 2;
$skip = ($page - 1) * $limit;
$sql = "SELECT * FROM users ";
$sqlCount = "SELECT COUNT(*) totalRows FROM users ";

if (isset($_GET['search'])) {

   $search = $connect->real_escape_string($_GET['search']);
	$sql .= "WHERE name LIKE '$search%' OR email LIKE '$search%' OR contact LIKE '$search%' ";
	$sqlCount .= "WHERE name LIKE '$search%' OR email LIKE '$search%' OR contact LIKE '$search%' ";

}

$sql .= "LIMIT $skip, $limit";

$result = userList($connect, $sql);
$total_rows = totalRows($connect, $sqlCount);
$total_pages = ceil($total_rows / $limit)
?> 
<html>
    <head>
        <title>User | E - Donate Mo</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">	
        <link rel="stylesheet" type="text/css" href="css/user.css">	
		<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    </head>

    <body>
        <?php 
        include 'header.php';
        ?>
        <div class="wrapper">
            
		    <form class="searchBarContainer" action="user.php" method="get">
		    	<input class="searchbar" type="text" name="search" placeholder="Search users..." value="<?php echo $search; ?>"> 
				<input class="searchBtn" type="submit" value="Search">
		    </form>
		    <table width="100%">
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
							<a class="actionBtn" href="javascript:void(0)">Edit</a>
							<a class="actionBtn" href="function.php?userDelete=<?=$row['id'] ?>">Delete</a>
						</td>
					</tr>
		    		<?php endwhile; ?>
		    	</tbody>
		    </table>
		    <?=pagination($page, $total_pages, $search); ?>
        </div>
        <?php 
        include 'footer.php';
			$connect->close();
        	?>
    </body>
</html>