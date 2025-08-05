<?php

ob_start();
session_start();
include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

$old_password = mysqli_real_escape_string($db, $_POST['old_password']);
$new_password = mysqli_real_escape_string($db, $_POST['new_password']);
$confirm_password = mysqli_real_escape_string($db, $_POST['confirm_password']);

// if ($old_password == '') {
//     $error = "Current password is required";
//     include('change_password.php');
//     exit;
// }

if ($new_password == '') {
    $error = "New password is required";
    include('change_password.php');
    exit;
}

if ($confirm_password == '') {
    $error = "Confirm password is required";
    include('change_password.php');
    exit;
}

if ($confirm_password != $new_password) {
    $error = "Sorry your password do not match";
    include('change_password.php');
    exit;
}
$user = $_SESSION['Klin_admin_user'];


$sql = "select * from login where username = '$user'";
$res = mysqli_query($db, $sql);
$row = mysqli_fetch_array($res);
$storedPasswordHash = $row['password'];
if (password_verify($new_password, $storedPasswordHash)) {
    $error = "Sorry your new password is the same as your old password, kindly change it";
    include('change_password.php');
    exit;
}
$new_passwords = $new_password;
if (password_verify($old_password, $storedPasswordHash)) {
    $new_password = password_hash($new_password, PASSWORD_BCRYPT);
    activity_log($_SESSION['Klin_admin_user'], "Changed Password");

    $sql_1 = "UPDATE login SET password = '$new_password' WHERE email = '$user'";
    $result_2 = mysqli_query($db, $sql_1);
    if ($result_2) {
        $success = "Password successfully changed";
        $to = $row['email'];
        $name = $row['firstname'] . " " . $row['lastname'];
        $fromName = "no-reply@Talgen.com.ng";

        $subject = "User Reset Password";
        $message = "Your password was successfully updated. Do find attached to this mail, your current password. For security reasons, kindly change your password on your next login to the portal. <br><br>

    New Password:" . $new_passwords . " <br><br>";

        send_email($to, $name, $fromName, $subject, $message);
        include('change_password.php');
        exit;
    } else {
        $error = "Password not updated";
        include('change-password.php');
        exit;
    }
} else {
    $error = "Sorry, your old password is incorrect";
    include('change_password.php');
    exit;
}
