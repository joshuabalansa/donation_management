<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edonatemo_web";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for editing a record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editRecord'])) {
    $donationID = $_POST['donation_id'];
    $userName = $_POST['user_name'];
    $phoneNumber = $_POST['phone_number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $donationType = $_POST['donation_type'];
    $description = $_POST['description'];
    $imageURL = $_POST['image_url'];

    $updateUserSQL = "UPDATE Users SET UserName='$userName', PhoneNumber='$phoneNumber', Email='$email', Address='$address' WHERE UserID = (SELECT UserID FROM Donations WHERE DonationID = $donationID)";
    $conn->query($updateUserSQL);

    $updateDonationSQL = "UPDATE Donations SET DonationType='$donationType', Description='$description', ImageURL='$imageURL' WHERE DonationID = $donationID";
    $conn->query($updateDonationSQL);

    // Redirect back to the main page after editing
    header("Location: main.php?load=donations.php");
    exit();
}

// Retrieve data for the selected record
if (isset($_POST['edit']) && isset($_POST['donation_id'])) {
    $donationID = $_POST['donation_id'];
    $editSQL = "SELECT Users.UserName, Users.PhoneNumber, Users.Email, Users.Address, Donations.DonationType, Donations.Description, Donations.ImageURL
                FROM Users
                INNER JOIN Donations ON Users.UserID = Donations.UserID
                WHERE Donations.DonationID = $donationID";
    $result = $conn->query($editSQL);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userName = $row["UserName"];
        $phoneNumber = $row["PhoneNumber"];
        $email = $row["Email"];
        $address = $row["Address"];
        $donationType = $row["DonationType"];
        $description = $row["Description"];
        $imageURL = $row["ImageURL"];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/edit.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="donations.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Donation Record</title>
</head>
<body>

<h2>Edit Donation Record</h2>
<form method="post" action="">
    <input type="hidden" name="editRecord" value="1">
    <input type="hidden" name="donation_id" value="<?php echo $donationID; ?>">

    <label for="user_name">Username:</label>
    <input type="text" name="user_name" value="<?php echo $userName; ?>" required><br>

    <label for="phone_number">Phone Number:</label>
    <input type="text" name="phone_number" value="<?php echo $phoneNumber; ?>" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo $email; ?>" required><br>

    <label for="address">Address:</label>
    <input type="text" name="address" value="<?php echo $address; ?>" required><br>

    <label for="donation_type">Donation Type:</label>
    <input type="text" name="donation_type" value="<?php echo $donationType; ?>" required><br>

    <label for="description">Description:</label>
    <textarea name="description" required><?php echo $description; ?></textarea><br>

    <label for="image_url">Image URL:</label>
    <input type="text" name="image_url" value="<?php echo $imageURL; ?>" required><br>

    <input type="submit" value="Save Changes">
</form>

</body>
</html>
