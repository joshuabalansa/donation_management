<?php
session_start();
include 'check-session.php';
include 'function.php';
require 'db-connect.php';

if (!isset($_GET['id'])) {
    exit;
}

$id = $_GET['id'];

$sql = "SELECT * FROM posts WHERE id='$id'";
$result = $connect->query($sql);
$row = $result->fetch_assoc();

if (is_null($row)) {
    exit;
}

$title = $row['title'];
$description = $row['description'];
$phone = $row['phone'];
$address = $row['address'];
$brgy = $row['brgy'];
$city = $row['city'];
$province = $row['province'];
$image = '';
$success = '';

if (isset($_POST['submitPost'])) {

    $title = $connect->real_escape_string($_POST['title']);
    $description = $connect->real_escape_string($_POST['description']);
    $phone = $connect->real_escape_string($_POST['phone']);
    $brgy = $connect->real_escape_string($_POST['brgy']);
    $address = $connect->real_escape_string($_POST['address']);
    $address = $connect->real_escape_string($_POST['city']);
    $address = $connect->real_escape_string($_POST['province']);

    $error = [];

    if (empty($title)) {
        $error['title'] = 'Title is required!';
    }

    if (empty($description)) {
        $error['description'] = 'Description is required!';
    }

    if (empty($phone)) {
        $error['phone'] = 'Phone is required!';
    }

    if (empty($brgy)) {
        $error['brgy'] = 'Brgy is required!';
    }

    if (empty($address)) {
        $error['address'] = 'Address is required!';
    }
    if (empty($city)) {
        $error['city'] = 'City is required!';
    }
    if (empty($province)) {
        $error['province'] = 'Province is required!';
    }

    if (count($error) <= 0) {

        $user_id = $_SESSION['user']['id'];
        $image = $_FILES['image'];
        $image_dir = "uploads/post/" . basename($image["name"]);

        $sql = "UPDATE posts SET title='$title', description='$description', phone='$phone', address='$address', brgy='$brgy', city='$city', province='$province', user_id='$user_id', image='$image_dir' WHERE id='$id'";

        if ($connect->query($sql) === TRUE) {

            alert_message("Post updated successfully");

            header('location: posts.php');
        } else {
            $success = "Error: " . $sql . "<br>" . $connect->error;
        }

        $connect->close();
    }
}

?>
<html>

<head>
    <title>Donation | E - Donate Mo</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        .post-wrapper {
        width: 50%;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .post-titleBar {
        background-color: #007bff;
        padding: 10px;
        text-align: center;
    }

    h2 {
        color: #fff;
        margin: 0;
    }

    .post-formWrapper {
        padding: 20px;
    }

    .post-form {
        display: grid;
        grid-gap: 10px;
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }

    input,
    textarea {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        background-color: #007bff;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="post-wrapper">
        <div class="post-title-bar">
            <h3 style="color: #152340;">Edit</h3> <br>
        </div>
        <div class="post-form-wrapper">
            <?php echo $success = ""; ?>
            <form action="post-edit.php?id=<?php echo $id;?>" method="POST" class="post-form" enctype="multipart/form-data">
                <label for="title">Title: <?php echo (isset($error['name'])) ? $error['name'] : ''; ?></label>
                <input placeholder="Enter title" type="text" id="title" name="title" value="<?php echo $title; ?>" required>

                <label for="description">Description: <?php echo (isset($error['description'])) ? $error['description'] : ''; ?></label>
                <textarea placeholder="Enter Description" id="description" name="description" rows="4" required><?php echo $description; ?></textarea>

                <label for="phone">Phone: <?php echo (isset($error['phone'])) ? $error['phone'] : ''; ?></label>
                <input placeholder="Enter phone or tel number" type="number" id="phone" name="phone" maxlength="11" value="<?php echo $phone; ?>" required>

                <label for="address">Address: <?php echo (isset($error['address'])) ? $error['address'] : ''; ?></label>
                <input placeholder="Enter address" type="text" id="address" name="address" value="<?php echo $address; ?>" required>

                <label for="brgy">Brgy: <?php echo (isset($error['brgy'])) ? $error['brgy'] : ''; ?></label>
                <input placeholder="Enter Barangay" type="text" id="brgy" name="brgy" value="<?php echo $brgy; ?>" required>

                <label for="city">City: <?php echo (isset($error['city'])) ? $error['city'] : ''; ?></label>
                <input placeholder="Enter Barangay" type="text" id="city" name="city" value="<?php echo $city; ?>" required>

                <label for="province">Province: <?php echo (isset($error['province'])) ? $error['province'] : ''; ?></label>
                <input placeholder="Enter Province" type="text" id="province" name="province" value="<?php echo $province; ?>" required>

                <label for="image">Image: <?php echo (isset($error['image'])) ? $error['image'] : ''; ?></label>
                <input type="file" id="image" name="image" accept="image/*" required>

                <button type="submit" name="submitPost">Update Post</button>
            </form>
        </div>
    </div>
    <?php #include 'footer.php'; ?>

</body>

</html>