<?php

ob_start();
session_start();

ob_start();

if (!isset($_SESSION['Klin_admin_user'])) {
    include('index.php');
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');


// Parameters  
$cat = mysqli_real_escape_string($db, $_POST['catid']);
$template_id = mysqli_real_escape_string($db, $_POST['template_id']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$fname = mysqli_real_escape_string($db, $_POST['name']);
$lname = mysqli_real_escape_string($db, $_POST['lastname']);
$phone = mysqli_real_escape_string($db, $_POST['phone']);
$subject = mysqli_real_escape_string($db, $_POST['subject']);
$body_msg = mysqli_real_escape_string($db, $_POST['body_msg']);
$valid_id = mysqli_real_escape_string($db, $_POST['messageId']);

$position = mysqli_real_escape_string($db, $_POST['position']);
$client_code = mysqli_real_escape_string($db, $_POST['clien']);
$staff_id = mysqli_real_escape_string($db, $_POST['staff_id']);
$account_token = $_SESSION['account_token'] ? 'account_token = "' . $_SESSION['account_token'] . '"' : 'account_token IS NULL ';
if ($lname) {
    $name = $fname . ' ' . $lname;
} else {
    $name = $fname;
}

$leave = ($_POST['leave']);
$basic_salary = $_POST['basic_salary'];
$housing = $_POST['housing'];
$transport = $_POST['transport'];
$meal = $_POST['meal'];
$utility = $_POST['utility'];
$entertainment = $_POST['entertainment'];
$leave_allowance = $_POST['leave_allowance'];
$monthly_net = $_POST['monthly_net'];
$annual_pay = $_POST['salary'];
$salary_band = $_POST['band'];

$code = rand(1000, 600);
$char = array('' . substr(get_val('emp_staff_details', 'id', $pool_id, 'firstname'), 0, 2) . get_val('emp_staff_details', 'id', $pool_id, 'candidate_id'));
$a_char = strtoupper($char[0]);
$user = $a_char . $code;
// Query 
$query = "UPDATE message_template SET message='$body_msg' WHERE id='$valid_id'";

$result = mysqli_query($db, $query);
$valid_id;


// If user wants to generate pdf 
if ($_POST['generate']) {

    header("location: generate_offer_letter/?id='" . base64_encode($valid_id) . "'&name='" . base64_encode($name) . "'&email='" . base64_encode($email) . "'&phone='" . base64_encode($phone) . "'&subject='" . base64_encode($subject) . "'&staff_id='" . base64_encode($staff_id) . "'");
    exit;
}

// Sending offerletter to user mail 

if ($_POST['offerletter']) {

    $query_select = "SELECT * from login where privilege= 'HRBP' and client like '%$client_code%'";

    $result_select = mysqli_query($db, $query_select);
    $row_select = mysqli_fetch_array($result_select);

    if ($row_select['email'] == "") {
        $query_select = "SELECT * from login where privilege= 'HRBP' and client like '%ALL%'";

        $result_select = mysqli_query($db, $query_select);
        $row_select = mysqli_fetch_array($result_select);
    }

    $admin_email = $row_select['email'];

    // Updating table 
   $query_details = "Update emp_staff_details SET completed= 'Offerletter' WHERE email_address='$email'";
    $result_details = mysqli_query($db, $query_details);

    // Retrieving body of offer letter 
    $query_offer = "SELECT * FROM message_template WHERE template_name='Offer Letter Body'";
    $result_offer = mysqli_query($db, $query_offer);
    $row_offer = mysqli_fetch_array($result_offer);

    // Replacing string values with database text 
    $old = $row_offer['message'];
    $body = str_replace("{firstname} {lastname}", "$name", "$body_msg");
    $body_update = str_replace("{role}", "$position", "$body");

    // Inserting into table 
    $query_insert = "INSERT INTO approve_message SET staff_id = '$staff_id', candidate_id = '$candidate_id', fullname = '$name', email = '$email', phone = '$phone', template= '$template_id', subject= '$subject', body='$body_update', adminEmail='$admin_email', sent_by = '{$_SESSION['Klin_admin_user']}', status= 'Not Approved', client= '$client_code', $account_token";

    $result_insert = mysqli_query($db, $query_insert);
    $insert_id = mysqli_insert_id($db);

    activity_log($_SESSION['Klin_admin_user'], "processed offerletter of $name");

    // File to be sent 
    $file = "generate_offer_letter/letters/" . $name . " offer letter.pdf";
    // $cc = notification_email("offerletter"); 

    // If file exists 
    if (file_exists($file)) {

        $subject = "Approval of Letter Request";
        $body = "Hi HRBP,<br>
                A new letter have been drafted out and waiting your approval. Below are the details of the request <br><br>

                    Full Name: $name <br>
                    Email: $email <br>
                    Mobile: $phone <br>
                    Subject: $subject <br><br>
                     After Reviewing the offer Letter from the attachment below you can click the link to <a href='" . root() . "/approve-letter?id=" . base64_encode($insert_id) . "'>Approve</a> or <a href='" . root() . "/reject-letter?id=" . base64_encode($insert_id) . "&name=" . base64_encode($name) . "'>Reject</a> the letter.";
        send_email(admin_email(), organisation(), organisation(), $subject, $body, $file);


        $success = base64_encode("Message Sent Successfully");
        header("Location: hrbp?success=$success&cat=" . base64_encode($cat));

        exit;
    } else {
        // if file does not exist 
        $error = base64_encode("Kindly Generate File to Proceed");
        header("Location: hrbp?error=$error&cat=" . base64_encode($cat));
        exit;
    }
}