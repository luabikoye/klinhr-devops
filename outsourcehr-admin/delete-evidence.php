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
$candidate_id = base64_decode($_GET['candidate_id']);


if (privilege() == 'Super Admin' &&  'Admin') {
    $query = "delete from verified_document where id = '$id'";
    $result = mysqli_query($db, $query);
    if ($result) {
        activity_log($_SESSION['Klin_admin_email'], "Deleted Record from $return");
        header("Location: upload_evidence?candidate_id=".$_GET['candidate_id']);
    }
} else {
    $error = 'You do not have the right privilede to delete item';
    include('index.php');
    exit;
}