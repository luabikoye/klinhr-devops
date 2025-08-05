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

elseif ($address == '') {
    echo json_encode(['status' => 'error', 'message' => 'Address is required.']);
}


// if ($_FILES['passport']['name']) {

//     $path = $email . '_' . $_FILES['passport']['name'];
//     $file_loc = $_FILES['passport']['tmp_name'];
//     $file_size = $_FILES['passport']['size'];
//     $file_type = $_FILES['passport']['type'];
//     $folder = "uploads/documents/";

//     $doc_size = $file_size / 1024;

//     $file_name = strtolower($path);

//     $file_ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));


//     if ($path == '') {
//         $error = 'File is required';
//         include('profile.php');
//         exit;
//     }

//     if ($doc_size > 1550) {
//         $error = 'Sorry, your passport file is too large, the required file size is 1.5 MB below';
//         include('profile.php');
//         exit;
//     }


//     //  if(strlen($file_name) > 25)
//     // {
//     //     echo '<span class="text-danger"> <i class="fa fa-times"> </i> Your file file name is too long, kindly rename it to at least 20 letters.</span>';
//     //   exit;
//     // }

//     if ($file_ext == 'gif' || $file_ext == 'GIF' || $file_ext == 'jpg' || $file_ext == 'JPG' || $file_ext == 'png' || $file_ext == 'PNG' || $file_ext == 'jpeg' || $file_ext == 'JPEG') {
//         $path = str_replace(' ', ' ', $file_name);
//         move_uploaded_file($file_loc, $folder . $path);
//     } else {

//         $error = 'Please reupload your passport file, the ony accepted file format is GIF, gif, JPG, jpg, PNG, png, JPEG, jpeg';
//         include('profile.php');
//         exit;
//     }

//     $sql_2 = "update jobseeker set passport = '$path' where email = '$email'";
//     $result_2 = mysqli_query($db, $sql_2);
// }

if (($local_govt)) {
    $sql_3 = "update jobseeker set local_govt = '$local_govt' where email = '$email'";
    $result_3 = mysqli_query($db, $sql_3);
}

$query = "update jobseeker set firstname = '$firstname', lastname = '$lastname', middlename = '$middlename', email = '$email', phone = '$phone', gender = '$gender', dob = '$dob', bustop = '$bustop', state = '$state', address = '$address', bvn = '$bvn', status = 'personal'  where candidate_id = '" . $_SESSION['candidate_id'] . "'";

$result = mysqli_query($db, $query);

if ($result) {

    if (check_updated($_SESSION['candidate_id']) == 'yes') {
        $query_up = "update jobseeker set completed = 'updated' where candidate_id = '" . $_SESSION['candidate_id'] . "'";
        mysqli_query($db, $query_up);
    }


    $_SESSION['personal'] = $email;

    echo json_encode(['status' => 'success', 'message' => 'Profile Saved.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'DB Error.']);
}

