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
$account_token = $_SESSION['account_token'] ? 'account_token = "' . $_SESSION['account_token'] . '"' : 'account_token IS NULL ';

validatePermission('Assessment');
if (isset($_POST["upload"])) {

  $files = $_FILES['file']['name'];
  $file_loc = $_FILES['file']['tmp_name'];
  $file_size = $_FILES['file']['size'];
  $file_type = $_FILES['file']['type'];

  $file_ext = strtolower(pathinfo($files, PATHINFO_EXTENSION));

  if ($files == '') {
    $error1 = "File is required ";
    include('onboard-staff.php');
    exit;
  }


  if ($file_ext != 'csv') {
    $error1 = "File is not a csv format";
    include('onboard-staff.php');
    exit;
  }

  $file = $_FILES['file']['tmp_name'];
  $handle = fopen($file, "r");
  $c = 1;


  while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {

    $firstname = $filesop[1];
    $lastname = $filesop[2];
    $email = $filesop[3];
    $onboarding_code = rand(111111, 999999);
    $client = $filesop[4];


    $query = "insert into emp_staff_details set onboarding_code = '$onboarding_code', date = '" . date('Y-m-d') . "',  surname = '$lastname', firstname = '$firstname', company_code = '$client', email_address = '$email', completed = 'N', $account_token ";
    $result = mysqli_query($db, $query);

    if ($result) {

      $last_id = mysqli_insert_id($db);
      $cand_id = 'O' . $last_id;
      mysqli_query($db, "update emp_staff_details set candidate_id = '$cand_id' where id  = '$last_id'");
      $message = 'You have successfully been moved to onboarding. Please use this code <b>' .        $onboarding_code . '</b> for your onboarding and click <b> <a href="' . host() . '/onboarding"> ONBOARDING </a> </b> to complete your onboarding ';

      send_email($email, $firstname, organisation(), 'Onboarding Stage', $message);
    }

    $c = $c + 1;
  }

  if ($query) {

    activity_log($_SESSION['Klin_admin_email'], "Bulk uploaded candidates");

    $check = "delete from emp_staff_details where firstname = 'firstname' or lastname = 'lastname'; or email_address = 'email' or email_address = 'email address'";
    $result = mysqli_query($db, $check);
    $success1 = "File has been successfully imported";
    include('onboard-staff.php');
    exit;
  } else {
    $error1 = "File couldn't be imported";
    include('bulk_upload.php');
    exit;
  }
}
