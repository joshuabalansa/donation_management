<?php
    session_start();

    include "check-session.php";
    include "function.php";
    require "db-connect.php";

    if(isset($_POST['submit'])) {

        if($_SERVER['REQUEST_METHOD'] === "POST") {

            $postId = isset($_GET['feed_id']) ? $_GET['feed_id'] : '';
            $userId = $_SESSION['user']['id'];

            $donationType   = isset($_POST['donation_type'])    ?   $_POST['donation_type'] : '';
            $donation       = isset($_POST['donation'])         ?   $_POST['donation'] : '';
            $image          = isset($_FILES['image'])           ? $_FILES['image'] : [];

            if ($image['error'] !== UPLOAD_ERR_OK) {
                die("File upload failed with error code: " . $image['error']);
            }
            
            donate(
                $connect,
                $donationType,
                $donation,
                $image,
                $postId,
                $userId
            );
            exit;
        }
    }

    $postId = $_GET['feed_id'];
    $sql = "SELECT * FROM posts WHERE id = $postId ORDER BY id DESC LIMIT 500";
    $result = postList($connect, $sql);
?>

<html>
<head>
    <title>Posts | E - Donate Mo</title>
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/post-feed-info.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="feed-wrapper">
        <?php
        while ($row = $result->fetch_assoc()) :
            $img_placeholder = 'https://placehold.jp/300x300.png';
            $user = getUserDetails($connect, $row['user_id']);
        ?>
            <div class="feed-item">
                <img src="<?= ((empty($row['image'])) ? $img_placeholder : $row['image']) ?>" alt="Post Image">
                <div class="donation-form">

                    <div style="margin: 10px;">
                        <h1><?= ucfirst($row['title']) ?></h1>
                        <small>
                            <?=$row['description'] . '<br><br>' . 'Phone: ' . $row['phone'] . '<br>'. 'Address: ' . $row['address'] .' ' . $row['brgy'] .' ' . $row['city'] . '<br><br>' . 'Created at: ' .$row['created_at'] ?>
                        </small>
                    </div>

                    <form action="post-feed-info.php?feed_id=<?=$_GET['feed_id'] ?>" method="post" enctype="multipart/form-data">
                        <select name="donation_type" id="donationType" onchange="updateAmountPlaceholder()" required>
                            <option value="monetary">Monetary</option>
                            <option value="goods">Goods</option>
                        </select>

                        <input type="text" id="amountInput" name="donation" placeholder="Amount" required>

                        <input type="file" name="image" id="image" required>

                        <button name="submit" type="submit" class="donate-button">Donate</button>
                        <a href="main.php" type="submit">Back</a>

                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", function () {

        function updateAmountPlaceholder() {
            var donationType = document.getElementById('donationType');
            var amountInput = document.getElementById('amountInput');
            var image = document.getElementById('image');

            if (donationType.value === 'goods') {
                amountInput.type = 'text';
                amountInput.placeholder = 'Enter type of Goods';
            } else {
                amountInput.type = 'number';
                amountInput.placeholder = 'Enter Amount';
            }
        }
        document.getElementById('donationType').addEventListener('change', updateAmountPlaceholder);
        updateAmountPlaceholder();
    });

    function confirmDonate(donationId) {
                 var confirmation = confirm("Are you sure you want proceed?")

                 if (confirmation) {
                    window.location.href = "donation.php?donationDelete=" + donationId
                 }
            }
</script>
<?php #include 'footer.php'; ?>
</body>

</html>
