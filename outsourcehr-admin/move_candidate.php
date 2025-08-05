<?php
ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');
validatePermission('Job Seeker');
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

$date = date('Y-m-d');

if ($client == 'select_client') {
    $error = "Client is not selected";
    include('assign_client.php');
    exit;
}
//  
$client = implode(',', $_POST['client']);
$candidate_id = explode(',', $_POST['candidate_id']);
$account_token = $_SESSION['account_token'] ? 'account_token = "' . $_SESSION['account_token'] . '"' : 'account_token IS NULL ';

// $sql = ("select * from clients where id in ($client)"); 

// send email to onboarding department
$notification_check = "select * from notification_email where privilege = 'Onboarding' ";
$notification_result =  mysqli_query($db, $notification_check);
$notification_num = mysqli_num_rows($notification_result);

$sql = ("select * from jobseeker where candidate_id in (" . implode(',',  $candidate_id) . ")");
$result_1 = mysqli_query($db, $sql);
$num = mysqli_num_rows($result_1);
for ($c = 0; $c < ($num); $c++) {
    $row = mysqli_fetch_array($result_1);
    $name[] = $row['firstname'] . ' ' . $row['lastname'];
}

$names = implode(', ', $name);

for ($notify = 0; $notify < $notification_num; $notify++) {
    $msg = 'A new candidate (' . $names . ') has been moved to Onboarding, click <a style="padding: 7px; color:white; text-decoration: none; background-color: green; " href="' . host() . '/admin">Admin</a> to go to the admin end.';

    $notification_row = mysqli_fetch_array($notification_result);

    send_email($notification_row['email'], $notification_row['email'], organisation(), 'Onboarding Stage', $msg);
}


for ($i = 0; $i < count($candidate_id); $i++) {
    $code = rand(1000, 600);
    $char = array('' . substr(get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'firstname'), 0, 2) . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'candidate_id'));
    $a_char = strtoupper($char[0]);
    $onboarding_code = $a_char . $code;

    $id = get_val('jobs_applied', 'candidate_id', $candidate_id[$i], 'id');

    $message = 'You have successfully been moved to onboarding. Please use this code <b>' . $onboarding_code . '</b> for your onboarding and click <b> <a href="' . host() . '/onboarding"> ONBOARDING </a> </b> to complete your onboarding ';

    send_email(get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'email'), get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'firstname'), organisation(), 'Onboarding Stage', $message);

    // send_sms(get_val('jobseeker', 'candidate_id',$candidate_id[$i], 'phone'), $message);

    $msg = 'Hello ' . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'firstname') . ' you have successfully been moved to Onboarding';
    $query3 = "insert into notification set candidate_id = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'candidate_id') . "', notifier = 'Admin', message = '$msg', status = 'Unread', date = '$date'";
    $result2 =  mysqli_query($db, $query3);

    $query = "insert into emp_staff_details set 
    $account_token,
        firstname = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'firstname') . "',
        surname = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'lastname') . "',
        middlename = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'middlename') . "',
        date_of_birth = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'dob') . "',
        email_address = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'email') . "',
        state_origin = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'state') . "',
        local_govt_of_origin_code = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'local_govt') . "',
        sex = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'gender') . "',
        mobile_phone_number = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'phone') . "',
        current_address_1 = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'address') . "',
        candidate_id = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'candidate_id') . "',
        company_code = '" . get_val('clients', 'id', $client, 'client_code') . "',       
        position_code = '" . get_val('jobs_applied', 'candidate_id', $candidate_id[$i], 'job_title') . "',
        job = '" . get_val('jobs_applied', 'candidate_id', $candidate_id[$i], 'job_title') . "',
       
        1st_referee_name = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'refName') . "',
        1st_referee_address_1 = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'refAddress') . "',
        1st_referee_town = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'refCity') . "',
        1st_referee_state_code = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'refState') . "',
        1st_referee_phone = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'refPhone') . "',
        1st_referee_email = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'refEmail') . "',

        2nd_referee_name = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'refName2') . "',
        2nd_referee_address_1 = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'refAddress2') . "',
        2nd_referee_town = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'refCity2') . "',
        2nd_referee_state_code = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'refState2') . "',
        2nd_referee_phone = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'refPhone2') . "',
        2nd_referee_email = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'refEmail2') . "',

        1st_institution_code = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'first_institution') . "',
        1st_qualification_code = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'first_qualification') . "',
        1st_course_code = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'first_course') . "',
        1st_result_grade = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'first_degree') . "',
      
        2nd_institution_code = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'institution2') . "',
        2nd_qualification_code = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'qualification_2') . "',
        2nd_course_code = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'course2') . "',
        2nd_result_grade = '" . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'degree2') . "',
        onboarding_code =  '$onboarding_code',
        completed = 'N',
       
        created_by = '" . $_SESSION['Klin_admin_user'] . "',
        date = '$date',
        date_employed = '$date' ";
    $result = mysqli_query($db, $query);

    application_log(get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'candidate_id'), get_val('jobs_applied', 'candidate_id', $candidate_id[$i], 'job_id'), 'Moved  to Onboarding', 'Onboarding');




    activity_log($_SESSION['Klin_admin_user'], 'Moved ' . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'firstname') . ' ' . get_val('jobseeker', 'candidate_id', $candidate_id[$i], 'lastname') . ' to Onboarding');

    $query1 = "update jobs_applied set status = 'Onboarding', date_modified = '" . today() . "' where candidate_id = '$candidate_id[$i]'";
    $result1 = mysqli_query($db, $query1);
}
if ($result) {


    $success = "Candidate successfully moved to onboarding";
    header("Location: applicants.php?cat=" . base64_encode('Applied'));
    exit;
} else {
    $error = "Candidate already in onboarding";
    include('assign_client.php');
    exit;
}
