<?php

ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
	header("Location: index");
	exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
// require_once('PHPMailer/PHPMailerAutoload.php');
validatePermission('Hr Operations');

//Explose value coming from leave application page to seperate leavetype and leave id

$leave_id = mysqli_real_escape_string($db, $_POST['leave_id']);
$approve = mysqli_real_escape_string($db, $_POST['leave_action']);
$reason = mysqli_real_escape_string($db, $_POST['reason_txt']);

$query = "SELECT * FROM emp_leave_form where id = '$leave_id'";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);

$staff_id = $row['staff_id'];
$names = $row['names'];
$email = $row['email'];
$manager_email = strtolower($row['manager_email']);
$purpose = $row['purpose'];
$leave_type = $row['leave_type'];
$start_date = $row['start_date'];
$end_date = $row['end_date'];
$month = date('F', strtotime($start_date));
$year = date('Y', strtotime($start_date));

if ($leave_type == "Annual Leave") {
	$leave = "annual_leave";
	$leave_month = 'annual_month';
	$leave_year = 'annual_year';
} elseif ($leave_type == "Maternity Leave") {
	$leave = "mat_leave";
	$leave_month = 'mat_month';
	$leave_year = 'mat_year';
} elseif ($leave_type == "Compassionate Leave") {
	$leave = "comp_leave";
	$leave_month = 'comp_month';
	$leave_year = 'comp_year';
}

$access_type = get_access_type($staff_id);

if ($approve == 'Approve') {
	// mail_approval('Approved', $staff_id, $names, $leave_type, $start_date, $end_date, $purpose, $manager_email,$reason,$access_type); 

	update_status('emp_leave_form', $leave_id, 'done');

	activity_log($_SESSION['Klin_admin_user'], "Approved leave for : $names($staff_id) from  " . short_date($start_date) . " - " . short_date($end_date) . " ");

	$msg = 'Leave approval message has been sent';
	$success = 'Leave approval message has been sent';
	include('leave-application.php');
	exit;
}

if ($approve == 'Deny') {
	activity_log($_SESSION['Klin_admin_user'], "Denied leave for : $names($staff_id) from  " . short_date($start_date) . " - " . short_date($end_date) . " ");

	$query = "update  emp_leave_form set status = 'denied' where staff_id='$staff_id' and start_date = '$start_date' and end_date = '$end_date'";
	$result = mysqli_query($db, $query);

	delete_leave_details($staff_id, $start_date, $end_date);
	update_status('emp_leave_form', $leave_id, 'denied');
	$success = 'Leave denial message has been sent';
	include('leave-application.php');
	exit;
}
