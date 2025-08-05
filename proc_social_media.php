<?php


ob_start();
session_start();
include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
// include('timeout.php');
// SessionCheck();

$email = $_SESSION['Klin_user'];


$facebook = mysqli_real_escape_string($db, $_POST['facebook']);
$twitter = mysqli_real_escape_string($db, $_POST['twitter']);
$linkedin = mysqli_real_escape_string($db, $_POST['linkedin']);
$instagram = mysqli_real_escape_string($db, $_POST['instagram']);

// echo
$query = "update jobseeker set facebook = '$facebook', twitter = '$twitter', linkedin = '$linkedin', instagram = '$instagram'  where email = '$email'";
// exit;

$result = mysqli_query($db, $query);

if ($result) {
    if (check_updated($_SESSION['candidate_id']) == 'yes') {
    }
    $query_up = "update jobseeker set completed = 'updated' where candidate_id = '" . $_SESSION['candidate_id'] . "'";
    mysqli_query($db, $query_up);


    $_SESSION['personal'] = $email;
    $candidate_id = $_SESSION['candidate_id'];


    $_SESSION['personal'] = $email;
    echo json_encode(['status' => 'success', 'message' => 'Your Job Preference has been saved succesfully.', 'query' => "select * from jobseeker where firstname != '' and lastname != '' and email != '' and phone != '' and gender != '' and dob != '' and state != '' and local_govt != '' and address != '' and first_qualification != '' and first_institution != '' and first_degree != '' and first_course != '' and cv != '' and candidate_id = '$candidate_id'"]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error, check if all information were correctly entered.']);
}
