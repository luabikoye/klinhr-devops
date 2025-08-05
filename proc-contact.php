<?php

ob_start();
session_start();
include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');

require('PHPMailer/PHPMailerAutoload.php');

$name = mysqli_real_escape_string($db, $_POST['name']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$phone = mysqli_real_escape_string($db, $_POST['phone']);
$message = mysqli_real_escape_string($db, $_POST['message']);

if (!$name || !$email || !$phone || !$message) {
  $error = 'All Information are important!';
  include 'contact.php';
  exit;
} else {
  $to = "Info@jobroleng.com";
  $subject = "Contact Form Submission";
  $email_message = "Name: $name<br>Email: $email<br>Phone: $phone<br>Message: $message";

  // Send the email

  send_email($to, 'Admin', organisation(), $subject, $email_message);

  $success = 'Your form has been received successfully!';
  include 'contact.php';
}
