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

$token = $_GET['token'];
$update = "update payroll_schedule set status = 'sent for approval' where token = '$token'";
$result = mysqli_query($db, $update);
if ($result) {
    $sql = "update employees set status = 'sent for approval' where pay_token = '$token'";
    $sql_result = mysqli_query($db, $sql);
    include('send-employee.php');
    $message = 'Please approve this computed payroll. The list of all staff is in the file below. After Reviewing Click the link to accept approval <a href="' . root() . '/approve-employees?email=' . base64_encode(payroll_mail()) . '&sent=' . base64_encode($_SESSION['Klin_admin_user']) . '&token=' . $token . '">Approve payroll</a>';
    send_email(payroll_mail(), 'Payroll Manager', organisation(), 'Approve Payroll', $message, "data_$pay_month.csv");
    header("Location: emp_month?token=$token&approve=success");
} else {
    header("Location: emp_month?token=$token&approve=error");
}
