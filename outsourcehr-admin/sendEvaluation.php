<?php
ob_start();
session_start();
include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}


$question = mysqli_real_escape_string($db, $_POST['question']);
$deadline = mysqli_real_escape_string($db, $_POST['date']);

if ($_POST['staff']) {
    $IDPanel = implode(' | ', $_POST['staff']);
    $countID = explode(' | ', $IDPanel);
    for ($e = 0; $e < count($countID); $e++) {

        $email = get_value('employees', 'staff_id', 'email', $countID[$e]);
        $first = get_value('employees', 'staff_id', 'firstname', $countID[$e]);

        $subject = "Evaluation Questionnaire";
        // $from_email = "noreply@".domainName()."";

        $message = 'Hello ' . $first . ',<br><br>
We hope this email meets you well. <br><br>
You have been sent an Evaluation Questionnaire to test your skill level on ' . $question . '<br><br>
Thank you.';
        $heading = "Questionnaire";

        // send_email($email, $subject, $heading, $message, $from_email, $first);

        mysqli_query($db, "insert into evaluation set staff = '$email', question = '$question', deadline = '$deadline'");
    }
}

if ($_POST['department']) {
    $deptPanel = implode(' | ', $_POST['department']);
    $countDept = explode(' | ', $deptPanel);
    for ($d = 0; $d < count($countDept); $d++) {

        $qs = mysqli_query($db, "select * from employees where department = '{$countDept[$d]}'");
        $ns = mysqli_num_rows($qs);
        if ($ns > 0) {
            for ($p = 0; $p < $ns; $p++) {
                $rs = mysqli_fetch_assoc($qs);
                $email = $rs['email'];
                $first = $rs['firstname'];

                $subject = "Evaluation Questionnaire";
                // $from_email = "noreply@".domainName()."";

                $message = 'Hello ' . $first . ',<br><br>
We hope this email meets you well. <br><br>
You have been sent an Evaluation Questionnaire to test your skill level on ' . $question . '<br><br>
Thank you.';
                $heading = "Questionnaire";

                // send_email($email, $subject, $heading, $message, $from_email, $first);

                mysqli_query($db, "insert into evaluation set staff = '$email', question = '$question', deadline = '$deadline'");
            }
        }
    }
}


header('Location: evaluation?sent=1');
exit;
