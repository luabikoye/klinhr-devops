<?php

ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
	header("Location: index");
	exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('Appraisal');
$role = mysqli_real_escape_string($db, $_POST['role']);
$account_token = $_SESSION['account_token'] ? 'account_token = "' . $_SESSION['account_token'] . '"' : 'account_token IS NULL ';

if ($role == '') {
	$error = 'Kindly enter a job role';
	include('role.php');
	exit;
}

$sql = "select * from role where role = '" . $_POST['role'] . "' and $account_token ";
$sql_result = mysqli_query($db, $sql);
$row = mysqli_fetch_array($sql_result);
$num = mysqli_num_rows($sql_result);
if ($num > 0) {
	$error = "Sorry, this role already exist, try adding another role";
	include('role.php');
	exit;
}

//delete all custom kpi if role exists there
mysqli_query($db, "delete from custom_q where role = '$role' and $account_token ");

$query = "insert into role set role = '" . $role . "', user='" . $_SESSION['Klin_admin_user'] . "', account_token = '".$_SESSION['account_token']."'";
$result = mysqli_query($db, $query);
if ($result) {
	mysqli_query($db, "insert into emp_position set position_code = '$role', position_name = '$role', user='" . $_SESSION['Klin_admin_user'] . "' , $account_token ");
	// mysqli_query($db,"delete from emp_position where role = ''");
	// mysqli_query($db,"delete from role where role = ''");
	activity_log($_SESSION['Klin_admin_user'], "Added a new role with title: $role ");
	$success = 'Role has been added successfully';
	include('role.php');
	exit;
} else {

	$error = 'Kindly enter a job role';
	include('role.php');
	exit;
}
