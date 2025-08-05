<?php
ob_start();
session_start();
include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
require_once('outsourcehr-admin/PHPMailer/PHPMailerAutoload.php');

$firstname = htmlspecialchars($_POST['firstname'], ENT_QUOTES, 'UTF-8');
$lastname = htmlspecialchars($_POST['lastname'], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
$phone = htmlspecialchars($_POST['phone'], ENT_QUOTES, 'UTF-8');
$password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
$hear_about = htmlspecialchars($_POST['hear_about'], ENT_QUOTES, 'UTF-8');
$fullname = $firstname . ' ' . $lastname;

$date = date('Y-m-d');

$now = date('U');

if ($firstname == '') {
    $error = "Firstname is required";
    include('signup.php');
    exit;
}

if ($lastname == '') {
    $error = "Lastname is required";
    include('signup.php');
    exit;
}

if ($email == '') {
    $error = "Email is required";
    include('signup.php');
    exit;
}

if ($password == '') {
    $error = "Password is required";
    include('signup.php');
    exit;
}

if ($hear_about == '') {
    $error = "How did you get to know us is required";
    include('signup.php');
    exit;
}

if ($phone == '') {
    $error = "Phone is required";
    include('signup.php');
    exit;
}

$email = filter_var($_POST["email"]);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format";
    include('signup.php');
    exit;
}

if (strlen($password) < 6) {
    $error = "Password cannot be less than 6 characters";
    include('signup.php');
    exit;
}

$sql = "select * from jobseeker_signup where email = '$email'";
$result_1 = mysqli_query($db, $sql);
$exist = mysqli_fetch_assoc($result_1);

if ($exist['email'] == $email) {
    $error = "This email has already been registered";
    include('signup.php');
    exit;
}

// echo
$query = "insert into jobseeker_signup set firstname = '$firstname', lastname = '$lastname',fullname = '$fullname', email = '$email', password = md5('$password'), hear_about = '$hear_about', phone = '$phone', status = '$now'";
// exit;
$result = mysqli_query($db, $query);
if ($result) {
    $candidate_id = mysqli_insert_id($db);


    $msg = 'Welcome to Jobrole ' . $firstname . ', <br><br>We are a Talent Management Company that offers innovative talent and business solutions to drive performance and acceleration. Our focus is to develop and create job opportunities for everyone in Nigeria';

    $query3 = "insert into notification set candidate_id = '$candidate_id', notifier = 'Admin', message = '$msg', status = 'Unread', date = '$date'";
    $result2 =  mysqli_query($db, $query3);


    $query2 = "insert into jobseeker set candidate_id = '$candidate_id', firstname = '$firstname', lastname = '$lastname', email = '$email',  phone = '$phone', status = '$now', country = '$country', date_reg = '" . today() . "'";
    $result = mysqli_query($db, $query2);


    $message = 'Please click <b><a href="' . root() . '/confirm-account?auth=' . $now . '&cem=' . base64_encode($email) . '">ACTIVATE NOW</a></b> to confirm your account. Or copy and paste the URL below to your browser<br><br>' . root() . '/confirm-account?auth=' . $now . '&cem=' . base64_encode($email);

    send_email($email, $firstname, organisation(), 'Account Confirmation', $message);


    activity_log($email, 'Signed up');

    $firstname = $lastname = $email = $email_confirm = $password = $hear_about = $phone = '';

    $success = 'Your account has been created, kindly check your email for confirmation link.';
    include('signup.php');
    //  header("Location: login");
    exit;
} else {
    $error = 'Your account was not created, kindly check if all information were correctly entered';
    include('signup.php');
    exit;
}
