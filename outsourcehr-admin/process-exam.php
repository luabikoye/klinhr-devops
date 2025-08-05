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


if ($_POST['btn_move']) {
    $id = $_POST['id'];
    $stage = $_POST['stage'];



    if (!$_POST['id']) {
        header("Location: view-score?id=required&cat=" . $_GET['cat']);
        exit;
    }

    $count = count($id);

    for ($i = 0; $i < $count; $i++) {

        $query = "update jobs_applied set status = '$stage' where id = '" . $id[$i] . "'";
        $result = mysqli_query($db, $query);
        if ($result) {
            $candidate_name = get_val('jobs_applied', 'id', $id[$i], 'firstname') . ' ' . get_val('jobs_applied', 'id', $id[$i], 'lastname');
            activity_log($_SESSION['Klin_admin_user'], 'Moved ' . $candidate_name . ' to ' . $stage);


            application_log(get_val('jobs_applied', 'id', $id[$i], 'candidate_id'), get_val('jobs_applied', 'id', $id[$i], 'job_id'), 'Moved to ' . $stage);
        }

        $mail_content = get_val('message_template', 'template_name', $stage, 'message');

        $final_message = str_replace('{firstname}', $candidate_name, $mail_content);

        $email = get_val('jobs_applied', 'id', $id[$i], 'email');

        // mail_candidate($email, get_stage_subject($stage), $final_message);

        //update candidate record to archieved

        $query = "update exam_result set archieved = 'yes' where job_applied_id = '" . $id[$i] . "'";
        $result = mysqli_query($db, $query);
    }


    header("Location: view-score?cat=" . $_GET['cat']);
}

if ($_POST['btn_delete']) {

    $id = $_POST['id'];


    if (!$_POST['id']) {
        header("Location: view-score?id=required&cat=" . $_GET['cat']);
        exit;
    }

    $count = count($id);

    for ($i = 0; $i < $count; $i++) {

        $query = "delete from exam_result where job_applied_id = '" . $id[$i] . "'";
        $result = mysqli_query($db, $query);
    }

    header("Location: view-score?success=Records have been deleted");
    exit;
}


//if export selected is linked from the applicants page

$array_id = $_POST['id'];

include('export-results.php');
exit;
