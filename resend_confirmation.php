<?php
ob_start();
session_start();
include("outsourcehr-admin/connection/connect.php");
require_once('outsourcehr-admin/inc/fns.php');
require_once('outsourcehr-admin/PHPMailer/PHPMailerAutoload.php');

$email = base64_decode($_GET['cem']);

$sql = "select * from jobseeker_signup where email = '$email'";
$result_1 = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result_1);

$message = 'Please click <b><a href="' . root() . '/confirm-account?auth=' . $row['status'] . '&cem=' . base64_encode($email) . '">ACTIVATE NOW</a></b> to confirm your account. Or copy and paste the URL below to your browser<br><br>' . root() . '/confirm-account?auth=' . $row['status'] . '&cem=' . base64_encode($email);

send_email($email, $row['firstname'], organisation(), 'Account Confirmation', $message);

header('Location: login');
exit;
