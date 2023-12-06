<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

    $show = (isset($_GET['load']) && $_GET['load'] !='') ? $_GET['load'] : '';
?> 
<html>
    <head>
        <title>Donation | E - Donate Mo</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">	
        <link rel="stylesheet" href="css/donations.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
        <?php 
        include 'header.php';
        ?>
        <div class="wrapper">
            
            <h2 style="color: #fff;">Donation Information</h2>
            <button onclick="openModal()">Manually Add a Record</button>
            <table>
                <thead>
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
                </thead>
                <tbody>
                    <tr>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                    </tr>
                </tbody>

            </table>
        </div>
        <?php 
        include 'footer.php';
        ?>

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
            </div>
        </div>

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