<?php

include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
require('PHPMailer/PHPMailerAutoload.php');

$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

if ($email == '') {
    $error = "Email is required";
    include('forgot.php');
    exit;
}

$email = filter_var($_POST['email']);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format";
    include('forgot.php');
    exit;
}
$query = "select * from jobseeker_signup where email = '$email'";
$result = mysqli_query($db, $query);
$num = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);

if ($num > 0) {

    $num_gen = rand(199999, 999999);
    $new_password = md5($num_gen);
    // echo '<br>';
    //update accoutn with new password
    // echo
    $query_p = "update jobseeker_signup set password = md5('$num_gen') where email = '$email'";
    // exit;
    $result_p = mysqli_query($db, $query_p);

    $message = 'Below is your new password<br><br><strong>' . $num_gen . '</strong><br>
    ';
    send_email($email, $row['firstname'], organisation(), 'Password Reset', $message);

    $success = "Check your email for your new password.";

    include('forgot.php');
    exit;
} else {
    $error = "We could not find any account with the email";
    include('forgot.php');
    exit;
}