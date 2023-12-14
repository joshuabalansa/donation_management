<?php
session_start();
include 'check-session.php';
include 'function.php';
require 'db-connect.php';

$title = '';
$description = '';
$phone = '';
$brgy = '';
$address = '';
$success = '';
$image = '';

if (isset($_POST['submitPost'])) {

    $title = $connect->real_escape_string($_POST['title']);
    $description = $connect->real_escape_string($_POST['description']);
    $phone = $connect->real_escape_string($_POST['phone']);
    $brgy = $connect->real_escape_string($_POST['brgy']);
    $address = $connect->real_escape_string($_POST['address']);

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

    if (count($error) <= 0) {

        $user_id = $_SESSION['user']['id'];
        $image = $_FILES['image'];
        $image_dir = "uploads/post/" . basename($image["name"]);

        $sql = "INSERT INTO posts (title, description, phone, brgy, address, user_id, created_at, image) VALUES ('$title', '$description', '$phone', '$brgy', '$address', '$user_id', NOW(), '$image_dir')";

        if ($connect->query($sql) === TRUE) {
            $success = 'Post created successfully';
        } else {
            $success = "Error: " . $sql . "<br>" . $connect->error;
        }

        $connect->close();

        $title = '';
        $description = '';
        $phone = '';
        $brgy = '';
        $address = '';
        $success = '';
    }
}

?>
<html>

<head>
    <title>Donation | E - Donate Mo</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/donation-create.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php
    include 'header.php';
    ?>
    <div class="wrapper">
        <div class="titleBar">
            <h2 style="color: #fff;">Create a post</h2>
        </div>
        <div class="formWrapper">
            <?php echo $success; ?>
            <form action="post-create.php" method="POST" class="custom-form" enctype="multipart/form-data">
                <label for="title">Title: <?php echo (isset($error['name']))? $error['name'] : '';?></label>
                <input placeholder="Enter title" type="text" id="title" name="title" value="<?php echo $title; ?>" required>

                <label for="description">Description: <?php echo (isset($error['description']))? $error['description'] : '';?></label>
                <textarea placeholder="Enter Description" id="description" name="description" rows="4" required><?php echo $description; ?></textarea>

                <label for="phone">Phone: <?php echo (isset($error['phone']))? $error['phone'] : '';?></label>
                <input placeholder="Enter phone or tel number" type="number" id="phone" name="phone" maxlength="11" value="<?php echo $phone; ?>" required>

                <label for="brgy">Brgy: <?php echo (isset($error['brgy']))? $error['brgy'] : '';?></label>
                <input placeholder="Enter Barangay" type="text" id="brgy" name="brgy" value="<?php echo $brgy; ?>" required>

                <label for="address">Address: <?php echo (isset($error['address']))? $error['address'] : '';?></label>
                <input placeholder="Enter address" type="text" id="address" name="address" value="<?php echo $address; ?>" required>

                <label for="image">Image: <?php echo (isset($error['image']))? $error['image'] : '';?></label>
                <input type="file" id="image" name="image" accept="image/*" required>

                <button type="submit" name="submitPost">Submit</button>
            </form>
        </div>
    </div>
    <?php
    include 'footer.php';
    ?>

</body>

</html>
