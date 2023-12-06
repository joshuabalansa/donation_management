<?php

include "../function.php";
require "../db-connect.php";

if (isset($_POST['email'])) {

    $email = $connect->real_escape_string($_POST['email']);
    $password = $connect->real_escape_string($_POST['password']);

    $error = [];

    /*if (empty($email)) {
        $error['email'] = 'Email is required!';
    }

    if (empty($password)) {
        $error['password'] = 'Password is required!';
    }*/

    $auth = authUser($connect, $email, $password);
    
    if (!is_null($auth)) {
        $auth['token'] = authUserToken($connect, $auth['id']);
    	returnJson([
    		'user' => $auth
    	]);
    }

    returnJson([
    	'errors' => [
    		'email' => 'Invalid Email and Password!'
    	]
    ]);
}
returnJson([]);
?>