<?php

ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
	header("Location: index");
	exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('Employee Appraisal');
$locationCode = mysqli_real_escape_string($db, $_POST['locationCode']);
$locationName = mysqli_real_escape_string($db, $_POST['locationName']);

if ($locationName == '' || $locationCode == '') {
	$error = 'Kindly enter a location';
	include('location.php');
	exit;
}

$sql = "select * from locations where locationName = '$locationName'";
$sql_result = mysqli_query($db, $sql);
$row = mysqli_fetch_array($sql_result);
$num = mysqli_num_rows($sql_result);
if ($num > 0) {
	$error = "Sorry, this location already exist, try adding another location";
	include('location.php');
	exit;
}

//delete all custom kpi if location exists there
// mysqli_query($db,"delete from custom_q where location = '$location'");

$query = "insert into locations set locationName = '$locationName', locationCode= '$locationCode'";
$result = mysqli_query($db, $query);
if ($result) {
	// mysqli_query($db,"insert into emp_position set position_code = $location, position_name = $location, user='".$_SESSION['Klin_admin_user']."'");

	activity_log($_SESSION['Klin_admin_user'], "Added a new location with title: $locationName ");
	$success = 'location has been added successfully';
	include('location.php');
	exit;
} else {

	$error = 'Kindly enter a job location';
	include('location.php');
	exit;
}
