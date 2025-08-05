<?php
ob_start();
session_start();
include("connection/connect.php");
require_once('inc/fns.php');

$checkID = $_POST['checkID'];
// $job_id = list_val('jobs_applied', 'id', 'firstname');

$sql = "select * from jobseeker where id = '" . $checkID[$i] . "'";
$result_1 = mysqli_query($db, $sql);

for ($i = 0; $i < count($checkID); $i++) {
    $query = "select * from jobs_applied where id = '" . $checkID[$i] . "'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_array($result);
    $email[] = $row['email'];
    $mobile_number[] = $row['phone'];
    $name[] = $row['firstname'];
    $id[] = $row['id'];
}

//implode all extracted email & phone numbers	
$emails = implode(',', $email);
$mobile_numbers = implode(',', $mobile_number);
$names = implode(',', $name);
$id = implode(',', $id);

//create a session with the emails & phone numbers
echo json_encode(array($emails, $mobile_numbers, $id, $names));
