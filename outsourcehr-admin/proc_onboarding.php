<?php

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');

$firstname = mysqli_real_escape_string($db, $_POST['firstname']);
$lastname = mysqli_real_escape_string($db, $_POST['lastname']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$client = mysqli_real_escape_string($db, $_POST['client']);
$onboarding_code = mysqli_real_escape_string($db, $_POST['onboarding_code']);
$account_token = $_SESSION['account_token'] ? 'account_token = "' . $_SESSION['account_token'] . '"' : 'account_token IS NULL ';


if(!$firstname || !$lastname || !$email || !$onboarding_code)
  {
        $error = 'All information required';
        include('onboarding-staff.php');
        exit;
  }

    $query = "insert into emp_staff_details set onboarding_code = '$onboarding_code', date = '".date('Y-m-d')."',  surname = '$lastname', firstname = '$firstname', company_code = '$client', email_address = '$email', completed = 'N', $account_token  ";
    $result = mysqli_query($db,$query);

if($result)
{
    $last_id = mysqli_insert_id($db);
    $cand_id = 'O'.$last_id;
    mysqli_query($db, "update emp_staff_details set candidate_id = '$cand_id' where id  = '$last_id'");

    $message = 'You have successfully been moved to onboarding. Please use this code <b>'.        $onboarding_code.'</b> for your onboarding and click <b> <a href="'.host().'/onboarding"> ONBOARDING </a> </b> to complete your onboarding ';
 
    send_email($email, $firstname, organisation(), 'Onboarding Stage', $message);

    header("Location: onboarding-user?cat=Tg==&added=$firstname");
    exit;
}
else
{
    $error = 'User already exists in the staff Database';
    include('onboard-staff.php');
    exit;
}


?>