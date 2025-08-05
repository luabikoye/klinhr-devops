<?php

ob_start();
session_start();
include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

$location = $_POST['locationName'];
$old_location = $_POST['old_location'];

if ($_POST['id']) {
    $id = ($_POST['id']);
}

$query = "update locations set locationName  = '$location' where id = '$id'";
$result = mysqli_query($db, $query);
if ($result) {
    activity_log($_SESSION['Klin_admin_user'], "Edited $old_location to $location ");
    $success = "location successfully edited";
    include('location.php');
    exit;
} else {
    $error = "Sorry, location canot be edited at this time";
    include('location.php');
    exit;
}
