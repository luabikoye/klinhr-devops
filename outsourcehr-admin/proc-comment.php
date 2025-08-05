<?php

ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');

$comment = $_POST['comment'] . ' ~ ' . get_fullname($_SESSION['kennedia_admin_user']);
$job_id = $_POST['job_id'];
$candidate_id = $_POST['candidate_id'];
$cat = $_POST['cat'];


$query = "update application_history set comment = '$comment' where job_id = '" . $job_id . "' and  candidate_id = '$candidate_id'";

$result = mysqli_query($db, $query);
if ($result) {

    header("Location: applicants?cat=$cat&success=Comment has been noted");
    exit;
} else {
    $error = "Something went wrong trying to update cover letter";
    include('applicants.php');
    exit;
}
