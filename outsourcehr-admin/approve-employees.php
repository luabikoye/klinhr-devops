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

if (base64_decode($_GET['email']) != payroll_mail()) {
    header("Location: index");
    exit;
}
$_SESSION['privilege'] = 'Payroll';
$_SESSION['sent'] = base64_decode($_GET['sent']);
$_SESSION['Klin_admin_user'] = payroll_mail();
$_SESSION['payroll_mail'] = payroll_mail();

header("Location: emp_salary");
