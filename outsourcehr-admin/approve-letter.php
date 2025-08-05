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
if (!$_GET['id']) {

    $id = mysqli_real_escape_string($db, $_POST['id']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $phone = mysqli_real_escape_string($db, $_POST['mobile']);
    $subject = mysqli_real_escape_string($db, $_POST['subject']);
    $body_msg = mysqli_real_escape_string($db, $_POST['body_msg']);
    $client = mysqli_real_escape_string($db, $_POST['client']);
} else {
    $id = base64_decode($_GET['id']);
    $email = get_approve_details($id, 'email');
    $name = get_approve_details($id, 'fullname');
    $phone = get_approve_details($id, 'phone');
    $subject = get_approve_details($id, 'subject');
    $body_msg = get_approve_details($id, 'body');
    $client = get_approve_details($id, 'client');
    $client = get_clients($client);
}

//$cc = 'mayowadelu@gmail.com';


if ($_GET['id']) {
    $query_update = "UPDATE approve_message SET status = 'Approved' WHERE id='$id'";
    $result_update = mysqli_query($db, $query_update);


    // Updating approved message 
    $query_update = "UPDATE approve_message SET subject = '$subject', body = '$body_msg', status= 'Approved by HRBP' WHERE id='$id'";
    $result_update = mysqli_query($db, $query_update);

    $message_body = "Dear $name, <br><br>

    We are pleased to offer you a provisional employment at $client. Please find attached your Offer Letter. <br><br>
    
    If you are accepting this offer, please print the attached letter, sign on the section that speaks to accepting the offer offer. Once you have signed, click on the Accept link below to send us your signed copy of the offer letter.
    <br>";
    

    $anchor = "Please proceed to <a href='" . root() . "/acceptOffer?e=" . base64_encode($email) . "'>Accept</a> or <a href='" . root() . "/rejectOffer?e=" . base64_encode($email) . "'>Reject</a> this offer letter. <br>";

    $message_end = "Taking the action above will help our team confirm your response to this offer.";
    $body = $message_body . "<br>" . $anchor . "<br>" . $message_end;    

    $filename = root() . "generate_offer_letter/letters/" . $name . " offer letter.pdf";
    mail_client($email, $cc, $subject, $body, $filename);

    mail_client(hrbp_admin_email(), $cc, $subject . ' HR Copy ', $body, $filename);
    // send_email($email, $name, org(), "Accept Or Decline Offer Letter From $client", $body,$filename);
    // exit;
    // If success
    header("location: assignedMessage?cat=" . base64_encode('staff') . "");
}