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


function authUser($connect, $email, $password)
{
	$sql = "SELECT * FROM users WHERE email='$email' AND  password='" . md5($password) . "' LIMIT 1";

	$result = $connect->query($sql);
	$row = $result->fetch_assoc();

	return $row;
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