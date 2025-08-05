<?php
ob_start();
session_start();
include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}


$skill = mysqli_real_escape_string($db, $_POST['skill']);
$course = mysqli_real_escape_string($db, $_POST['course']);
$fac = mysqli_real_escape_string($db, $_POST['fac']);
$date = mysqli_real_escape_string($db, $_POST['date']);
$level = mysqli_real_escape_string($db, get_value('course', 'course', 'level', $_POST['course']));
$tDate = $_POST['date'];
$date = date('Y-m-d');
$status = 'approved';

if ($_POST['staff']) {
    $IDPanel = implode(' | ', $_POST['staff']);
    $countID = explode(' | ', $IDPanel);
    for ($e = 0; $e < count($countID); $e++) {

        $staff_id = $countID[$e];
        $email = get_value('employees', 'staff_id', 'email', $countID[$e]);
        $first = get_value('employees', 'staff_id', 'firstname', $countID[$e]);
        $name = get_value('employees', 'staff_id', 'firstname', $countID[$e]) . " " . get_value('employees', 'staff_id', 'lastname', $countID[$e]);

        $subject = "Schedule for training";
        // $from_email = "noreply@".domainName()."";

        $message = 'Hello ' . $first . ',<br><br>
We hope this email meets you well. <br><br>
You have been scheduled for a training<br><br>
Thank you.';
        $heading = "Training";

        // send_mail($email, $subject, $heading, $message, $from_email, $first);

        mysqli_query($db, "insert into training set staff = '" . $staff_id . "', name = '" . $name . "', skill = '" . $skill . "', course = '" . $course . "', level = '" . $level . "', fac = '$fac', tDate = '$tDate', status = '$status', date = '" . $date . "'");
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
                $name = $rs['firstname'] . " " . $rs['lastname'];
                $staff_id = $rs['staff_id'];

                $subject = "Scheduled for training";
                // $from_email = "noreply@".domainName()."";

                $message = 'Hello ' . $first . ',<br><br>
We hope this email meets you well. <br><br>
You have been scheduled for a training<br><br>
Thank you.';
                $heading = "Training";

                // send_mail($email, $subject, $heading, $message, $from_email, $first);

                mysqli_query($db, "insert into training set staff = '" . $staff_id . "', name = '" . $name . "', skill = '" . $skill . "', course = '" . $course . "', level = '" . $level . "', fac = '$fac', tDate = '$tDate', status = '$status', date = '" . $date . "'");
            }
        }
    }
}


header('Location: schedule-training?sent=1');
exit;
