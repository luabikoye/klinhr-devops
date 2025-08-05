<?php


ob_start();
session_start();
include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
// // include('timeout.php');
// SessionCheck();

$email = $_SESSION['Klin_user'];


$prefState = mysqli_real_escape_string($db, $_POST['prefState']);
$prefJob = mysqli_real_escape_string($db, $_POST['prefJob']);
$availDate = mysqli_real_escape_string($db, $_POST['availDate']);
$prefCat = mysqli_real_escape_string($db, $_POST['prefCat']);
$salary = mysqli_real_escape_string($db, $_POST['salary']);

// echo
$query = "update jobseeker set prefState = '$prefState', prefJob = '$prefJob', availDate = '$availDate', prefCat = '$prefCat', salary = '$salary', status = 'personal'  where email = '$email'";
// exit;

$result = mysqli_query($db, $query);

if ($result) {

    $_SESSION['personal'] = $email;
    echo json_encode(['status' => 'success', 'message' => 'Your Job Preference has been saved succesfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error, check if all information were correctly entered.']);
}
