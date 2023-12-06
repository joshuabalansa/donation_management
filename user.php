<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

$search = '';
$page = (isset($_GET['page']))? $_GET['page'] : 1;
$limit = 50;
$skip = ($page - 1) * $limit;
$sql = "SELECT * FROM users ";

if (isset($_POST['searchUserBtn'])) {

   $search = $connect->real_escape_string($_POST['search']);
	$sql .= "WHERE name LIKE '$search%' AND email LIKE '$search%' AND contact LIKE '$search%' ";

}

$sql .= "LIMIT $skip, $limit";

if ($page <= 1) {

} else {

}

$result = userList($connect, $sql);
$total_rows = $result->num_rows;
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
            
		    <form class="searchBarContainer" action="user.php" method="post">
		    	<input class="searchbar" type="text" name="search" placeholder="Search users..."> 
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
							<a href="#">Edit</a>
							<a href="#">Delete</a>
						</td>
					</tr>
		    		<?php endwhile; ?>
		    	</tbody>
		    </table>
		    <?php
		    echo pagination($page, $total_pages);
		    /*if ($page == 1) {
		    	echo '<a href="javascript:void(0)">Previous</a> ';
		    } else {
		    	echo '<a href="user.php?page=' . ($page--) . '">Previous/a> ';
		    }

		    echo $page . ' of ' . $total_pages;

		    if ($page == $total_pages) {
		    	echo ' <a href="javascript:void(0)">Next</a>';
		    } else {
		    	echo ' <a href="user.php?page=' . ($page++) . '">Next</a>';
		    }*/
		    ?>
		    
        </div>
        <?php 
        include 'footer.php';
			$connect->close();
        ?>
    </body>
</html>