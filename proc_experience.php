<?php


ob_start();
session_start();
include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
// include('timeout.php');
// SessionCheck();

$email = $_SESSION['Klin_user'];


$industry = mysqli_real_escape_string($db, $_POST['industry']);
$experience_1 = mysqli_real_escape_string($db, $_POST['experience_1']);
$achievement = trim(mysqli_real_escape_string($db, $_POST['achievement']));

// echo
$query = "update jobseeker set industry = '$industry', experience_1 = '$experience_1', achievement = '$achievement', status = 'personal'  where email = '$email'";
// exit;

$result = mysqli_query($db, $query);

if ($result) {

    $_SESSION['personal'] = $email;
    echo json_encode(['status' => 'success', 'message' => 'Your work experience has been saved succesfully.']);    
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error, check if all information were correctly entered.']);   
}
