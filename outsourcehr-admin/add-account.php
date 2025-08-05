<?php
ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');
validatePermission('General Setting');
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}



$username = mysqli_real_escape_string($db, $_POST['username']);
$company = mysqli_real_escape_string($db, $_POST['company']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$phone = mysqli_real_escape_string($db, $_POST['phone']);
$person = mysqli_real_escape_string($db, $_POST['person']);
$domain = mysqli_real_escape_string($db, $_POST['domain']);
$url = mysqli_real_escape_string($db, $_POST['url']);
$module = implode(',', $_POST['module']);
$token = token();

if ($username == '') {
    $error = "Username is required";
    include('sub-accounts.php');
    exit;
}

if ($company == '') {
    $error = "Company is required";
    include('sub-accounts.php');
    exit;
}

if ($email == '') {
    $error = "Email is required";
    include('sub-accounts.php');
    exit;
}

if ($phone == '') {
    $error = "Phone is required";
    include('sub-accounts.php');
    exit;
}

if ($person == '') {
    $error = "Person is required";
    include('sub-accounts.php');
    exit;
}

if ($module == 'Select Module') {
    $error = "Module is required";
    include('sub-accounts.php');
    exit;
}

$sql = "select * from login where username = '$email'";
$result_1 = mysqli_query($db, $sql);
$exist = mysqli_fetch_array($result_1);
if ($exist['username'] == $email) {
    $error = "Sorry this email already exist";
    include('sub-accounts.php');
    exit;
}

$code = rand(1000, 600);
$char = array('' . substr($username, 0, 2));
$a_char = strtoupper($char[0]);
$onboarding_code = $a_char . $code;

$pass = password_hash($onboarding_code, PASSWORD_BCRYPT);
$insert = mysqli_query($db,"insert into sub_account set username = '$username', person = '$person', email = '$email', phone = '$phone', company = '$company', modules = '$module', url = '$url', domain = '$domain', account_token = '$token'");
if ($insert) {

    $query = "insert into login set firstname = '$username', email = '$email', phone = '$phone', username = '$email', password = '$pass', privilege = '$module',client = ' ', account_token = '$token', url = '$url' ";
    $result = mysqli_query($db, $query);
    if ($result) {
        $username = $_SESSION['Klin_admin_sub-account'];

        $query1 = "select * from login where username = '$username'";
        $result1 = mysqli_query($db, $query1);
        $row1 = mysqli_fetch_array($result1);
        $name = ucfirst($row1['firstname']) . ' ' . ucfirst($row1['lastname']);

        $message = 'Your account has successfully been created. Your username is <b>' . $email . '</b> and your password is <b>' . $onboarding_code . '</b>. Kindly use this link <b> <a href="' . host() . '/admin"> ADMIN </a> </b> to access the admin backend ';

        send_email($email, $firstname, organisation(), 'Hr Application Account Information', $message);

        activity_log($_SESSION['Klin_admin_sub-account'], "Added a new sub-account $firstname");

        $success = "sub-account successfully created";
        include('sub-accounts.php');
        exit;
    } else {
        $error = "sub-account was not created, check if all information were correctly entered";
        include('sub-accounts.php');
        exit;
    }
} else {
    $error = "sub-account was not created, check if all information were correctly entered";
    include('sub-accounts.php');
    exit;
}
