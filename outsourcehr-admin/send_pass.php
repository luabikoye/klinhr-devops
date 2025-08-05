<?php

ob_start();
session_start();
include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');

validatePermission('General Setting');
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

if ($_GET['unique']) {
    $id = base64_decode($_GET['unique']);
}

$newpassword = $id . "OUT" . rand(1000, 10000);
$pass = password_hash($newpassword, PASSWORD_BCRYPT);
$query_update = "UPDATE login SET password='$pass' where id='$id'";
$result_update = mysqli_query($db, $query_update);

if ($result_update) {
    $query = "select * from login where id = '$id'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_array($result);
    $pass = $row['password'];

    $to = $row['email'];
    $name = $row['firstname'] . " " . $row['lastname'];
    $fromName = "no-reply@Klinhr.com.ng";

    $subject = "User Reset Password";
    $message = "Your password was successfully updated. Do find attached to this mail, your current password. For security reasons, kindly change your password on your next login to the portal. <br><br>

    New Password:" . $newpassword . " <br><br>";

    send_email($to, $name, $fromName, $subject, $message);


    // header("location: user");
    header('Location:user?sent=1');
} else {
    header('Location:user?not=1');
}
