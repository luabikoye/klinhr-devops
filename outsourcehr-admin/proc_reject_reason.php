<?php

ob_start();
session_start();


include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');

$description = mysqli_real_escape_string($db, $_POST['description']);
$id = $_POST['id'];


$query = "SELECT * FROM approve_message WHERE id= '$id'";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);
$name = $row['fullname'];
if ($result) {
    // Getting email of offer letter oofice 

    $offerleter_admin = notification_email('offerletter');
    if (!$offerleter_admin) {
        $offerleter_admin = notification_email('Onboarding');
    }


    // Sending mail to source
    $subject = "Reason for Rejecting Offer Letter";
    $body = "The generated offer letter for $name was rejected due to the following: <br>
                $description";
    $file = "Null";

    send_email($offerleter_admin, $offerleter_admin, organisation(), $subject, $body);

    // Updating decline reason to database 
    $query_update = "UPDATE approve_message SET decline_reason = '$description' WHERE id='$id'";
    $result_update = mysqli_query($db, $query_update);

    if ($result_update) {
        activity_log($_SESSION['Klin_admin_email'], "sent reasons for rejecting $name offer letter");
        $success = base64_encode("Reason sent successfully");
        header("Location: rejectreason?success=$success&cat=" . base64_encode($id));
        exit;
    }
} else {
    $error = base64_encode("Something went wrong trying to update cover letter");
    header("Location: rejectreason?error=$error&cat=" . base64_encode($id));
    exit;
}