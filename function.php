<?php

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


function userList($connect, $sql)
{
	$result = $connect->query($sql);
	return $result;

	while ($row = $result->fetch_assoc()) {
		var_dump($row);
	}
	return $rows;
}

function pagination($page, $total_pages)
{
	$pagination = '';
    if ($page == 1) {
    	$pagination .= '<a href="javascript:void(0)">Previous</a> ';
    } else {
    	$pagination .= '<a href="user.php?page=' . ($page--) . '">Previous/a> ';
    }

    $pagination .= $page . ' of ' . $total_pages;

    if ($page == $total_pages) {
    	$pagination .= ' <a href="javascript:void(0)">Next</a>';
    } else {
    	$pagination .= ' <a href="user.php?page=' . ($page++) . '">Next</a>';
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
?>