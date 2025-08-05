<?php
ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');
if (!$_SESSION['account_token']) {    
    validatePermission('General Setting');
}
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}



$firstname = mysqli_real_escape_string($db, $_POST['firstname']);
$lastname = mysqli_real_escape_string($db, $_POST['lastname']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$phone = mysqli_real_escape_string($db, $_POST['phone']);
$client = implode(',', $_POST['client']);
$privilege = implode(',', $_POST['privilege']);
$url = get_val('login', 'account_token', $_SESSION['account_token'], 'url');
$account_token = $_SESSION['account_token'] ? 'account_token = "' . $_SESSION['account_token'] . '"' : 'account_token IS NULL ';

$date = date('Y-m-d g:i:s A');

if ($firstname == '') {
    $error = "Firstname is required";
    include('user.php');
    exit;
}

if ($lastname == '') {
    $error = "Lastname is required";
    include('user.php');
    exit;
}

if ($email == '') {
    $error = "Email is required";
    include('user.php');
    exit;
}

if ($phone == '') {
    $error = "Phone is required";
    include('user.php');
    exit;
}

if ($client == '') {
    $error = "Client is required";
    include('user.php');
    exit;
}

if ($privilege == 'Select Privilege') {
    $error = "Privilege is required";
    include('user.php');
    exit;
}

$sql = "select * from login where username = '$email'";
$result_1 = mysqli_query($db, $sql);
$exist = mysqli_fetch_array($result_1);
if ($exist['username'] == $email) {
    $error = "Sorry this user already exist";
    include('user.php');
    exit;
}

$code = rand(1000, 600);
$char = array('' . substr($firstname, 0, 2));
$a_char = strtoupper($char[0]);
$onboarding_code = $a_char . $code;

$pass = password_hash($onboarding_code, PASSWORD_BCRYPT);

$query = "insert into login set firstname = '$firstname', lastname = '$lastname', url = '$url', $account_token, email = '$email', phone = '$phone', username = '$email', password = '$pass', privilege = '$privilege', client = '$client' ";
$result = mysqli_query($db, $query);
if ($result) {
    $username =  $_SESSION['Klin_admin_user'];

    $query1 = "select * from login where username = '$username'";
    $result1 = mysqli_query($db, $query1);
    $row1 = mysqli_fetch_array($result1);
    $name =  ucfirst($row1['firstname']) . ' ' . ucfirst($row1['lastname']);

    $message = 'Your account has successfully been created. Your username is <b>' . $email . '</b> and your password is <b>' . $onboarding_code . '</b>. Kindly use this link <b> <a href="' . host() . '/admin"> ADMIN </a> </b> to access the admin backend ';

    send_email($email, $firstname, organisation(), 'Hr Application Account Information', $message);

    activity_log($_SESSION['Klin_admin_user'], "Added a new user $firstname");
    
    $success = "User successfully created";
    include('user.php');
    exit;
} else {
    $error = "User was not created, check if all information were correctly entered";
    include('user.php');
    exit;
}
