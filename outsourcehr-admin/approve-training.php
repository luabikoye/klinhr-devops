<?php
ob_start();
session_start();
include('connection/connect.php');
require_once('inc/fns.php');
require_once('../outsourcehr-admin/PHPMailer/PHPMailerAutoload.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}


$id = $_POST['id'];
echo $staff_id = $_POST['staff_id'];
exit;
$fac = mysqli_real_escape_string($db, $_POST['fac']);
$tDate = $_POST['date'];
$name = mysqli_real_escape_string($db, $_POST['name']);
$skill = mysqli_real_escape_string($db, $_POST['skill']);
$course = mysqli_real_escape_string($db, $_POST['course']);
$level = mysqli_real_escape_string($db, $_POST['level']);
$bname = explode(' ', $name);
$first = $bname[0];
$email = get_value('employees', 'staff_id', 'email', $staff_id);
$date = date('Y-m-d');
$status = 'approved';

$subject = "Scheduled for Training";
// $from_email = "noreply@".domainName()."";

$message = 'We hope this email meets you well. <br><br>
You have been scheduled for a training<br><br>
Thank you.';
// $heading = "Training";

$query = mysqli_query($db, "update apply_training set fac = '$fac', tdate = '$tDate', status = '$status' where id = '$id'");
if ($query) {

    $result = mysqli_query($db, "insert into training set staff = '" . $staff_id . "', name = '" . $name . "', skill = '" . $skill . "', course = '" . $course . "', level = '" . $level . "', fac = '$fac', tDate = '$tDate', status = '$status', date = '" . $date . "'");

    if ($result) {

        echo send_email($email, $first, organisation(), $subject, $message);

        header("Location: scheduled-training?success=1");
    } else {

        header("Location: scheduled-training?error=1");
    }
} else {

    header("Location: scheduled-training?error=1");
}
