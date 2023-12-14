<?php
session_start();
include 'check-session.php';
include 'function.php';
require 'db-connect.php';

$show = isset($_GET['load']) && $_GET['load'] != '' ? $_GET['load'] : '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $title          =   isset($_POST['title'])          ? $_POST['title']           :   '';
    $description    =   isset($_POST['description'])    ? $_POST['description']     :   '';
    $phone          =   isset($_POST['phone'])          ? $_POST['phone']           :   '';
    $email          =   isset($_POST['email'])          ? $_POST['email']           :   '';
    $address        =   isset($_POST['address'])        ? $_POST['address']         :   '';
    $image          =   isset($_FILES['image'])         ? $_FILES['image']          :   [];
    
    createPost(
        $connect,
        $title,
        $description,
        $phone,
        $email,
        $address,
        $image
    );
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
            <form action="<?=$_SERVER['PHP_SELF']  ?>" method="POST" class="custom-form" enctype="multipart/form-data">
                <label for="title">Title:</label>
                <input placeholder="Enter title" type="text" id="title" name="title" required>

                <label for="description">Description:</label>
                <textarea placeholder="Enter Description" id="description" name="description" rows="4" required></textarea>

                <label for="phone">Phone:</label>
                <input placeholder="Enter phone or tel number" type="number" id="phone" name="phone" maxlength="11" required>

                <label for="email">Email:</label>
                <input placeholder="Enter email address" type="email" id="email" name="email" required>

                <label for="address">Address:</label>
                <input placeholder="Enter address" type="text" id="address" name="address" required>

                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*">

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    <?php
    include 'footer.php';
    ?>

</body>

</html>
