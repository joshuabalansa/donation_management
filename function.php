<?php
include 'db-connect.php';

function returnJson($data)
{
	header("Content-Type: application/json");
	echo json_encode($data);
	exit();
}

function check_user_email($connect, $email)
{
	$sql = "SELECT id FROM users WHERE email='$email'";
	$result = $connect->query($sql);

	if ($result->num_rows > 0) {
		return true;
	} else {
		return false;
	}
}

function check_user_email_except_user($connect, $email, $id)
{
	$sql = "SELECT id FROM users WHERE id<>'$id' AND email='$email'";
	$result = $connect->query($sql);

	if ($result->num_rows > 0) {
		return true;
	} else {
		return false;
	}
}


function authUser($connect, $email, $password)
{
	$sql = "SELECT * FROM users WHERE email='$email' AND  password='" . md5($password) . "' LIMIT 1";

	$result = $connect->query($sql);
	$row = $result->fetch_assoc();

	return $row;
}


function authUserToken($connect, $id)
{
	$token = md5($id);
	$sql = "UPDATE users SET token='$token' WHERE id='$id' LIMIT 1";

	$result = $connect->query($sql);

	return $token;
}


function userList($connect, $sql)
{
	$result = $connect->query($sql);
	return $result;

	while ($row = $result->fetch_assoc()) {
		var_dump($row);
	}
	return $rows;
}

function totalRows($connect, $sql)
{
	$result = $connect->query($sql);
	$row = $result->fetch_assoc();
	return $row['totalRows'];
}

function pagination($page, $total_pages, $search)
{
	$search_str = ($search != '')? '&search=' . $search : '';
	$pagination = '';
    if ($page <= 1) {
    	$pagination .= '<a style="color: #fff;" href="javascript:void(0)">Previous</a> ';
    } else {
    	$pagination .= '<a style="color: #fff;" href="user.php?page=' . ($page-1) . '' . $search_str . '">Previous</a> ';
    }

    $pagination .= "<span style='color: #fff'>" . $page . ' of ' . $total_pages . "</span>";

    if ($page >= $total_pages) {
    	$pagination .= ' <a style="color: #fff;" href="javascript:void(0)">Next</a>';
    } else {
    	$pagination .= ' <a style="color: #fff;" href="user.php?page=' . ($page+1) . '' . $search_str . '">Next</a>';
    }

    return $pagination;
}


function logoutUser()
{
	unset($_SESSION['user']);
	ob_clean();
    header('Location: index.php');
}


function dump($object)
{
	echo '<pre>';
	var_dump($object);
	echo '<pre>';
}

/**
 * User Delete
 */
if (isset($_GET['userDelete'])) {
    deleteUser($connect, $_GET['userDelete']);
}

function deleteUser($connect, $userId) {

	$stmt = $connect->prepare('DELETE FROM users WHERE id = ?');
	$stmt->bind_param("i", $userId);

	if($stmt->execute()) {
		header('location: user.php');
		exit();
	} else {
		echo "Error Deleting user" . $stmt->error;
	}
	$stmt->close();
}
?>