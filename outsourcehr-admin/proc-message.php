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

$cat = base64_decode($_GET['cat']);
$template_id = mysqli_real_escape_string($db, $_POST['template_id']);
$stage = get_val('message_template', 'id', $_POST['template_id'], 'template_name');
$email = explode(',', $_POST['email']);
$phone = explode(',', $_POST['phone']);
$subject = mysqli_real_escape_string($db, $_POST['subject']);
$body_msg = $_POST['body_msg'];
$sms = $_POST['sms'];
$jobs_applied_id = explode(',', $_POST['jobs_applied_id']);



for ($i = 0; $i < count($jobs_applied_id); $i++) {

    //find and replace content in body
    $candidate_id =  get_val('jobseeker', 'email', $email[$i], 'candidate_id');
    $firstname =  get_val('jobseeker', 'email', $email[$i], 'firstname');
    $lastname =  get_val('jobseeker', 'email', $email[$i], 'lastname');
    $phone =  get_val('jobseeker', 'email', $email[$i], 'phone');
    $candidate_name = $firstname . ' ' . $lastname;


    send_sms($phone[$i], $sms);
    $test_code = test_code($email, $candidate_id);
    //get application status/stage before updating it
    $old_stage = $candidate_id = get_val('jobs_applied', 'id', $jobs_applied_id[$i], 'status');

    $query = "update jobs_applied set status = '$stage', date_modified = '" . today() . "' where id = '" . $jobs_applied_id[$i] . "'";


    $result = mysqli_query($db, $query);
    if ($result) {
        activity_log($_SESSION['Klin_admin_user'], 'Moved ' . $candidate_name . ' to ' . $stage);

        if ($stage == 'Assessment') {

            $candidate_id = get_val('jobs_applied', 'id', $jobs_applied_id[$i], 'candidate_id');
            $firstname = get_val('jobs_applied', 'id', $jobs_applied_id[$i], 'firstname');
            $lastname =  get_val('jobs_applied', 'id', $jobs_applied_id[$i], 'lastname');
            $email =  get_val('jobs_applied', 'id', $jobs_applied_id[$i], 'email');
            $phone =  get_val('jobs_applied', 'id', $jobs_applied_id[$i], 'phone');

            $job_id = get_val('jobs_applied', 'id', $jobs_applied_id[$i], 'job_id');
            $job_title = get_val('jobs_applied', 'id', $jobs_applied_id[$i], 'job_title');



            

            if (check_assessment($job_title) == 'confirm') {

                $sql = "insert into participant set candidate_id = '$candidate_id',job_applied_id = '" . $jobs_applied_id[$i] . "',firstname = '$firstname', lastname = '$lastname', email = '$email', phone = '$phone', job_id = '$job_id', job_title = '$job_title', exam_code = '$test_code', expire_date = '" . test_expiration() . "'";
                $result_sql = mysqli_query($db, $sql);

                //Write sned details for candidates to participants table for assessment.
            } else {

                //revert candidate status to the old stage
                $query = "update jobs_applied set status = '$old_stage' where id = '" . $jobs_applied_id[$i] . "'";
                $result = mysqli_query($db, $query);

                header("Location: applicants?error=Error moving candidate(s). There is no assessment for $job_title&cat=" . $_GET['cat']);
                exit;
            }
        }
        // $suc++;

        $message1 = str_replace('{firstname}', $firstname, $body_msg);
        $message2 = str_replace('{lastname}', $lastname, $message1);
        $message3 = str_replace('{email}', $email[$i], $message2);
        $message4 = str_replace('{test_url}', assessment_link(), $message3);
        $message5 = str_replace('{test_code}', $test_code, $message4);

        $sms1 = str_replace('{firstname}', $firstname, $sms);
        $sms2 = str_replace('{lastname}', $lastname, $sms1);
        $sms3 = str_replace('{email}', $email[$i], $sms2);
        $sms4 = str_replace('{test_url}', assessment_link(), $sms3);
        $sms5 = str_replace('{test_code}', $test_code, $sms4);
    } else {


        $message1 = str_replace('{firstname}', $firstname, $body_msg);
        $message2 = str_replace('{lastname}', $lastname, $message1);
        $message3 = str_replace('{email}', $email[$i], $message2);
        $message4 = str_replace('{test_url}', assessment_link(), $message3);
        $message5 = $message4;

        $sms1 = str_replace('{firstname}', $firstname, $sms);
        $sms2 = str_replace('{lastname}', $lastname, $sms1);
        $sms3 = str_replace('{email}', $email[$i], $sms2);
        $sms4 = str_replace('{test_url}', assessment_link(), $sms3);
        $sms5 = $sms4;
    }    

    mail_candidate($email[$i], $subject, $message5);

    // send_sms($phone,$sms5);
}

//If applicants are moved to second level interview. Export and mail details to admin
if ($stage == 'Second Level Interview') {
    
    export_to_recruiter($_POST['jobs_applied_id']);
}

header("Location: applicants?success=Message Sent Successfully&cat=" . base64_encode($cat));
// if ($suc > 0) {
// } else {

//     header("Location: applicants?error=Could not send Message&cat=" . base64_encode($cat));
// }