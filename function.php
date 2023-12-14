<?php
include 'db-connect.php';

function returnJson($data)
{
	header("Content-Type: application/json");
    	header('Access-Control-Allow-Credentials: true');
    	header('Access-Control-Max-Age: 86400');
	
	if (isset($_SERVER['HTTP_ORIGIN'])) {
	    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	} else {
	    header("Access-Control-Allow-Origin: *");
	}
	
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
	session_destroy();
    header('Location: index.php');
}


function dump($object)
{
	echo '<pre>';
	print_r($object);
	echo '<pre>';
}

function deleteUser($connect, $userId) {

	try {
		$stmt = $connect->prepare('DELETE FROM users WHERE id = ?');
		$stmt->bind_param("i", $userId);

		if($stmt->execute()) {
			header('location: user.php');
			exit();
		} else {

			echo "Opps! Something went wrong, ".$stmt->error;
		}
		$stmt->close();
	} catch(Exception $e) {
		echo "Caught exception" . $e->getMessage();
	}
}

function insertDonation($connect, $name, $description, $phone, $email, $donationType, $donation, $image) {

	$target_dir = "uploads/";
    $target_file = $target_dir . basename($image["name"]);

    move_uploaded_file($image["tmp_name"], $target_file);

	try {
		$sql = "INSERT INTO donations (name, description, phone, email, donationType, donation, image)
		VALUES (?, ?, ?, ?, ?, ?, ?)";

		$stmt = $connect->prepare($sql);
		$stmt->bind_param("sssssss",  $name, $description, $phone, $email, $donationType, $donation, $target_file);

		if($stmt->execute()) {
			header('location: donation.php');
		} else {
			echo "Opps! Something went wrong," . $stmt->error();
		}
	} catch(Exception $e) {
		echo "Caught exception" . $e->getMessage();
	}
}

function getDonationById($connect, $id) {
    $sql = "SELECT * FROM donations WHERE id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $donation = $result->fetch_assoc();
    } else {
        $donation = [];
    }

    $stmt->close();

    return $donation;
}

function deleteDonationById($connect, $id) {
	try {
		$sql = "DELETE FROM donations WHERE id = ?";
		$stmt = $connect->prepare($sql);
		$stmt->bind_param('i', $id);

		if($stmt->execute()) {
			header('location: donation.php');
		} else {
			echo "Opps! Something went wrong" .  $stmt->error();
		}
	} catch(Exception $e) {
		echo "Caught exception" . $e->getMessage();
	}
}


function updateDonationRecord($connect, $data) {

	$id = isset($data['id']) ? $data['id'] : '';
	$name = isset($data['name']) ? $data['name'] : '';
	$description = isset($data['description']) ? $data['description'] : '';
	$phone = isset($data['phone']) ? $data['phone'] : '';
	$email = isset($data['email']) ? $data['email'] : '';
	$donationType = isset($data['donationType']) ? $data['donationType'] : '';
	$donation = isset($data['donation']) ? $data['donation'] : '';

	try {

		$sql = "UPDATE donations SET name = ?, description = ?, phone = ?, email = ?, donationType = ?, donation = ? WHERE id = ?";
		$stmt = $connect->prepare($sql);
		$stmt->bind_param('ssssssi', $name, $description, $phone, $email, $donationType, $donation, $id);

		if ($stmt->execute()) {

			header('location: donation.php');
		} else {

			echo "Opps! Something went wrong" . $stmt->error();
		}
		$stmt->close();
		$connect->close();

	} catch(Exception $e) {
		echo "Caught exception: " . $e->getMessage();
	}
}

function createPost($connect, $title, $description, $phone, $email, $address, $image) {

	try {
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($image["name"]);
	
		move_uploaded_file($image["tmp_name"], $target_file);
	
		$sql = "INSERT INTO posts (title, description, phone, email, address, image) VALUES (?, ?, ?, ?, ?, ?)";

		$stmt = $connect->prepare($sql);
		$stmt->bind_param('ssssss', $title, $description, $phone, $email, $address, $target_file);

		if($stmt->execute()) {
			header('location: posts.php');
		} else {
			echo "Opps! Something went wrong" . $stmt->error();
		}
			
	} catch (Exception $e) {
		echo "Caught Exception" . $e->getMessage();
	}
}

?>