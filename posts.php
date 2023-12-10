<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

    $show = (isset($_GET['load']) && $_GET['load'] !='') ? $_GET['load'] : '';
?> 
<html>
    <head>
        <title>Posts | E - Donate Mo</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">	
        <link rel="stylesheet" type="text/css" href="css/donations.css">	
    </head>

    <body>
        <?php 
        include 'header.php';
        ?>
        <div class="wrapper">
        <div class="wrapper">
            <div class="titleBar">
                <h2 style="color: #fff;">Posts</h2>
                <a class="addBtn" href="javascript:void(0)" >Create a Post</a>
            </div>
            <table>
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
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
                        <td colspan="2">
                        <a title="View donation" style="font-size: 20px;color: #fff;" href="javascript:void(0)"><i class='bx bx-list-ul'></i></a>
                        <a title="Edit donation" style="font-size: 20px;color: #fff;" href="javascript:void(0)"><i class='bx bx-edit-alt'></i></a>
                        <a title="Delete donation" style="font-size: 20px;color: #fff;" href="#" onclick="javascript:void(0)">
                            <i class='bx bx-trash-alt'></i>
                        </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
        <?php 
        include 'footer.php';
        ?>
    </body>
</html>