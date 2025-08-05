<?php
ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');

$email = mysqli_real_escape_string($db, $_POST['email']);
$subject = mysqli_real_escape_string($db, $_POST['subject']);
$message = mysqli_real_escape_string($db, $_POST['message']);

echo $email;
exit;
