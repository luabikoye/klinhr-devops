<?php
ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');

// Parameters 
$id = base64_decode($_GET['id']);
$name = base64_decode($_GET['name']);

// Updating approved message 
$query_update = "UPDATE approve_message SET status = 'Declined' WHERE id='$id'";
$result_update = mysqli_query($db, $query_update);


// If success
if ($result_update) {

    activity_log($_SESSION['Klin_admin_email'], "declined offer letter for $name");
    $success = base64_encode("Message Successfully Declined");
    header("Location: rejectreason?cat=" . base64_encode($id));

    exit;
} else {
    // if database error 
    $error = base64_encode("An error occured while declining message");
    header("Location: assignedMessage?error=$error&cat=" . base64_encode($id));
    exit;
}
