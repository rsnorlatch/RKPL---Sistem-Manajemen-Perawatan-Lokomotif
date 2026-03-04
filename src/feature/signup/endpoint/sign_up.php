<?php

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$user_type = $_POST['user_type'];

switch ($user_type) {
    case 'driver':
        header("Location: driver_signup.php?username=$username&email=$email&password=$password");
        break;
    case 'maintainer':
        header("Location: maintainer_signup.php?username=$username&email=$email&password=$password");
        break;
    case 'central_office':
        header("Location: central_office_signup.php?username=$username&email=$email&password=$password");
        break;
    default:
        echo "Invalid user type";
}