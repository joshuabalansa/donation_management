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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve'])) {
    $donationID = $_POST['donation_id'];
    $approvedBy = "Admin";  // Change this to the actual user who approves

    // Update status in Donations table
    $updateStatusSQL = "UPDATE Donations SET Status = 'Approved' WHERE DonationID = $donationID";
    $conn->query($updateStatusSQL);

    // Insert approval record into DonationApprovalLog
    $insertApprovalLogSQL = "INSERT INTO DonationApprovalLog (DonationID, ApprovedBy, ApprovalStatus) VALUES ($donationID, '$approvedBy', 'Approved')";
    $conn->query($insertApprovalLogSQL);
}

// Redirect to main.php after approval
header("Location: main.php?load=donations");
exit();
?>
