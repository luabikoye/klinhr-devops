<?php


ob_start();
session_start();
include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
// include('timeout.php');
// SessionCheck();

$email = $_SESSION['Klin_user'];


// $sec_school = mysqli_real_escape_string($db, $_POST['sec_school']);
// $sec_year = mysqli_real_escape_string($db, $_POST['sec_year']);
$first_qualification = mysqli_real_escape_string($db, $_POST['first_qualification']);
$first_institution = mysqli_real_escape_string($db, $_POST['first_institution']);
$first_degree = mysqli_real_escape_string($db, $_POST['first_degree']);
$first_course = mysqli_real_escape_string($db, $_POST['first_course']);
$first_professional = mysqli_real_escape_string($db, $_POST['first_professional']);
$qualification_2 = mysqli_real_escape_string($db, $_POST['qualification_2']);
$institution2 = mysqli_real_escape_string($db, $_POST['institution2']);
$degree2 = mysqli_real_escape_string($db, $_POST['degree2']);
$course2 = mysqli_real_escape_string($db, $_POST['course2']);
$professional2 = mysqli_real_escape_string($db, $_POST['professional2']);
$qualification_3 = mysqli_real_escape_string($db, $_POST['qualification_3']);
$institution3 = mysqli_real_escape_string($db, $_POST['institution3']);
$degree3 = mysqli_real_escape_string($db, $_POST['degree3']);
$course3 = mysqli_real_escape_string($db, $_POST['course3']);
$professional3 = mysqli_real_escape_string($db, $_POST['professional3']);
$professional3_year = mysqli_real_escape_string($db, $_POST['professional3_year']);
$first_professional_year = mysqli_real_escape_string($db, $_POST['first_professional_year']);
$professional2_year = mysqli_real_escape_string($db, $_POST['professional2_year']);
$q1_year = mysqli_real_escape_string($db, $_POST['q1_year']);
$q2_year = mysqli_real_escape_string($db, $_POST['q2_year']);
$q3_year = mysqli_real_escape_string($db, $_POST['q3_year']);


if ($first_qualification == '') {
    echo json_encode(['status' => 'error', 'message' => 'Qualification is required.']);
} elseif ($first_institution == '') {
    echo json_encode(['status' => 'error', 'message' => 'Institution is required.']);
} elseif ($first_degree == '') {
    echo json_encode(['status' => 'error', 'message' => 'Class of degree is required.']);
} elseif ($first_course == '') {
    echo json_encode(['status' => 'error', 'message' => 'Course of study is required.']);
}



// echo
$query = "update jobseeker set sec_school = '$sec_school', sec_year = '$sec_year', first_qualification = '$first_qualification', first_institution = '$first_institution', first_degree = '$first_degree', first_course = '$first_course', profCert = '$first_professional', qualification_2 = '$qualification_2', institution2 = '$institution2', degree2 = '$degree2', course2 = '$course2', profCert2 = '$professional2', qualification_3 = '$qualification_3', institution3 = '$institution3', degree3 = '$degree3', course3 = '$course3', profCert3 = '$professional3', professional3_year = '$professional3_year', first_professional_year = '$first_professional_year', professional2_year = '$professional2_year', q1_year = '$q1_year', q2_year = '$q2_year', q3_year = '$q3_year', status = 'personal'  where email = '$email'";
// exit;

$result = mysqli_query($db, $query);

if ($result) {

    $_SESSION['personal'] = $email;

    echo json_encode(['status' => 'success', 'message' => 'Your career information has been saved succesfully.']);    
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error, check if all information were correctly entered.']);        
}
