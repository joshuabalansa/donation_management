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

function getUserDetails($connect, $id)
{
	$sql = "SELECT * FROM users WHERE id='$id' LIMIT 1";

	$result = $connect->query($sql);
	$row = $result->fetch_assoc();

	return $row;
}

function userList($connect, $sql)
{
	$result = $connect->query($sql);
	return $result;
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

function alert_message($alert_message) {
	$_SESSION['alert_message'] = $alert_message;
}

function get_alert_Message() {
	if (isset($_SESSION['alert_message'])) {
		echo '<script>alert("' . $_SESSION['alert_message'] . '");</script>';
		unset($_SESSION['alert_message']);
		session_write_close();
	}
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
	echo '</pre>';
}

function dd($object)
{
	echo '<pre>';
	print_r($object);
	echo '</pre>';
	die();
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

function postList($connect, $sql)
{
	$result = $connect->query($sql);

	return $result;
}

function postPagination($page, $total_pages, $search)
{
	$search_str = ($search != '')? '&search=' . $search : '';
	$pagination = '';
    if ($page <= 1) {
    	$pagination .= '<a style="color: #fff;" href="javascript:void(0)">Previous</a> ';
    } else {
    	$pagination .= '<a style="color: #fff;" href="posts.php?page=' . ($page-1) . '' . $search_str . '">Previous</a> ';
    }

    $pagination .= "<span style='color: #fff'>" . $page . ' of ' . $total_pages . "</span>";

    if ($page >= $total_pages) {
    	$pagination .= ' <a style="color: #fff;" href="javascript:void(0)">Next</a>';
    } else {
    	$pagination .= ' <a style="color: #fff;" href="posts.php?page=' . ($page+1) . '' . $search_str . '">Next</a>';
    }

    return $pagination;
}

function postDelete($connect, $postId) {
	try {
		$sql = "DELETE FROM posts WHERE id = ?";
		$stmt = $connect->prepare($sql);
		$stmt->bind_param('i', $postId);

		if ($stmt->execute()) {
			header('location: posts.php');
		} else {
			die($stmt->error);
		}
	} catch (Exception $e) {
		die("Caught Exception: " . $e->getMessage());
	}
}


function postListing($connect)
{
	$sql = "SELECT *, (SELECT name FROM users WHERE id=posts.user_id LIMIT 1) user_post FROM posts ORDER BY id DESC LIMIT 1000";

	$result = $connect->query($sql);
	$options = '<option value=""></option>';
	while($row = $result->fetch_assoc()) {
		$options .= '<option value="'.$row['id'].'">'.$row['title'].' ('.$row['user_post'].')</option>';
	}

	return $options;
}

// update status
function updateStatus($connect, $table, $postId, $status, $redirect) {
    try {
        $sql = "UPDATE $table SET status = ? WHERE id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param('si', $status, $postId);

        if ($stmt->execute()) {
            header("location: $redirect");
        } else {
            die($stmt->error);
        }
    } catch (Exception $e) {
        die("Caught Exception: " . $e->getMessage());
    }
}

// update status to expired if date now > post expiry_date

function updateExpirationDate($connect) {

	try {
		$currentDate = date("Y-m-d");
		$sql = "UPDATE posts SET status = 'expired' WHERE expiry_date <= ?";
		$stmt = $connect->prepare($sql);
		
		if (!$stmt) {
			die("Error preparing statement: " . $connect->error);
		}
		
		$stmt->bind_param("s", $currentDate);
		$stmt->execute();
	} catch(Exception $e) {
		
		echo "<script>alert('Opps! Something went wrong')</script>";
	}
		
}

function postDisapproved($connect, $postId, $status) {

	try {
		$sql = "UPDATE posts SET status = ? WHERE id = ?";
		$stmt = $connect->prepare($sql);
		$stmt->bind_param('si', $status, $postId);
		
		if($stmt->execute()) {
			header('location: posts.php');
		} else {
			die($stmt->error);
		}
	} catch(Exception $e) {
		die("Caught Exception: " . $e->getMessage());
	}
}


function createPost($connect, $title, $description, $phone, $address, $brgy, $city, $province, $expiry_date, $image, $user_id) {

	try {
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($image["name"]);

		if (move_uploaded_file($image["tmp_name"], $target_file)) {


			$sql = "INSERT INTO posts (title, description, phone, address, brgy, city, province, expiry_date, image, user_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?,?, ?, ?, CURRENT_TIMESTAMP)";
			$stmt = $connect->prepare($sql);
			$stmt->bind_param('sssssssssi', $title, $description, $phone, $address, $brgy, $city, $province, $expiry_date, $target_file, $user_id);

			if($stmt->execute()) {
				session_start();
                $_SESSION['alert_message'] = "Your submission is in the review queue";
                session_write_close();
				$stmt->close();
				header('location: posts.php');
				exit;
			} else {
				die("Oops! Something went wrong: " . $stmt->error);
			}

		} else {
			die("Failed to move the uploaded file.");
		}

	} catch (Exception $e) {
		die("Caught Exception: " . $e);
	}
}

function donate($connect, $donationType, $donation, $image, $postId, $userId) {

    try {
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($image["name"]);

		if(move_uploaded_file($image["tmp_name"], $target_file)) {
			$sql = "INSERT INTO donations (donation_type, donation, image, post_id, user_id, created_at)
					VALUES (?, ?, ?, ?, ?, ?)";

			$currentTimestamp = date("Y-m-d H:i:s");

			$stmt = $connect->prepare($sql);
			$stmt->bind_param('sssiis', $donationType, $donation, $target_file, $postId, $userId, $currentTimestamp);

			if($stmt->execute()) {

				header('location: main.php');
			} else {
				die("Oops! Something went wrong," . $stmt->error());
			}
		}else {
			die("Failed to move the uploaded file.");
		}
    } catch(Exception $e) {
        die("Caught Exception: " . $e);
    }
}




?>
