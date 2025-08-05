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

if ($_POST['sms_approval']) {
    $sms_approval = mysqli_real_escape_string($db, $_POST['sms_approval']);
} else {
    $sms_approval = 'no';
}
$api = mysqli_real_escape_string($db, $_POST['api']);



if ($api == '') {
    $error = "Sms Api is required";
    include('settings.php');
    exit;
}



$query = "UPDATE sms SET sms_approval = '$name', sms_api = '$api' WHERE id = 1";
$result = mysqli_query($db, $query);
if ($result) {

    activity_log($_SESSION['Klin_admin_email'], "Updated SMS details");

    $success = "SMS Details Updated";
    include('settings.php');
    exit;
} else {
    $error = "Database error";
    include('settings.php');
    exit;
}
