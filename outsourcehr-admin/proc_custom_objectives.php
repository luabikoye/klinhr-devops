<?php
ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
	header("Location: index");
	exit;
}
validatePermission('Employee Appraisal');

$kpi_p =  $_POST['kpi_p'];
$kra =  $_POST['kra'];
$kpi_d =  $_POST['kpi_d'];
$question = ($_POST['question']);
$weight =  $_POST['weight'];
$score =  $_POST['score'];

if ($_POST['edit'] == 'yes') {	
	mysqli_query($db, "delete from custom_q where role ='" . $_SESSION['role'] . "' and user = '" . $_SESSION['Klin_admin_user'] . "'");
	activity_log($_SESSION['Klin_admin_user'], "Deleted Custom Objective for " . $_SESSION['role'] . "");
}



for ($i = 0; $i < count($question); $i++) {	
	if ($question[$i]) {
		$query = "insert into custom_q set kpi_p = '" . ($kpi_p[$i]) . "', kra = '" . ($kra[$i]) . "', kpi_d = '" . ($kpi_d[$i]) . "', question = '" . ($question[$i]) . "', weight = '" . ($weight[$i]) . "', score = '" . ($score[$i]) . "', role ='" . ($_SESSION['role']) . "', user = '" . $_SESSION['Klin_admin_user'] . "'";
		$result = mysqli_query($db, $query);
	}
}

mysqli_query($db, "delete from custom_q where question = ''");
activity_log($_SESSION['Klin_admin_user'], "Set Custom Objective for " . $_SESSION['role'] . "");
$success = 'Custom Obectives Added successfully';
include("custom_objective.php");
exit;
