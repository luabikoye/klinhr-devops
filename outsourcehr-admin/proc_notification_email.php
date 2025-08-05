<?php

    include('connection/connect.php');
    require_once('inc/fns.php');
    require_once('PHPMailer/PHPMailerAutoload.php');
$account_token = $_SESSION['account_token'] ? 'account_token = "' . $_SESSION['account_token'] . '"' : 'account_token IS NULL ';
if (!$account_token) {
    validatePermission('General Setting');
}


    $privilege = mysqli_real_escape_string($db,$_POST['privilege']);
    $email = mysqli_real_escape_string($db,$_POST['email']);

    if($privilege == '')
    {
        $error = 'Privilege is required';
        include('notification-mail.php');
        exit;
    }

    if($email == '')
    {
        $error = "Email is required";
        include('notification-mail.php');
        exit;
    }

    $query = "insert into notification_email set email = '$email', privilege = '$privilege', $account_token";
    $result = mysqli_query($db, $query);

    if($result)
    {
        $success = "Email successfully added";
        include('notification-mail.php');
        exit;
    }
    else{
        $error = "Email not added";
        include('notification-mail.php');
        exit;
    }



?>