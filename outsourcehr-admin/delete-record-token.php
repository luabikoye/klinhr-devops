<?php
ob_start();
session_start();

if (!isset($_SESSION['Klin_admin_user'])) {
    include('index.php');
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');

$token = base64_decode($_GET['t']);
$bid = $_GET['id'];
$tab = $_GET['tab'];
$return = $_GET['return'];


if (privilege() == 'Super Admin' &&  'Admin') {
    $query = "delete from $tab where token = '$token'";
    $result = mysqli_query($db, $query);
    if ($result) {
        if ($bid) {
            activity_log($_SESSION['Klin_admin_email'], "Deleted Record from $return");
            header("Location: $return?del=success&id=$bid");
        }
        header("Location: $return?del=success");
    }
} else {
    $error = 'You do not have the right privilede to delete item';
    include('index.php');
    exit;
}
