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

$candidate_id = mysqli_real_escape_string($db, $_POST['candidate_id']);
$comment = mysqli_real_escape_string($db, $_POST['comment']);



if ($_GET['pool_id']) {
    $pool_id = base64_decode($_GET['pool_id']);

    application_log(get_val('emp_staff_details', 'candidate_id', $pool_id, 'candidate_id'), get_val('jobs_applied', 'candidate_id', $pool_id, 'job_id'), 'Moved  to Pool ', 'Pool');

    $msg = 'Hello ' . get_val('emp_staff_details', 'candidate_id', $pool_id, 'firstname') . ' you have successfully been moved to Pool';

    $query3 = "insert into notification set candidate_id = '" . get_val('emp_staff_details', 'candidate_id', $pool_id, 'candidate_id') . "', notifier = 'Admin', message = '$msg', status = 'Unread', date = '" . today() . "'";
    $result2 =  mysqli_query($db, $query3);

    // $msgs = 'A new candidate has ben moved to Deploy Candidate';

    // send_email(get_val('notification_email', 'privilege', 'Deploy Candidate', 'email'), 'Deploy Candidate Dept', organisation(), 'Verification Stage', $msgs);

    activity_log($_SESSION['Klin_admin_user'], 'Moved ' . get_val('emp_staff_details', 'candidate_id', $pool_id, 'firstname') . ' ' . get_val('emp_staff_details', 'candidate_id', $pool_id, 'surname') . ' to Pool');

    $pool_query = "update emp_staff_details set completed = 'Pool' where candidate_id = '$pool_id'";
    $pool_result = mysqli_query($db, $pool_query);
    if ($pool_result) {
        header('location: verification?pool=completed&cat=Q29tcGxldGVkIFZlcmlmaWNhdGlvbg==');
        exit;
    }
}


if (isset($_POST['send_comment'])) {
    $candidate_id = base64_decode($_POST['candidate_id']);

    $comment_query = "update emp_staff_details set completed = 'N' where candidate_id = '$candidate_id'";
    $comment_result = mysqli_query($db, $comment_query);

    $comment_query1 = "update jobs_applied set status = 'Onboarding' where candidate_id = '$candidate_id'";
    $comment_result1 = mysqli_query($db, $comment_query1);


    $comment_result = mysqli_query($db, "select * from emp_staff_details where candidate_id = '$candidate_id'");
    $comment_row = mysqli_fetch_array($comment_result);
    if ($comment_result) {

        $message = $comment;
        $subject = mysqli_real_escape_string($db, $_POST['subject']);

        activity_log($_SESSION['Klin_admin_user'], 'Moved ' . get_val('emp_staff_details', 'candidate_id', $candidate_id, 'firstname') . ' ' . get_val('emp_staff_details', 'candidate_id', $candidate_id, 'surname') . ' to ' . 'Pending Onboarding');

        send_email(get_val('emp_staff_details', 'candidate_id', $candidate_id, 'email_address'), get_val('emp_staff_details', 'candidate_id', $candidate_id, 'firstname'), organisation(), $subject, $message);

        send_email($_SESSION['Klin_admin_email'], get_val('emp_staff_details', 'candidate_id', $candidate_id, 'firstname'), organisation(), $subject, $message);
    }
    header('location: onboarding-user?reversed=success');
    exit;
}


$evidence = $_POST['evidence'];
$upload_evidence = $_POST['upload_evidence'];


if (isset($_POST['verify'])) {
    if ($evidence == 'select_document') {
        $error = "Document not selected";
        include('upload_evidence.php');
        exit;
    }

    $row_query = "select * from verified_document where candidate_id = '$candidate_id' ";
    $row_result = mysqli_query($db, $row_query);
    $num_row = mysqli_num_rows($row_result);

    for ($i = 0; $i < $num_row; $i++) {
        $row = mysqli_fetch_array($row_result);

        if ($row['document_name'] == $evidence) {
            $error = "You cannot upload another evidence of $evidence file, kindly delete the previous one and reupload";
            include('upload_evidence.php');
            exit;
        }
    }
    $format_id = str_replace('/','_',$candidate_id);
    $file_loc = $_FILES['upload_evidence']['tmp_name'];
    $verify_address = $format_id . '_' . $_FILES['upload_evidence']['name'];
    $file_size = $_FILES['upload_evidence']['size'];
    $file_type = $_FILES['upload_evidence']['type'];
    $folder = UPLOAD_DIR."verified_documents/";

    $doc_size = $file_size / 1024;

    $file_name = strtolower($verify_address);

    $file_ext = strtolower(pathinfo($verify_address, PATHINFO_EXTENSION));

    if ($verify_address == '') {
        $error = "$evidence file is required ";
        include('upload_evidence.php');
        exit;
    }

    if ($doc_size > 1550) {
        $error = 'Sorry, your address file is too large, the required file size is 1.5mb below ';
        include('upload_evidence.php');
        exit;
    }


    if ($file_ext == 'pdf' || $file_ext == 'PDF' || $file_ext == 'docx' || $file_ext == 'DOCX' || $file_ext == 'doc' || $file_ext == 'DOC' || $file_ext == 'jpg' || $file_ext == 'JPG' || $file_ext == 'png' || $file_ext == 'PNG' || $file_ext == 'jpeg' || $file_ext == 'JPEG') {
        $verify_address = str_replace(' ', ' ', $file_name);

        move_uploaded_file($file_loc, $folder . $verify_address);
    } else {
        $error = 'Please reupload your address file, the ony accepted file format is  pdf, PDF, JPG, jpg, PNG, png, JPEG, jpeg, doc, DOC, DOCX, docx';
        include('upload_evidence.php');
        exit;
    }

    $query = "insert into verified_document set document_name = '$evidence', candidate_id = '$candidate_id', filepath = '$verify_address'";
    $result = mysqli_query($db, $query);
    if ($result) {
        $stage_query3 = "update emp_staff_details set date_upload = '" . date('Y-m-d H:i:s') . "'  where candidate_id = '$candidate_id' ";
        $stage_result3 = mysqli_query($db, $stage_query3);

        activity_log($_SESSION['Klin_admin_user'], 'Uploaded ' . get_val('emp_staff_details', 'candidate_id', $candidate_id, 'firstname') . ' ' . get_val('emp_staff_details', 'candidate_id', $candidate_id, 'surname') . '  ' . 'Evidence Of ' . $evidence);

        if ($evidence == 'Guarantor 1') {
            $up_query = "update emp_staff_details set 1st_guarantor_status = 'verified'  where candidate_id = '$candidate_id'";
            $up_result = mysqli_query($db, $up_query);
        }

        if ($evidence == 'Guarantor 2') {
            $up_query = "update emp_staff_details set 2nd_guarantor_status = 'verified'  where candidate_id = '$candidate_id'";
            $up_result = mysqli_query($db, $up_query);
        }

        $success = "Evidence Of $evidence has been uploaded successfully";
        include('upload_evidence.php');
        exit;
    }

    // $upload_success[] = "Academics file uploaded";
    // $upload_success[] = "Guarantor 1 file uploaded";
    // $array_uploaded = implode('<br>',$upload_success);
    // $success = 'Upload Successful <br> '.$array_uploaded;
} else {
    header('location: index');
    exit;
}