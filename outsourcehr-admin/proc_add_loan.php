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

$name = mysqli_real_escape_string($db, $_POST['name']);
$type = mysqli_real_escape_string($db, $_POST['type']);
$per_month = mysqli_real_escape_string($db, $_POST['per_month']);
$duration = mysqli_real_escape_string($db, $_POST['duration']);
$amount = mysqli_real_escape_string($db, $_POST['amount']);

$names = explode(' ', $name); // Split the string into an array of words
$firstname = $names[0];
$lastname = $names[1];

$currentDate = new DateTime(); // Current date and time
$currentDate->add(new DateInterval('P' . $duration . 'M')); // Add 2 months

$expiration = $currentDate->format('Y-m-d'); // Format the new date
$date_approved = date("Y-m-d");



$staff_id = get_val2('employees', 'firstname', $firstname, 'lastname', $lastname, 'staff_id');
$month = date("M");
$year = date("Y");
$query = "insert into loans set first = '$firstname',last = '$lastname', staff_id ='$staff_id', duration = '$duration', per_month = '$per_month', amount = '$amount', loan_type = '$type', current_month = '$month', current_year = '$year', status = 'approved',expiration = '$expiration', date_approved = '$date_approved'";
$result = mysqli_query($db, $query);

if ($query) {
    header("Location: loan-application?success=1");
} else {
    header("Location: loan-application?error=1");
}
