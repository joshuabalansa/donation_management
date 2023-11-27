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
    // Retrieve form data
    $donationID = $_POST['donation_id'];
    $userName = $_POST['user_name'];
    $phoneNumber = $_POST['phone_number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $donationType = $_POST['donation_type'];
    $description = $_POST['description'];
    $imageURL = $_POST['image_url'];

    // Update the record in the database
    $updateUserSQL = "UPDATE Users SET UserName='$userName', PhoneNumber='$phoneNumber', Email='$email', Address='$address' WHERE UserID = (SELECT UserID FROM Donations WHERE DonationID = $donationID)";
    $conn->query($updateUserSQL);

    $updateDonationSQL = "UPDATE Donations SET DonationType='$donationType', Description='$description', ImageURL='$imageURL' WHERE DonationID = $donationID";
    $conn->query($updateDonationSQL);
}

// Retrieve data from the database
$sql = "SELECT Users.UserID, Users.UserName, Donations.DonationID, Donations.Description, Users.PhoneNumber, Users.Email, Donations.DonationType, Donations.Status, Donations.ImageURL
        FROM Users
        INNER JOIN Donations ON Users.UserID = Donations.UserID";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="styleheet" href="css/style.css">
    <link rel="stylesheet" href="donations.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Information</title>
    
    <!-- Modal styles -->
</head>
<body>

<h2>Donation Information</h2>
<button onclick="openModal()">Manually Add a Record</button>
<table>
    <tr>
        <th>Username</th>
        <th>Description</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Donation Type</th>
        <th>Status</th>
        <th>Image</th>
        <th>Action</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

			$rowClass = '';
            if ($row["Status"] === "Approved") {
                $rowClass = 'approved-row';
            } elseif ($row["Status"] === "Denied") {
                $rowClass = 'denied-row';
            }	
            echo "<tr class='$rowClass'>";
            echo "<td>" . $row["UserName"] . "</td>";
            echo "<td>" . $row["Description"] . "</td>";
            echo "<td>" . $row["PhoneNumber"] . "</td>";
            echo "<td>" . $row["Email"] . "</td>";
            echo "<td>" . $row["DonationType"] . "</td>";
            echo "<td id='status'>" . $row["Status"] . "</td>";
            echo "<td><img src='" . $row["ImageURL"] . "' alt='Donation Image' width='100'></td>";
            echo "<td>
                    <form method='post' action='edit.php'>
                        <input type='hidden' name='donation_id' value='" . $row["DonationID"] . "'>
                        <input type='submit' name='edit' value='Edit'>
                    </form>
                    <form method='post' action='approve.php'>
                        <input type='hidden' name='donation_id' value='" . $row["DonationID"] . "'>
                        <input type='submit' name='approve' value='Approve'>
                    </form>
                    <form method='post' action='deny.php'>
                        <input type='hidden' name='donation_id' value='" . $row["DonationID"] . "'>
                        <input type='submit' name='deny' value='Deny'>
                    </form>
                    <form method='post' action='delete.php'>
                        <input type='hidden' name='donation_id' value='" . $row["DonationID"] . "'>
                        <input type='submit' name='delete' value='Delete'>
                    </form>
                </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No donations found</td></tr>";
    }
    ?>

</table>

<!-- Manually Add Record Modal -->
<div id="addRecordModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Manually Add Donation Record</h2>
        <form method="post" action="">
            <!-- Your form fields for adding a new record go here -->
            <label for="user_name">Username:</label>
            <input type="text" name="user_name" required><br>

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" required><br>

            <label for="address">Address:</label>
            <input type="text" name="address" required><br>

            <label for="donation_type">Donation Type:</label>
            <input type="text" name="donation_type" required><br>

            <label for="description">Description:</label>
            <textarea name="description" required></textarea><br>

            <label for="image_url">Image URL:</label>
            <input type="text" name="image_url" required><br>

            <input type="submit" name="addRecord" value="Add Record">
        </form>

        <?php
        // Handle form submission for adding a new record
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addRecord'])) {
            // Retrieve form data
            $userName = $_POST['user_name'];
            $phoneNumber = $_POST['phone_number'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $donationType = $_POST['donation_type'];
            $description = $_POST['description'];
            $imageURL = $_POST['image_url'];

            // Insert the new record into the database
            $insertUserSQL = "INSERT INTO Users (UserName, PhoneNumber, Email, Address) VALUES ('$userName', '$phoneNumber', '$email', '$address')";
            $conn->query($insertUserSQL);

            $userID = $conn->insert_id; // Get the ID of the newly inserted user

            $insertDonationSQL = "INSERT INTO Donations (UserID, DonationType, Description, ImageURL) VALUES ($userID, '$donationType', '$description', '$imageURL')";
            $conn->query($insertDonationSQL);

            // Reload the page to see the updated records
            header("Location: main.php?load=donations");
        }
        ?>
    </div>
</div>

<!-- Manually Add Record Button -->


<script>
    // JavaScript functions for opening and closing the modal
    function openModal() {
        document.getElementById("addRecordModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("addRecordModal").style.display = "none";
    }
</script>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>
