<?php


ob_start();
session_start();

include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
// include('timeout.php');
// SessionCheck();

$id = base64_decode($_GET['id']);

$delete_query_1 = "DELETE FROM favourite WHERE id = '$id'";
$delete_result_2 = mysqli_query($db, $delete_query_1);
header("Location: saved-jobs?del=success");
exit;
