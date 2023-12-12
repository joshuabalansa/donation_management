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
        <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
        <style type="text/css">
            .bold {
                font-weight: bold;
            }
            #recipient-search {
                margin-top: 10px;
                margin-left: 5px;
                width: 96%;
                height: 30px;
                padding: 10px;
                font-size: 12px;
                border: 1px solid #ddd;
                border-radius: 20px;
            }
            #recipient-submit {
                padding: 5px;
                width: 19%;
                font-weight: bold;
                display: none;
            }
            .recipient-list {
                display: flex;
                justify-content: center;
                flex-direction: column;
            }
            .recipient-list li {
                padding: 10px;
                list-style: none;
                /* border-bottom: 1px solid #848383; */
            }
            .recipient-list li a {
                font-size: 16px;
                display: block;
            }
            .messages-wrapper-recipients {
                overflow-y: scroll;
                height: 70%;
                background-color: #fff;
                width: 20%;
                float: left;
            }
            .messages-wrapper {
                float: left;
                /* border: 1px solid #000; */
                height: 70%;
                width: 80%;
                background-color: #fff;
                overflow-y: scroll;
                float: right;
            }
            #input-message {
                width: 100%;
                height: 50px;
                padding: 10px;
                font-size: 16px;
                border: none;
                border-top: 1px solid #ccc;
            }
            #input-message-submit {
                padding: 10px;
                width: 9%;
                height: 50px;
                font-weight: bold;
                border: none;
                cursor: pointer;
            } 
            #input-message-submit:hover {
                background: #ddd;
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
            .form-button-wrapper {
                display: flex;
                justify-content: end;
                align-items: center;
                width: 100%;
            }
            
        </style>
    </head>

    <body>
        <?php 
        include 'header.php';
        ?>
        <div class="wrapper">
            <div class="messages-wrapper-recipients">
                <form id="recipient-search-form" method="post" action="#">
                    <input placeholder="Search users..." type="text" name="search" id="recipient-search">
                    <button id="recipient-submit" type="submit">Find</button>
                </form>
                <ul class="recipient-list">
                </ul>
            </div>
            <div class="messages-wrapper">
            </div>
            <div class="input-messages-wrapper">
                <form id="input-message-form" method="post" action="api/message-sent.php">
                    <input type="hidden" name="user_id" id="input-user-id" value="<?php echo $_SESSION['user']['id']; ?>">
                    <input type="hidden" name="receiver_user_id" id="input-receiver-user-id" value="9">
                    <div class="form-button-wrapper">
                        <input type="text" name="message" placeholder="Message" id="input-message" required>
                        <button id="input-message-submit" type="submit">Send
                            <span><i class='bx bx-send'></i></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php 
        include 'footer.php';
        ?>
        <script>

            showRecipients();
            setInterval(function() {
                showRecipients('');
            }, 5000);
            //showConvo();

            var xhr_send_message = null;
            $(function(){
                $('#input-message-form').submit(function(e){
                    xhr_send_message = $.ajax({
                        type : $(this).attr('method'),
                        url : $(this).attr('action'),
                        data : $(this).serialize(),
                        cache : false,
                        dataType : "json",
                        beforeSend: function(xhr) {
                            if (xhr_send_message != null) {
                                xhr_send_message.abort();
                            }
                        }
                    }).done(function(result) {
                        $('#input-message').val('');
                        showConvo($('#input-receiver-user-id').val());
                    }).fail(function(jqXHR, textStatus) {
                        if (jqXHR.status == 422) {
                            alert(error_messages(jqXHR.responseJSON.errors));
                        }
                    });
                    e.preventDefault();
                });
            });

            var xhr_showConvo = null;
            function showConvo(receiver_user_id)
            {
                var user_id = <?php echo $_SESSION['user']['id']; ?>;
                $('#input-receiver-user-id').val(receiver_user_id);

                xhr_showConvo = $.ajax({
                    type : 'get',
                    url : 'api/messages.php',
                    data : 'user_id=' + user_id + '&receiver_user_id=' + receiver_user_id,
                    cache : false,
                    dataType : "json",
                    beforeSend: function(xhr) {
                        if (xhr_showConvo != null) {
                            xhr_showConvo.abort();
                        }
                    }
                }).done(function(result) {

                    var messageWrapper = '';
                    var last_message_id = '';
                    $.each(result.messages, function(key, value){
                        last_message_id = 'message-id-' + value.id;
                        messageBoxStyle = 'message-receive';

                        if (result.my_id == value.sender_id) {
                            messageBoxStyle = 'message-sent';
                        }

                        messageWrapper += '<div style="border-radius: 10px; width: 40%;" id="' + last_message_id + '" class="message-box ' + messageBoxStyle + '">';
                        messageWrapper += '' + value.message;
                        messageWrapper += '</div>';

                    });
                    
                    $('.messages-wrapper').html(messageWrapper);
                    //$('#' + last_message_id).focus();
                    //$('.messages-wrapper').find('div#' + last_message_id);
                    //$('.messages-wrapper').scrollTop($('#' + last_message_id), 0);

                }).fail(function(jqXHR, textStatus) {
                    if (jqXHR.status == 422) {
                        alert(jqXHR.responseJSON.errors);
                    }
                });
            }


            var xhr_send_message = null;
            $(function(){
                $('#recipient-search-form').submit(function(e){
                    showRecipients($('#recipient-search').val());
                    e.preventDefault();
                });
            });

            var xhr_showRecipients = null;
            function showRecipients(search='')
            {
                var user_id = <?php echo $_SESSION['user']['id']; ?>;


                xhr_showRecipients = $.ajax({
                    type : 'get',
                    url : 'api/message-recipients.php',
                    data : 'user_id=' + user_id + '&search=' + search,
                    cache : false,
                    dataType : "json",
                    beforeSend: function(xhr) {
                        if (xhr_showRecipients != null) {
                            xhr_showRecipients.abort();
                        }
                    }
                }).done(function(result) {

                    var recipientWrapper = '';
                    var last_message_id = '';
                    $.each(result, function(key, value){
                        last_message_id = 'message-id-' + value.id;
                        itemBold = '';

                        if (value.seen_at >= 1) {
                            itemBold = 'bold';
                        }

                        recipientWrapper += '<li class="' + itemBold + '"><a href="javascript:void(0)" onclick="showConvo(' + value.receiver_id + ')">';
                        recipientWrapper += '' + value.receiver_name;
                        recipientWrapper += '</a></li>';

                    });
                    
                    $('.recipient-list').html(recipientWrapper);

                }).fail(function(jqXHR, textStatus) {
                    if (jqXHR.status == 422) {
                        alert(jqXHR.responseJSON.errors);
                    }
                });
            }
        </script>
    </body>
</html>