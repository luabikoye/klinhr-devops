<?php

ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');
$month_year = date('F-Y');
$select = "Select * from payroll_schedule where pay_month_year = '$month_year'";
$results = mysqli_query($db, $select);
$row = mysqli_fetch_array($results);

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

$paytoken = $_GET['token'];
$update = "update employees set status = 'approved' where pay_token = '$paytoken'";
$result = $db->query($update);
$pay_update = "update payroll_schedule set status = 'approved' where token = '$paytoken'";
$pay_result = $db->query($pay_update);

if ($pay_result) {
    $message = 'The Payroll for this month has been approved. Please login to confirm';
    send_email($_SESSION['sent'], 'Payroll Manager', organisation(), 'Approval Confirmed', $message);
    header("Location: emp_salary?approve=yes");
} else {
    header("Location: emp_salary?approve=no");
}
