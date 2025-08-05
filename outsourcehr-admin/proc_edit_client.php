<?php

ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('Clients');
$id = $_POST['id'];
$client_name = mysqli_real_escape_string($db, $_POST['client_name']);
$client_code = mysqli_real_escape_string($db, $_POST['client_code']);
$contact_person = mysqli_real_escape_string($db, $_POST['contact_person']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$phone = mysqli_real_escape_string($db, $_POST['phone']);
$online = mysqli_real_escape_string($db, $_POST['online']);
$clockin = mysqli_real_escape_string($db, $_POST['clockin']);
$geofence = mysqli_real_escape_string($db, $_POST['geofence']);
$location = mysqli_real_escape_string($db, $_POST['location']);

if ($client_name == '') {
    $error = "Contact person is required";
    include('clients.php');
    exit;
}
if ($client_code == '') {
    $error = "Client code is required";
    include('clients.php');
    exit;
}

if ($contact_person == '') {
    $error = "Contact person is required";
    include('clients.php');
    exit;
}

if ($email == '') {
    $error = "Email is required";
    include('clients.php');
    exit;
}

if ($phone == '') {
    $error = "Phone is required";
    include('clients.php');
    exit;
}

if ($clockin == '') {
    $error = "clockin is required";
    include('add-client.php');
    exit;
}
if (!$online) {
    $online = 'no';
}

if ($_FILES['logo']['name']) {
    $file = $_FILES['logo']['name'];
    $file_loc = $_FILES['logo']['tmp_name'];
    $file_size = $_FILES['logo']['size'];
    $file_type = $_FILES['logo']['type'];
    $folder = "../uploads/Clients";

    $logo_size = $file_size / 1024;

    $logo_name = strtolower($file);

    $file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    if ($logo_size > 1550) {
        $error = "Sorry, your logo file is too large, the required file size is 1.5mb below";
        include('clients.php');
        exit;
    }

    if ($file == '') {
        $error = "Logo is required";
        include('clients.php');
        exit;
    }

    if (strlen($logo_name) > 20) {
        $error = "Your logo file name is too long, kindly rename it to at least 20 letters";
        include('clients.php');
        exit;
    }

    if ($file_ext == 'JPEG' || $file_ext == 'jpeg' || $file_ext == 'JPG' || $file_ext == 'jpg' || $file_ext == 'PNG' || $file_ext == 'png') {
        $logo = str_replace(' ', ' ', $logo_name);
        move_uploaded_file($file_loc, $folder . $logo);
    } else {
        $error = "Please reupload your logo , the ony accepted file format is JPG, jpg, JPEG, jpeg, PNG, png";
        include('clients.php');
        exit;
    }
    $sql_2 = "update clients set logo = '$logo' where id = '$id'";
    $result_2 = mysqli_query($db, $sql_2);
}

$query = "update  clients set client_name = '$client_name', client_code = '$client_code', contact_person = '$contact_person', email = '$email', phone = '$phone', online_gua = '$online', clockin = '$clockin' where id = '$id'";
$result = mysqli_query($db, $query);
if ($result) {
    if ($clockin == 'enabled') {
        $select = mysqli_query($db, "SELECT * FROM clockin_setting WHERE client_id = '$client_code'");
        $num = mysqli_num_rows($select);
        if ($num == 0) {            
            
            $token = token();
            $insert = mysqli_query($db, "INSERT INTO clockin_setting SET client_id = '$client_code', setting = '$clockin', geofence = '$geofence', geolocation = '$location', token = '$token'");
        }else{
            $update = mysqli_query($db, "UPDATE clockin_setting SET setting = '$clockin', geofence = '$geofence', geolocation = '$location' WHERE client_id = '$client_code'");
        }
    }
    activity_log($_SESSION['Klin_admin_email'], "Edited client : ($client_name)");

    $success = "Client has been successfully edited";
    include('clients.php');
    exit;
} else {
    $error = "Database Error";
    include('clients.php');
    exit;
}
