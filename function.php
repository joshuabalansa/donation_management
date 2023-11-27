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


?>