<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edonatemo_web";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for denying a record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deny'])) {
    $donationID = $_POST['donation_id'];

    // Update the record status to 'Denied' in the Donations table
    $denyDonationSQL = "UPDATE Donations SET Status='Denied' WHERE DonationID = $donationID";
    $conn->query($denyDonationSQL);
}

// Redirect to main.php after denying
header("Location: main.php?load=donations");

// Close the connection
$conn->close();
?>
