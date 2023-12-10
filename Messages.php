<?php
session_start();
include "check-session.php";
include "function.php";
require "db-connect.php";

?> 
<html>
    <head>
        <title>Messages | E - Donate Mo</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <style type="text/css">
            .messages-wrapper {
                border: 1px solid #000;
                height: 70%;
                background-color: #ddd;
                overflow-y: scroll;
            }
            #input-message {
                width: 90%;
                height: 50px;
                padding: 10px;
                font-size: 16px;
            }
            #input-message-submit {
                padding: 15px;
                width: 9%;
                font-weight: bold;
            }
            .message-box {
                width: 70%;
                padding: 10px;
                margin: 10px;
            }
            .message-receive {
                background-color: #848383;

            }
            .message-sent {
                background-color: #5574f0;
                margin-left: auto; 
                margin-right: 10px;
            }
        </style>
    </head>

    <body>
        <?php 
        include 'header.php';
        ?>
        <div class="wrapper">
            <div class="messages-wrapper">
                <div class="message-box message-receive">
                    aw
                </div>
                <div class="message-box message-sent">
                    aw
                </div>
                <div class="message-box message-receive">
                    aw
                </div>
                <div class="message-box message-sent">
                    aw
                </div>
                <div class="message-box message-receive">
                    aw
                </div>
                <div class="message-box message-sent">
                    aw
                </div>
                <div class="message-box message-receive">
                    aw
                </div>
                <div class="message-box message-sent">
                    aw
                </div>
                <div class="message-box message-receive">
                    aw
                </div>
                <div class="message-box message-sent">
                    aw
                </div>
                <div class="message-box message-receive">
                    aw
                </div>
                <div class="message-box message-sent">
                    aw
                </div>
            </div>
            <div class="input-messages-wrapper">
                <form id="input-message-form" method="post">
                    <input type="text" name="message" id="input-message">
                    <button id="input-message-submit" type="submit">Submit</button>
                </form>
            </div>
        </div>
        <?php 
        include 'footer.php';
        ?>
    </body>
</html>