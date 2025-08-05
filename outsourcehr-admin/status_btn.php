<?php

ob_start();
session_start();

ob_start();

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');



$id = base64_decode($_GET['id']);
$tab = base64_decode($_GET['tab']);
$staff_email = base64_decode($_GET['e']);
$staff_name = base64_decode($_GET['n']);
$subject = "Resolved: ".base64_decode($_GET['sub']);

$return_url = base64_decode($_GET['return_url']);

$status = base64_decode($_GET['status']);


if ($return_url == 'grievances?msg=success' || $return_url == 'grievances?msg=revert') {
    $check = 'Grievances';
    $select = 'emp_complaint';
} else {
    $check = 'Introduction Letter Request';
    $select = 'emp_reference';
}

if($status == 'done')
{
    $message = 'Your complain/grievence with the subject has been resolved. If you are not satisfied with the resolution, you can logon to the employee service portal and send us a message again.<br><br><a href="'.host().'/staffportal/">'.host().'/staffportal/</a><br><br>Login with your staff ID and password<br><br>'.get_fullname($_SESSION['Klin_admin_user']);

    send_email($staff_email,$staff_name,organisation(),$subject,$message);
}

mysqli_query($db, "update $tab set status = '$status' where id = '$id'");

$qs = mysqli_query($db, "select * from $tab where id = '$id'");
$rs = mysqli_fetch_assoc($qs);

activity_log($_SESSION['Klin_admin_user'], 'Updated  ' . get_val($select, 'id', $id, 'name') . ' ' . ' ' . $check . ' status to ' . $status . ' ');
header("Location: $return_url");