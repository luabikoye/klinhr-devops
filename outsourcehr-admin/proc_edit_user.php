<?php

ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('General Setting');
$id = $_POST['id'];

$firstname = mysqli_real_escape_string($db, $_POST['firstname']);
$lastname = mysqli_real_escape_string($db, $_POST['lastname']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$phone = mysqli_real_escape_string($db, $_POST['phone']);
$client = implode(',', $_POST['client']);

$privilege = implode(',', $_POST['privilege']);

if ($firstname == '') {
    $error = "Firstname is required";
    include('user.php');
    exit;
}

if ($lastname == '') {
    $error = "Lastname is required";
    include('user.php');
    exit;
}

if ($email == '') {
    $error = "Email is required";
    include('user.php');
    exit;
}

if ($phone == '') {
    $error = "Phone is required";
    include('user.php');
    exit;
}

if ($privilege == 'Select Privilege') {
    $error = "Privilege is required";
    include('user.php');
    exit;
}

// $sql = "select * from login where email = '$email'";
// $result_1 = mysqli_query($db, $sql);
// $exist = mysqli_fetch_assoc($result_1);
// if($exist['email'] == $email)
// {
//     $error = "Sorry you cannot edit this user because this user's email already exist !!!";
//     include('user.php');
//     exit;
// }

$query = "update login set firstname = '$firstname', lastname = '$lastname', email = '$email', phone = '$phone', privilege = '$privilege', username = '$email', client = '$client' where id = '$id'";
$result = mysqli_query($db, $query);
if ($result) {
    $success = "User successfully edited";
    include('user.php');
    exit;
} else {
    $error = "User cannot be edited, try again later !!!";
    include('user.php');
    exit;
}
