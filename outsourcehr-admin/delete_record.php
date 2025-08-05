<?php
ob_start();
session_start();

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');

$id = base64_decode($_GET['id']);
$tab = base64_decode($_GET['tab']);
$return = base64_decode($_GET['return']);


if (privilege() == 'Super Admin' &&  'Admin') {
    $query = "delete from $tab where id = '$id'";
    $result = mysqli_query($db, $query);
    if ($result) {
        activity_log($_SESSION['Klin_admin_email'], "Deleted Record from $return");
        header("Location: $return?del=success");
    }
} else {
    $error = 'You do not have the right privilede to delete item';
    include('index.php');
    exit;
}
