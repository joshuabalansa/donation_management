<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edonatemo_web";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for deleting a record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $donationID = $_POST['donation_id'];

    // Delete related records from the donationapprovallog table
    $deleteApprovalLogSQL = "DELETE FROM donationapprovallog WHERE DonationID = $donationID";
    $conn->query($deleteApprovalLogSQL);

    // Delete the record from the Donations table
    $deleteDonationSQL = "DELETE FROM Donations WHERE DonationID = $donationID";
    $conn->query($deleteDonationSQL);
}

// Redirect to main.php after deletion
header("Location: main.php?load=donations");

// Close the connection
$conn->close();
?>
