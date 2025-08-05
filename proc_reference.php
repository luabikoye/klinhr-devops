<?php


ob_start();
session_start();
include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
// // include('timeout.php');
// SessionCheck();

$email = $_SESSION['Klin_user'];


$refName = mysqli_real_escape_string($db, $_POST['refName']);
$refEmail = mysqli_real_escape_string($db, $_POST['refEmail']);
$refPhone = mysqli_real_escape_string($db, $_POST['refPhone']);
$refPosition = mysqli_real_escape_string($db, $_POST['refPosition']);
$refCity = mysqli_real_escape_string($db, $_POST['refCity']);
$refState = mysqli_real_escape_string($db, $_POST['refState']);
$refCompany = mysqli_real_escape_string($db, $_POST['refCompany']);
$refAddress = mysqli_real_escape_string($db, $_POST['refAddress']);
$refName2 = mysqli_real_escape_string($db, $_POST['refName2']);
$refEmail2 = mysqli_real_escape_string($db, $_POST['refEmail2']);
$refPhone2 = mysqli_real_escape_string($db, $_POST['refPhone2']);
$refPosition2 = mysqli_real_escape_string($db, $_POST['refPosition2']);
$refCity2 = mysqli_real_escape_string($db, $_POST['refCity2']);
$refState2 = mysqli_real_escape_string($db, $_POST['refState2']);
$refCompany2 = mysqli_real_escape_string($db, $_POST['refCompany2']);
$refAddress2 = mysqli_real_escape_string($db, $_POST['refAddress2']);

// echo
$query = "update jobseeker set refName = '$refName', refEmail = '$refEmail', refPhone = '$refPhone', refPosition = '$refPosition', refCity = '$refCity', refState = '$refState', refCompany = '$refCompany', refAddress = '$refAddress', refName2 = '$refName2', refEmail2 = '$refEmail2', refPhone2 = '$refPhone2', refPosition2 = '$refPosition2', refCity2 = '$refCity2', refState2 = '$refState2', refCompany2 = '$refCompany2', refAddress2 = '$refAddress2' where email = '$email'";
// exit;

$result = mysqli_query($db, $query);

if ($result) {
    if (check_updated($_SESSION['candidate_id']) == 'yes') {
        $query_up = "update jobseeker set completed = 'updated' where candidate_id = '" . $_SESSION['candidate_id'] . "'";
        mysqli_query($db, $query_up);
    }

    $_SESSION['personal'] = $email;
    echo json_encode(['status' => 'success', 'message' => 'Your Job Preference has been saved succesfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error, check if all information were correctly entered.']);
}
