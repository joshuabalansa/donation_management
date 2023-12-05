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
    </head>

    <body>
        <?php 
        include 'header.php';
        ?>
        <div class="wrapper">
            
		    <form action="user.php" method="post">
		    	<input type="text" name="search" value="<?php echo $search; ?>">
		    </form>
		    <table width="100%">
		    	<thead>
		    		<tr>
		    			<th width="10%">Action</th>
		    			<th width="40%">Name</th>
		    			<th width="25%">Email</th>
		    			<th width="25%">Contact</th>
		    		</tr>
		    	</thead>
		    	<tbody>
		    		<?php
		    		while ($row = $result->fetch_assoc()) {
		    			echo '<tr><td></td>';
		    			echo '<td>' . $row['name'] . '</td>';
		    			echo '<td>' . $row['email'] . '</td>';
		    			echo '<td>' . $row['contact'] . '<td></tr>';
		    		}
		    		?>
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