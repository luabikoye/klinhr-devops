<?php


ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');
validatePermission('Vacancies');
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}


$username = mysqli_real_escape_string($db, $_POST['username']);
$password = mysqli_real_escape_string($db, $_POST['password']);
$host = mysqli_real_escape_string($db, $_POST['host']);
$secure = mysqli_real_escape_string($db, $_POST['secure']);
$sender = mysqli_real_escape_string($db, $_POST['sender']);
$admin = mysqli_real_escape_string($db, $_POST['admin']);
$reply = mysqli_real_escape_string($db, $_POST['reply']);
$port = mysqli_real_escape_string($db, $_POST['port']);
$hr = mysqli_real_escape_string($db, $_POST['hr']);
$hr_email = mysqli_real_escape_string($db, $_POST['hr_email']);
if ($username == '') {
    $error = "Username is required";
    include('settings.php');
    exit;
}

if ($password == '') {
    $error = "password is required";
    include('settings.php');
    exit;
}

if ($host == '') {
    $error = "Host is required";
    include('settings.php');
    exit;
}
// echo 'NO';
// exit;

if ($secure == '') {
    $error = "Secure is required";
    include('settings.php');
    exit;
}

if ($sender == '') {
    $error = "Sender Email is required";
    include('settings.php');
    exit;
}

if ($admin == 'Select Qualification') {
    $error = "Admin Email is required";
    include('settings.php');
    exit;
}

if ($reply == '') {
    $error = "No Reply Email is required";
    include('settings.php');
    exit;
}

if ($port == '') {
    $error = "Port is required";
    include('settings.php');
    exit;
}



$query = "UPDATE smtp SET username = '$username', password = '$password', host = '$host', secure = '$secure', sender = '$sender', admin = '$admin', reply = '$reply', port = '$port', hr = '$hr', hr_email = '$hr_email' WHERE id = 1";
$result = mysqli_query($db, $query);
if ($result) {

    activity_log($_SESSION['Klin_admin_email'], "Updated SMTP details");

    $success = "Smtp Details Updated";
    include('settings.php');
    exit;
} else {
    $error = "Database error";
    include('settings.php');
    exit;
}
