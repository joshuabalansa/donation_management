<?php
session_start();
include 'check-session.php';
include 'function.php';
require 'db-connect.php';

$show = isset($_GET['load']) && $_GET['load'] != '' ? $_GET['load'] : '';


if($_SERVER["REQUEST_METHOD"] == "POST") {

    $post_id        =   isset($_POST['post_id'])          ?    $_POST['post_id']      : '';
    $description    =   isset($_POST['description'])   ?    $_POST['description']   : '';
    $phone          =   isset($_POST['phone'])         ?    $_POST['phone']         : '';
    $brgy           =   isset($_POST['brgy'])         ?    $_POST['brgy']         : '';
    $donationType   =   isset($_POST['donationType'])  ?    $_POST['donationType']  : '';
    $donation       =   isset($_POST['donation'])        ?    $_POST['donation']        : '';
    $image          =   isset($_FILES['image'])        ?    $_FILES['image']        : [];

    insertDonation($connect,
        $post_id,
        $description,
        $phone,
        $brgy,
        $donationType,
        $donation,
        $image,
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
            <h2 style="color: #fff;">Add Record</h2>
        </div>
        <div class="formWrapper">
            <form action="<?=$_SERVER['PHP_SELF'] ?>" method="POST" class="custom-form" enctype="multipart/form-data">

                <label for="post_id">Post:</label>
                <select id="post_id" name="post_id" required>
                    <?php
                    echo postListing($connect);
                    ?>
                </select>

                <label for="name">Name:</label>
                <input placeholder="Enter name of donor" type="text" id="name" name="name" required>

                <label for="description">Description:</label>
                <textarea placeholder="Enter Description" id="description" name="description" rows="4" required></textarea>

                <label for="phone">Phone:</label>
                <input placeholder="Enter phone or tel number" type="number" id="phone" name="phone" maxlength="11" required>

                <label for="brgy">Brgy:</label>
                <input placeholder="Enter Brgy" type="text" id="brgy" name="brgy" required>

                <label for="donationType">Donation Type:</label>
                <select id="donationType" name="donationType" required>
                    <option value="">Select Type</option>
                    <option value="monetary">Monetary</option>
                    <option value="goods">Goods</option>
                </select>

                <label for="donation">Donation:</label>
                <input placeholder="Enter donation" type="text" id="donation" name="donation">

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
