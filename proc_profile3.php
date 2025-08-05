<?php

ob_start();
session_start();
include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
// include('timeout.php');
// SessionCheck();

$firstname = mysqli_real_escape_string($db, $_POST['firstname']);
$lastname = mysqli_real_escape_string($db, $_POST['lastname']);
$middlename = mysqli_real_escape_string($db, $_POST['middlename']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$phone = mysqli_real_escape_string($db, $_POST['phone']);
$gender = mysqli_real_escape_string($db, $_POST['gender']);
$dob = mysqli_real_escape_string($db, $_POST['dob']);
$bustop = mysqli_real_escape_string($db, $_POST['bus']);
$state = mysqli_real_escape_string($db, $_POST['state']);
$local_govt = mysqli_real_escape_string($db, $_POST['local_govt']);
$address = mysqli_real_escape_string($db, $_POST['address']);
// $valid_user = mysqli_real_escape_string($db, $_POST['ics_user']);
// $filepath = mysqli_real_escape_string($db, $_POST['passport']);
// $bvn = mysqli_real_escape_string($db, $_POST['bvn']);


// if (strlen($bvn) != 11) {
//     $error = 'Your BNV has to be 11 digits';
//     include('profile.php');
//     exit;
// }

if ($firstname == '') {   
    echo json_encode(['status' => 'error', 'message' => 'Firstname is required.']);
}
elseif ($lastname == '') {
    echo json_encode(['status' => 'error', 'message' => 'Lastname is required.']);    
}

elseif ($email == '') {
    echo json_encode(['status' => 'error', 'message' => 'Email is required.']);    
}
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Email Format.']);
}

elseif ($phone == '') {
    echo json_encode(['status' => 'error', 'message' => 'Phone Number is required.']);
}

elseif ($gender == '') {
    echo json_encode(['status' => 'error', 'message' => 'Gender is required.']);
}

elseif ($dob == '') {
    echo json_encode(['status' => 'error', 'message' => 'Date Of Birth is required.']);
}

elseif ($bustop == '') {
    echo json_encode(['status' => 'error', 'message' => 'Bus Stop is required.']);
}

elseif ($state == '') {
    echo json_encode(['status' => 'error', 'message' => 'State is required.']);
}

elseif ($local_govt == 'local_govt') {
    echo json_encode(['status' => 'error', 'message' => 'LGA is required.']);
}

elseif ($address == '') {
    echo json_encode(['status' => 'error', 'message' => 'Address is required.']);
}

elseif (($local_govt)) {
    $sql_3 = "update jobseeker set local_govt = '$local_govt' where email = '$email'";
    $result_3 = mysqli_query($db, $sql_3);
}

$query = "update jobseeker set firstname = '$firstname', lastname = '$lastname', middlename = '$middlename', email = '$email', phone = '$phone', gender = '$gender', dob = '$dob', bustop = '$bustop', state = '$state', address = '$address', bvn = '$bvn', status = 'personal'  where email = '" . $_SESSION['Klin_user'] . "'";

$result = mysqli_query($db, $query);

if ($result) {

    if (check_updated($_SESSION['candidate_id']) == 'yes') {
        $query_up = "update jobseeker set completed = 'updated' where candidate_id = '" . $_SESSION['candidate_id'] . "'";
        mysqli_query($db, $query_up);
    }


    $_SESSION['personal'] = $email;

    echo json_encode(['status' => 'error', 'message' => 'Profile Updated.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Profile not updated.']);
}
