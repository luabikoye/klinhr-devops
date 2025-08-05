<?php

ob_start();
session_start();

ob_start();

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');

$firstname = mysqli_real_escape_string($db, $_POST['firstname']);
$lastname = mysqli_real_escape_string($db, $_POST['lastname']);
$phone = mysqli_real_escape_string($db, $_POST['phone']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$job_id = mysqli_real_escape_string($db, $_POST['job_title']);
$client_name = mysqli_real_escape_string($db, $_POST['client_name']);
$account_token = $_SESSION['account_token'] ? 'account_token = "' . $_SESSION['account_token'] . '"' : 'account_token IS NULL ';



if ($firstname == '') {
    $error = "Firstname is required";
    include('add-candidate.php');
    exit;
}
if ($lastname == '') {
    $error = "Lastname is required";
    include('add-candidate.php');
    exit;
}
if ($phone == '') {
    $error = "Phone is required";
    include('add-candidate.php');
    exit;
}
if ($email == '') {
    $error = "Email is required";
    include('add-candidate.php');
    exit;
}
if ($job_title == 'Select Job Title') {
    $error = "Job title is required";
    include('add-candidate.php');
    exit;
}
if ($client_name == 'Select Client Name') {
    $error = "Client name is required";
    include('add-candidate.php');
    exit;
}

$sql = "select * from jobseeker_signup where email = '$email' and $account_token";
$result_1 = mysqli_query($db, $sql);
$exist = mysqli_fetch_assoc($result_1);

if ($exist['email'] == $email) {
    $candidate_id = $exist['id'];
    $existing = 'yes';
}

$date_posted = get_val('job_post', 'id', $job_title, 'date_posted');
$deadline = get_val('job_post', 'id', $job_title, 'deadline');
$client_name = get_val('clients', 'id', $client_name, 'client_name');
$job_title = get_val('assessment', 'job_id', $job_id, 'assessment_name');
$date_applied = date('Y-m-d');
$stage = 'Assessment';
$test_code = test_code($email, $candidate_id);


if ($existing != 'yes') {
    $query = "insert into jobseeker_signup set firstname = '$firstname', lastname = '$lastname', fullname = '$firstname $lastname', phone = '$phone', email = '$email',  password = md5('$email'), hear_about = 'Assessment', status = 'active', account_token = '$account_token'";
    $result = mysqli_query($db, $query);

    $candidate_id = mysqli_insert_id($db);

    $query1 = "insert into jobseeker set firstname = '$firstname', lastname = '$lastname', phone = '$phone', email = '$email', candidate_id = '$candidate_id', $account_token ";
    $result1 = mysqli_query($db, $query1);
}

$query2 = "insert into jobs_applied set firstname = '$firstname', lastname = '$lastname', phone = '$phone', email = '$email', job_title = '$job_title', client_name = '$client_name', candidate_id = '$candidate_id', job_id = '$job_id', job_type = 'Full time', date_posted = '$date_posted', deadline = '$deadline', date_applied = '$date_applied', status = 'Assessment', $account_token";

$result2 = mysqli_query($db, $query2);
if ($result2) {
    $job_applied_id = mysqli_insert_id($db);
}


$sql_1 = "insert into participant set candidate_id = '$candidate_id', job_applied_id = '$job_applied_id', firstname = '$firstname', lastname = '$lastname', email = '$email', phone = '$phone', job_id = '$job_id', job_title = '$job_title', exam_code = '$test_code', expire_date = '" . test_expiration() . "', $account_token";
$result_sql_1 = mysqli_query($db, $sql_1);

if ($result_sql_1) {
    $candidate_id =  get_val('jobs_applied', 'id', $candidate_id, 'candidate_id');
    $job_id =  get_val('jobs_applied', 'id', $job_id, 'job_id');
    $job_title =  get_val('jobs_applied', 'id', $job_title, 'job_title');


    $body_msg = get_val('message_template', 'template_name', $stage, 'message');

    $message1 = str_replace('{firstname}', $firstname, $body_msg);
    $message2 = str_replace('{lastname}', $lastname, $message1);
    $message3 = str_replace('{email}', $email, $message2);
    $message4 = str_replace('{test_url}', assessment_link(), $message3);
    $message5 = str_replace('{test_code}', $test_code, $message4);

    $sms1 = str_replace('{firstname}', $firstname, $sms);
    $sms2 = str_replace('{lastname}', $lastname, $sms1);
    $sms3 = str_replace('{email}', $email, $sms2);
    $sms4 = str_replace('{test_url}', assessment_link(), $sms3);
    $sms5 = str_replace('{test_code}', $test_code, $sms4);

    $mail_content = $message5;


    $final_message = str_replace('{firstname}', $firstname, $mail_content);




    //  mail_candidate($email, get_stage_subject($stage), $final_message);
}

activity_log($_SESSION['Klin_admin_user'], "Added a new candidate : ($firstname)");

$success = "Candidate successfully added";
include('add-candidate.php');
exit;