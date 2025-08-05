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

$date = date('Y-m-d');

if (isset($_POST['btn_send_email'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $subject = $_POST['subject'];
    $msg = $_POST['message'];
    $return_url = mysqli_real_escape_string($db, $_POST['return_url']);

    if ($email == '') {
        $error = 'Please enter an email address';
        include('reply_staff.php');
        exit;
    }
    if ($subject == '') {
        $error = 'Please enter a subject';
        include('reply_staff.php');
        exit;
    }
    if ($msg == '') {
        $error = 'Please enter a message';
        include('reply_staff.php');
        exit;
    }
    $message = $msg.'<br><br>'.get_fullname($_SESSION['Klin_admin_user']);

    send_email($email, get_val('emp_staff_details', 'email_address', $email, 'firstname'), organisation(),  $subject, $message);
    $success = 'Email sent successfully';

    header("location: $return_url?msg=sent&unique='" . base64_encode($email) . "' ");
    exit;
}


if ($_POST['btn_move']) {

    $id = $_POST['id'];
    $candidate_id = $_POST['candidate_id'];

    $stage = $_POST['stage'];

    // send email to Verification department
    if ($stage == 'Verification') {
        $notification_check = "select * from notification_email where privilege = 'Verification' ";
        $notification_result =  mysqli_query($db, $notification_check);
        $notification_num = mysqli_num_rows($notification_result);

        $sql = ("select * from emp_staff_details where id in (" . implode(',',  $id) . ")");
        $result_1 = mysqli_query($db, $sql);
        $num = mysqli_num_rows($result_1);
        for ($c = 0; $c < ($num); $c++) {
            $row = mysqli_fetch_array($result_1);
            $name[] = $row['firstname'] . ' ' . $row['surname'];
        }

        $names = implode(', ', $name);

        for ($notify = 0; $notify < $notification_num; $notify++) {

            $msgs = 'A new candidate (' . $names . ') has been moved to Pending Verification, click <a style="color:white; text-decoration: none;font-weight:bolder " href="' . host() . '/admin">Admin</a> to go to the admin end.';

            $notification_row = mysqli_fetch_array($notification_result);

            send_email($notification_row['email'], $notification_row['email'], organisation(), 'Verification Stage', $msgs);
        }
    }



    $body_msg = get_val('message_template', 'template_name', $stage, 'message');
    if (!$_POST['id']) {
        header("Location: applicants?id=required&cat=" . $_GET['cat']);
        exit;
    }

    $count = count($id);
    for ($i = 0; $i < $count; $i++) {
        // if stage is onboarding
        if ($stage == 'Onboarding') {
            activity_log($_SESSION['Klin_admin_user'], 'Moved ' . get_val('emp_staff_details', 'id', $id[$i], 'firstname') . ' ' . get_val('emp_staff_details', 'id', $id[$i], 'surname') . ' to ' . $stage);
            header("location: assign_client?valid=" . base64_encode(implode(',', $id)) . "&cat=" . $_GET['cat']);
            exit;
        }



        // If candidate was reversed to Completed Onboarding
        // echo $check = "select * from jobs_applied where candidate_id in (".(implode(',',$candidate_id)).")";
        // $check_result = mysqli_query($db, $check);
        // $check_row = mysqli_fetch_array($check_result);

        if ($stage == 'completed_onboarding') {
            $completed_onboarding = "update emp_staff_details set completed = 'Y', date_pending = '" . date('Y-m-d H:i:s') . "' where id in (" . (implode(',', $id)) . ") ";
            $completed_onboarding_result = mysqli_query($db, $completed_onboarding);
            for ($i = 0; $i < count($candidate_id); $i++) {

                activity_log($_SESSION['Klin_admin_user'], 'Reversed ' . get_val('emp_staff_details', 'candidate_id', $candidate_id[$i], 'firstname') . ' ' . get_val('emp_staff_details', 'candidate_id', $candidate_id[$i], 'surname') . ' to Completed Onboarding ');
            }

            header("location: verification?onboarding=reversed&cat=UGVuZGluZyBWZXJpZmljYXRpb24=");
            exit;
        }
        // If candidate was reversed to Completed Onboarding


        // If candidate was reversed to Pending Verification1
        if ($stage == 'pending_verification') {
            for ($i = 0; $i < count($candidate_id); $i++) {
                $completed_onboarding_1 = "update emp_staff_details set completed = 'Pending Verification', date_pending = '" . date('Y-m-d H:i:s') . "' where id in (" . (implode(',', $id)) . ") ";
                $completed_onboarding_result_1 = mysqli_query($db, $completed_onboarding_1);

                activity_log($_SESSION['Klin_admin_user'], 'Reversed ' . get_val(
                    'emp_staff_details',
                    'candidate_id',
                    $candidate_id[$i],
                    'firstname'
                ) . ' ' . get_val('emp_staff_details', 'candidate_id', $candidate_id[$i], 'surname') . ' to Pending Verification ');
            }


            header("location: verification?pending=reversed&cat=Q29tcGxldGVkIFZlcmlmaWNhdGlvbg==");
            exit;
        }

        // If candidate was reversed to Pending Verification

        // if stage is pool
        if ($stage == 'Pool') {
            $implode = implode(',', $id);
            $pool = "update emp_staff_details set completed = 'Pool' where id in ($implode) ";
            $pool_result = mysqli_query($db, $pool);

            for ($i = 0; $i < count($candidate_id); $i++) {

                application_log(get_val('emp_staff_details', 'candidate_id', $candidate_id[$i], 'candidate_id'), get_val('jobs_applied', 'candidate_id', $candidate_id[$i], 'job_id'), 'Moved  to Pool',  'Pool');

                $candidate_name = get_val('emp_staff_details', 'id', $id[$i], 'firstname') . ' ' . get_val('emp_staff_details', 'id', $id[$i], 'lastname');
                activity_log($_SESSION['Klin_admin_user'], 'Moved ' . $candidate_name . ' to ' . $stage . ' ');


                activity_log($_SESSION['Klin_admin_user'], 'Moved ' . get_val('emp_staff_details', 'candidate_id', $candidate_id[$i], 'firstname') . ' ' . get_val('emp_staff_details', 'candidate_id', $candidate_id[$i], 'surname') . ' to Pool');

                $msg = 'Hello ' . get_val('emp_staff_details', 'id', $id[$i], 'firstname') . ' you have successfully been moved to Pool';

                $query3 = "insert into notification set candidate_id = '" . get_val('emp_staff_details', 'id', $id[$i], 'candidate_id') . "', notifier = 'Admin', message = '$msg', status = 'Unread', date = '" . today() . "'";
                $result2 =  mysqli_query($db, $query3);
            }

            header("location: pool?pool=completed&cat=cG9vbA==");
            exit;
        }
        // If stage is pool

        // If candidate was reversed to Completed Verification
        if ($stage == 'completed_verification') {
            for ($i = 0; $i < count($candidate_id); $i++) {
                $completed_onboarding_1 = "update emp_staff_details set completed = 'Completed Verification', date_pending = '" . date('Y-m-d H:i:s') . "' where id in (" . (implode(',', $id)) . ") ";
                $completed_onboarding_result_1 = mysqli_query($db, $completed_onboarding_1);
                activity_log($_SESSION['Klin_admin_user'], 'Reversed ' . get_val('emp_staff_details', 'candidate_id', $candidate_id[$i], 'firstname') . ' ' . get_val('emp_staff_details', 'candidate_id', $candidate_id[$i], 'surname') . ' to Completed Verification ');
            }
            header("location: verification?completed=reversed&cat=Q29tcGxldGVkIFZlcmlmaWNhdGlvbg==");
            exit;
        }
        // If candidate was reversed to Completed Verification


        // If stage is  Pending Verification
        if ($stage == 'Verification') {

            $reminder_day = reminder_48();

            $stage_query1 = "update emp_staff_details set completed = 'Pending Verification', 1st_guarantor_status = 'pending',1st_guarantor_reminder = '" . $reminder_day . "', 2nd_guarantor_status = 'pending',2nd_guarantor_reminder = '" . $reminder_day . "', backlog = 'no', date_pending = '" . date('Y-m-d H:i:s') . "' where id in (" . (implode(',', $id)) . ") ";
            $stage_result2 = mysqli_query($db, $stage_query1);

            for ($i = 0; $i < count($id); $i++) {
                application_log(get_val('emp_staff_details', 'id', $id[$i], 'candidate_id'), get_val('jobs_applied', 'candidate_id', $id[$i], 'job_id'), 'Moved  to Pending Verification',  'Pending Verification');

                $msg = 'Hello ' . get_val('emp_staff_details', 'candidate_id', $id[$i], 'firstname') . ' you have successfully been moved to Pending Verification';

                $query3 = "insert into notification set candidate_id = '" . get_val('emp_staff_details', 'id', $id[$i], 'candidate_id') . "', notifier = 'Admin', message = '$msg', status = 'Unread', date = '$date'";
                $result2 =  mysqli_query($db, $query3);

                $stage_query = "update jobs_applied set status = 'Pending Verification' where candidate_id = '" . get_val('emp_staff_details', 'id', $id[$i], 'candidate_id') . "' ";

                $stage_result = mysqli_query($db, $stage_query);

                activity_log($_SESSION['Klin_admin_user'], 'Moved ' . get_val('emp_staff_details', 'id', $id[$i], 'firstname') . ' ' . get_val('emp_staff_details', 'id', $id[$i], 'surname') . ' to Pending ' . $stage);


                //send message to guarantors

                $body_msg = get_val('message_template', 'template_name', 'Guarantor Verification', 'message');

                $sms = get_val('message_template', 'template_name', 'Guarantor Verification', 'sms_content');

                $staff_name = get_val('emp_staff_details', 'id', $id[$i], 'firstname') . ' ' . get_val('emp_staff_details', 'id', $id[$i], 'surname');
                $guarantor1_name = get_val('emp_staff_details', 'id', $id[$i], '1st_guarantor_name');
                $guarantor1_email = get_val('emp_staff_details', 'id', $id[$i], '1st_guarantor_email');
                $guarantor1_phone = get_val('emp_staff_details', 'id', $id[$i], '1st_guarantor_phone');

                $guarantor2_name = get_val('emp_staff_details', 'id', $id[$i], '2nd_guarantor_name');
                $guarantor2_email = get_val('emp_staff_details', 'id', $id[$i], '2nd_guarantor_email');
                $guarantor2_phone = get_val('emp_staff_details', 'id', $id[$i], '2nd_guarantor_phone');


                //find and replace for first Guarantor
                $message1 = str_replace('{staff_name}', $staff_name, $body_msg);
                $message2 = str_replace('{guarantor}', $guarantor1_name, $message1);

                $sms1 = str_replace('{staff_name}', $staff_name, $sms);
                $sms2 = str_replace('{guarantor}', $guarantor1_name, $sms1);

                $mail_content = $message2;
                $sms_content = $sms2;

                //$guarantor_form_path is in this include file
                include('pdf_generator/index.php');

                send_email($guarantor1_email, $guarantor1_name, sender_name(), 'Guarantor Verification for ' . $staff_name, $mail_content, $guarantor_form_path);
                send_sms($guarantor1_phone, $sms_content);




                //find and replace for second Guarantor
                $message1 = str_replace('{staff_name}', $staff_name, $body_msg);
                $message2 = str_replace('{guarantor}', $guarantor2_name, $message1);

                $sms1 = str_replace('{staff_name}', $staff_name, $sms);
                $sms2 = str_replace('{guarantor}', $guarantor2_name, $sms1);

                $mail_content = $message2;
                $sms_content = $sms2;

                send_email($guarantor2_email, $guarantor2_name, sender_name(), 'Guarantor Verification for ' . $staff_name, $mail_content, $guarantor_form_path);
                send_sms($guarantor1_phone, $sms_content);

                //delet generated file
                unlink($guarantor_form_path);
            }
            header("location:  onboarding-user?pending=verification&cat=WQ==");
            exit;
        }
        // If stage is  Pending Verification


        if ($stage == 'Completed Verification') {
            $query = "select * from verified_document where candidate_id = '" . get_val('emp_staff_details', 'id', $id[$i], 'candidate_id') . "' ";
            $result = mysqli_query($db, $query);
            $num = mysqli_num_rows($result);
            $row = mysqli_fetch_assoc($result);

            if ($row['document_name'] != 'Guarantor 1' && $row['document_name'] != 'Guarantor 2' && $row['document_name'] != 'Academics') {
                $error = "One of evidence of Academics, Guarantor 1, Guarantor 2 has not been uploaded for " . get_val('emp_staff_details', 'id', $id[$i], 'firstname') . " ";
                include('verification.php');
                exit;
            }

            // if($num != 3)
            // {
            //   $error = "One of evidence of Academics, Guarantor 1, Guarantor 2 has not been uploaded for ".get_val('emp_staff_details', 'id', $id[$i], 'firstname')." ";
            //   include('verification.php');
            //   exit;
            // }

            for ($i = 0; $i < count($id); $i++) {

                $stage_query2 = "update jobs_applied set status = 'Completed Verification' where candidate_id = '" . get_val('emp_staff_details', 'id', $id[$i], 'candidate_id') . "'";
                $stage_result2 = mysqli_query($db, $stage_query2);


                activity_log($_SESSION['Klin_admin_user'], 'Moved ' . get_val('emp_staff_details', 'candidate_id', $candidate_id[$i], 'firstname') . ' ' . get_val('emp_staff_details', 'candidate_id', $candidate_id[$i], 'surname') . ' to ' . $stage);

                application_log(get_val('emp_staff_details', 'candidate_id', $candidate_id[$i], 'candidate_id'), get_val('jobs_applied', 'candidate_id', $candidate_id[$i], 'job_id'), 'Moved  to Completed Verification',  'Completed Verification');




                $msg = 'Hello ' . get_val('emp_staff_details', 'candidate_id', $candidate_id[$i], 'firstname') . ' you have successfully been moved to Completed Verification';
                $query3 = "insert into notification set candidate_id = '" . get_val('emp_staff_details', 'candidate_id', $candidate_id[$i], 'candidate_id') . "', notifier = 'Admin', message = '$msg', status = 'Unread', date = '$date'";
                $result2 =  mysqli_query($db, $query3);


                $stage_query3 = "update emp_staff_details set completed = 'Completed Verification', date_moved = '" . date('Y-m-d H:i:s') . "'  where id = '$id[$i]' ";
                $stage_result3 = mysqli_query($db, $stage_query3);
            }
            header("location: verification?completed=verification&cat=UGVuZGluZyBWZXJpZmljYXRpb24=");
            exit;
        }
        // If stage is  Completed Verification


        // If stage is  Assessment
        if ($stage == 'Assessment') {
            $firstname = get_val('jobs_applied', 'id', $id[$i], 'firstname');
            $lastname =  get_val('jobs_applied', 'id', $id[$i], 'lastname');
            $email =  get_val('jobs_applied', 'id', $id[$i], 'email');
            $phone =  get_val('jobs_applied', 'id', $id[$i], 'phone');
            $candidate_id =  get_val('jobs_applied', 'id', $id[$i], 'candidate_id');
            $job_id =  get_val('jobs_applied', 'id', $id[$i], 'job_id');
            $job_title =  get_val('jobs_applied', 'id', $id[$i], 'job_title');

            $test_code = test_code($email, $candidate_id);


            $body_msg = get_val('message_template', 'template_name', $stage, 'message');
            $sms = get_val('message_template', 'template_name', 'Assessment', 'sms_content');


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
            $sms_content = $sms5;



            if (check_assessment($job_title) == 'confirm') {
                $sql = "insert into participant set candidate_id = '$candidate_id',job_applied_id = '" . $id[$i] . "',firstname = '$firstname', lastname = '$lastname', email = '$email', phone = '$phone', job_id = '$job_id', job_title = '$job_title', exam_code = '$test_code', expire_date = '" . test_expiration() . "'";
                $result_sql = mysqli_query($db, $sql);
            } else {
                header("Location: applicants?error=Error moving candidate(s). There is no assessment for $job_title&cat=" . $_GET['cat']);
                exit;
            }


            //Write sned details for candidates to participants table for assessment.



            $final_message = str_replace('{firstname}', $candidate_name, $mail_content);

            $email = get_val('jobs_applied', 'id', $id[$i], 'email');
            $phone = get_val('jobs_applied', 'id', $id[$i], 'phone');

            mail_candidate($email, get_stage_subject($stage), $final_message);
            send_sms($phone, $sms_content);
        } else {
            // If this stage is not assessment.

            $firstname = get_val('jobs_applied', 'id', $id[$i], 'firstname');
            $lastname =  get_val('jobs_applied', 'id', $id[$i], 'lastname');
            $email =  get_val('jobs_applied', 'id', $id[$i], 'email');
            $phone =  get_val('jobs_applied', 'id', $id[$i], 'phone');
            $candidate_id =  get_val('jobs_applied', 'id', $id[$i], 'candidate_id');
            $job_id =  get_val('jobs_applied', 'id', $id[$i], 'job_id');
            $job_title =  get_val('jobs_applied', 'id', $id[$i], 'job_title');


            $body_msg = get_val('message_template', 'template_name', $stage, 'message');

            $message1 = str_replace('{firstname}', $firstname, $body_msg);
            $message2 = str_replace('{lastname}', $lastname, $message1);
            $message3 = str_replace('{email}', $email, $message2);

            $sms1 = str_replace('{firstname}', $firstname, $sms);
            $sms2 = str_replace('{lastname}', $lastname, $sms1);
            $sms3 = str_replace('{email}', $email, $sms2);

            $mail_content = $message3;
            $final_message = str_replace('{firstname}', $candidate_name, $mail_content);
            $email = get_val('jobs_applied', 'id', $id[$i], 'email');
            mail_candidate($email, get_stage_subject($stage), $final_message);

            $msg = 'Hello ' . get_val('jobs_applied', 'id', $id[$i], 'firstname') . ' you have  been moved to ' . $stage . '';

            $query3 = "insert into notification set candidate_id = '" . get_val('jobs_applied', 'id', $id[$i], 'candidate_id') . "', notifier = 'Admin', message = '$msg', status = 'Unread', date = '$date'";
            $result2 =  mysqli_query($db, $query3);
        }


        //    echo $query = sprintf("UPDATE jobs_applied set status = '$stage', date_modified = '".today()."' WHERE id IN ('%s')", implode("','",$id)); exit; 

        $query = "update jobs_applied set status = '$stage', date_modified = '" . today() . "' where id = '$id[$i]'";
        $result = mysqli_query($db, $query);
        if ($result) {
            $user_id = get_val('jobs_applied', 'id', $id[$i], 'candidate_id');
            $user = get_val('jobs_applied', 'id', $id[$i], 'id');

            $candidate_name = get_val('jobs_applied', 'id', $id[$i], 'firstname') . ' ' . get_val('jobs_applied', 'id', $id[$i], 'lastname');
            activity_log($_SESSION['Klin_admin_user'], 'Moved ' . $candidate_name . ' to ' . $stage);


            //if applicant is retruned back to application pool
            if ($stage == 'Applied') {
                application_log(get_val('jobs_applied', 'id', $id[$i], 'candidate_id'), get_val('jobs_applied', 'id', $id[$i], 'job_id'), 'Returned to pool');

                $candidate_id = get_val('jobs_applied', 'id', $id[$i], 'candidate_id');
                $job_id = get_val('jobs_applied', 'id', $id[$i], 'job_id');
                include('comment-box.php');
                exit;
            } else {


                application_log(get_val('jobs_applied', 'id', $id[$i], 'candidate_id'), get_val('jobs_applied', 'id', $id[$i], 'job_id'), 'Moved to ' . $stage);
            }
        }
    }

    //If applicants are moved to second level interview. Export and mail details to admin
    if ($stage == 'Second Level Interview') {
        export_to_recruiter($_POST['id']);
    }



    header("Location: applicants?cat=" . $_GET['cat']);
    // header("location: assign_client?valid=".base64_encode($user_id)."&cat=".$_GET['cat']);

}


//if export selected is linked from the applicants page


$candidate_id = $_POST['candidate_id'];


$array_id = $_POST['id'];


if ($_POST['btn_download']) {
    if (!$array_id) {
        header("Location: applicants?error=You need to select candidates to download their CVs&cat=" . $_GET['cat']);
        exit;
    }

    include('download-cv.php');
    exit;
}

include('export-applicants.php');
exit;