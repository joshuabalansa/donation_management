<?php
session_start();
include 'check-session.php';
include 'function.php';
require 'db-connect.php';

$show = isset($_GET['load']) && $_GET['load'] != '' ? $_GET['load'] : '';

$id = isset($_GET['donationEdit']) ? $_GET['donationEdit'] : '';

$donation = isset($id) ? getDonationById($connect, $id) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    updateDonationRecord($connect, $_POST);
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation | E - Donate Mo</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/donation-create.css">
        <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
</head>

<body>
    <?php
    include 'header.php';
    ?>
    <div class="wrapper">
        <div class="titleBar">
            <h2 style="color: #fff;">Edit Record</h2>
        </div>
        <div class="formWrapper">
            <form action="donation-edit.php" method="POST" class="custom-form">
                <input type="hidden" name="id" value="<?= $donation['id'] ?>">

                <label for="post_id">Post:</label>
                <select id="post_id" name="post_id" required>
                    <?php
                    echo postListing($connect);
                    ?>
                </select>

                <label for="name">name:</label>
                <input type="text" value="<?=$donation['name'] ?>" id="name" name="name" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required><?=$donation['description']?></textarea>

                <label for="phone">Phone:</label>
                <input type="number" value="<?=$donation['phone']?>" id="phone" name="phone" maxlength="11" required>

                <label for="brgy">Brgy:</label>
                <input type="text" value="<?=$donation['brgy']?>" id="brgy" name="brgy" required>

                <label for="donationType">Donation Type:</label>
                <select id="donationType" name="donationType" required>
                    <option value="monetary">Monetary</option>
                    <option value="goods">Goods</option>
                </select>

                <label for="donation">Donation:</label>
                <input type="text" value="<?=$donation['donation']?>" id="donation" name="donation" required>

                <button type="submit">Save</button>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script>
        $(function(){
            $('#post_id').val('<?php echo $donation['post_id']; ?>');
        });
    </script>
</body>

</html>
