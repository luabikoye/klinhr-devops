<?php


ob_start();
session_start();

include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
// include('timeout.php');
// SessionCheck();

$id = base64_decode($_GET['id']);
$status = base64_decode($_GET['status']);

if ($status == 'Applied') {
    $delete_query_1 = "delete from jobs_applied where id = '$id'  ";
    $delete_result_2 = mysqli_query($db, $delete_query_1);
    header("Location: applied-job?del=success");
    exit;
} else {
    header("Location: applied-job?del=failed");
    exit;
}
