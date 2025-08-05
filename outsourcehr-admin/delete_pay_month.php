<?php
ob_start();
session_start();

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');

$token = $_GET['token'];

$select = "select * from payroll_schedule where token = '$token'";
$result = mysqli_query($db, $select);
$row = mysqli_fetch_array($result);


if (privilege() == 'Super Admin' &&  'Admin') {
    if ($row['status'] == 'pending' || $row['status'] == 'sent for approval') {

        $query = "delete from payroll_schedule where token = '$token'";
        $result = mysqli_query($db, $query);

        $query2 = "delete from employees where pay_token = '$token'";
        $result2 = mysqli_query($db, $query2);

        $query3 = "delete from payroll where pay_token = '$token'";
        $result3 = mysqli_query($db, $query3);

        if ($result) {
            activity_log($_SESSION['Klin_admin_email'], "Deleted payroll record");
            header("Location: emp_salary?del=success");
        }
    } else {
        header('Location: emp_salary?del=error1');
        exit;
    }
} else {
    header('Location: emp_salary?del=error2');
    exit;
}
