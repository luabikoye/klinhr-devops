<?php

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => true,  // If your site uses HTTPS
    'httponly' => true  // Set httponly flag
]);

ob_start();
session_start();

ob_start();

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');


// Parameters 
$email = base64_decode($_GET['e']);

// Updating user column if accepted 

// $query_offer = "Update emp_staff_details SET completed= 'rejected', staff = 'no', status = 'active' WHERE email_address='$email'";
// $result_offer = mysqli_query($db, $query_offer);



// Details
$query_update = "SELECT * FROM emp_staff_details WHERE email_address='$email'";
$result_update = mysqli_query($db, $query_update);
$row_update = mysqli_fetch_array($result_update);


    $subject = "Offer Letter Rejected ";
    $body = "Dear HRBP, <br><br>
            A staff just rejected their offer letter.<br>
            Details below:<br>
            Name: " . $row_update['firstname'] . " ".$row_update['surname']."<br>
            Role: " . $row_update['position_code'] . " <br>
            Client: " . $row_update['company_code'] . " <br>
            
            ";
    $file = "Null";
    mail_client(get_hrbp($row_update['company_code']), $cc, $subject, $body, $file);

    $encode_email = base64_encode($email);
    $type = base64_encode("reject");
    
    header("location: processofferrequest?e=$encode_email&t=$type");

    ?>