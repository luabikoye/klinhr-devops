<?php
ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');
validatePermission('Clients');
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}


if ($_POST['id']) {
    $id = mysqli_real_escape_string($db, $_POST['id']);

    $format = mysqli_real_escape_string($db, $_POST['staff_id']);

    $query = "update staff_id_formats set format = '$format' where id = '$id'";
    $result = mysqli_query($db, $query);
    if ($result) {
        header('location: staff-id-format?edit=success');
        exit;
    }
}

$staff_id = mysqli_real_escape_string($db, $_POST['staff_id']);

if ($staff_id == '') {
    $error = "Staff Id is required";
    include('staff-id-format.php');
    exit;
}


$sql = "select * from staff_id_formats where format = '$staff_id'";
$result_1 = mysqli_query($db, $sql);
$exist = mysqli_fetch_array($result_1);
if ($exist['format'] == $staff_id) {
    $error = "Sorry this staff id already exist";
    include('staff-id-format.php');
    exit;
}




$query = "insert into staff_id_formats set format = '$staff_id'  ";
$result = mysqli_query($db, $query);
if ($result) {
    $success = "Staff Id successfully added";
    include('staff-id-format.php');
    exit;
} else {
    $error = "Staff Id was not created, check if all information were correctly entered";
    include('staff-id-format.php');
    exit;
}
