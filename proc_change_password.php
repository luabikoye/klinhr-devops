<?php
ob_start();
session_start();
include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
// include("timeout.php");
// SessionCheck();


$current_password = mysqli_real_escape_string($db, $_POST['current_password']);
$new_pass = mysqli_real_escape_string($db, $_POST['new_pass']);
$confirm_pass = mysqli_real_escape_string($db, $_POST['confirm_pass']);

if ($current_password == '') {
    $error = "Old password is required";
    include('change-password.php');
    exit;
}

if ($new_pass == '') {
    $error = "New password is required";
    include('change-password.php');
    exit;
}

if ($confirm_pass == '') {
    $error = "Confirm password is required";
    include('change-password.php');
    exit;
}

if ($confirm_pass != $new_pass) {
    $error = "Sorry your password do not match";
    include('change-password.php');
    exit;
}

$user = $_SESSION['Klin_user'];

$query = "select * from jobseeker_signup where email = '$user' &&  password = md5('$new_pass')";
$result = mysqli_query($db, $query);
$same_pass = mysqli_fetch_array($result);
if ($same_pass['password'] == md5($new_pass)) {
    $error = "Sorry your new password is the same as your old password, kindly change it.";
    include('change-password.php');
    exit;
}


if (strlen($new_pass) < 6) {
    $error = "Password should be at least 6 characters";
    include('change-password.php');
    exit;
}

// $uppercase = preg_match('@[A-Z]@', $new_pass);
// $lowercase = preg_match('@[a-z]@', $new_pass);
// $number = preg_match('@[0-9]@', $new_pass);

// if(!$uppercase)
// {
//     $error = "Please include an uppercase letter in your password";
//     include('change-password.php');
//     exit;
// }

// if(!$lowercase)
// {
//     $error = "Please include a lowercase letter in your password";
//     include('change-password.php');
//     exit;
// }

// if(!$number)
// {
//     $error = "Please include a number in your password";
//     include('change-password.php');
//     exit;
// }


$sql = "select * from jobseeker_signup where email = '$user' && password = md5('$current_password')";
$result_1 = mysqli_query($db, $sql);
$num = mysqli_num_rows($result_1);
if ($num > 0) {
    $sql_1 = "update jobseeker_signup set password = md5('$new_pass') where email = '$user'";
    $result_2 = mysqli_query($db, $sql_1);
    $success = "Password successfully changed";


    activity_log($_SESSION['Klin_user'], 'Chgtianged password');
    $confirm_pass = $new_pass = $current_password = '';
    include('change-password.php');
    exit;
} else {
    $error = "Sorry, your old password is incorrect";
    include('change-password.php');
    exit;
}
