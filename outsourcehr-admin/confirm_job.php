<?php

ob_start();
session_start();


include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');


$job_title = base64_decode($_GET['cem']);
$job_post_id = base64_decode($_GET['jid']);
$auth = base64_decode($_GET['auth']);

$query = "update job_post set status = 'approved' where id = '$job_post_id' && job_title = '$job_title'";
$result = mysqli_query($db, $query);

activity_log($_SESSION['Klin_admin_user'], "Admin approved this job post ( $job_title )");


$success = "This job has been successfully approved";
header("Location: job-posted.php?valid=" . today());
exit;