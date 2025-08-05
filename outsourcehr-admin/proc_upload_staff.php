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

validatePermission('Hr Operations');


if (isset($_POST["btn_add_staff"])) {
  $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $client = mysqli_real_escape_string($db, $_POST['client']);
  $staff_id = mysqli_real_escape_string($db, $_POST['staff_id']);
  $phone_number = mysqli_real_escape_string($db, $_POST['phone_number']);
  $names = $lastname . ' ' . $firstname;

  $onboarding_code = rand(111111, 999999);

  if ($firstname == '') {
    $error = "Firstname is required";
    include('staff-mgt.php');
    exit;
  }

  if ($lastname == '') {
    $error = "Lastname is required";
    include('staff-mgt.php');
    exit;
  }

  if ($email == '') {
    $error = "Email is required";
    include('staff-mgt.php');
    exit;
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format";
    include('staff-mgt.php');
    exit;
  }

  if ($staff_id == '') {
    $error = "Staff Id is required";
    include('staff-mgt.php');
    exit;
  }

  if ($phone_number == '') {
    $error = "Phone number is required";
    include('staff-mgt.php');
    exit;
  }

  if ($client == '') {
    $error = "Client is required";
    include('staff-mgt.php');
    exit;
  }

  $check_query = "select * from emp_staff_details where staff_id = '$staff_id' && email_address = '$email'";
  $check_result = mysqli_query($db, $check_query);
  $row = mysqli_fetch_array($check_result);
  if ($row['staff_id'] == $staff_id) {

    $error = "Staff already exist";
    include('staff-mgt.php');
    exit;
  }

  $check_query1 = "select * from emp_self_login where staff_id = '$staff_id' && email = '$email' ";
  $check_result1 = mysqli_query($db, $check_query1);
  $row1 = mysqli_fetch_array($check_result1);
  if ($row1['staff_id'] == $staff_id) {

    $error = "Staff already exist";
    include('staff-mgt.php');
    exit;
  }
  $check_query2 = "select * from emp_leave_planner where staff_id = '$staff_id'";
  $check_result2 = mysqli_query($db, $check_query2);
  $row2 = mysqli_fetch_array($check_result2);
  if ($row2['staff_id'] == $staff_id) {

    $error = "Staff already exist";
    include('staff-mgt.php');
    exit;
  }

  $staff_query = "insert into emp_staff_details set EmployeeID = '$staff_id', staff_id = '$staff_id', onboarding_code = '$onboarding_code', candidate_id = '$staff_id', date = '" . date('Y-m-d') . "',  surname = '$lastname', firstname = '$firstname',  email_address = '$email', mobile_phone_number = '$phone_number', company_code = '" . get_val('clients', 'client_name', $client, 'client_code') . "', completed = 'N', backlog = 'yes', staff = 'yes' ";


  $staff_result = mysqli_query($db, $staff_query);


  $staff_query_1 = "insert into emp_self_login set user = '$staff_id', pass = '$staff_id', staff_id = '$staff_id', names = '$names', email = '$email', phone = '$phone_number', client_code = '" . get_val('clients', 'client_name', $client, 'client_code') . "', user_type = 'user' ";
  $staff_result_1 = mysqli_query($db, $staff_query_1);

  $staff_query_2 = "insert into emp_leave_planner set staff_id = '$staff_id', total_days = '20', scheduled_days = '0', last_year_days = '0', outstanding_days = '20', current_year = '" . date('Y') . "' ";
  $staff_result_2 = mysqli_query($db, $staff_query_2);


  $message = 'You have been added into Kennedia\'s Employee Service Portal. Below is your login details. Please note that you will be required to fully complete/update your onboarding information before you can proceed to use this platform<br><br>URL: <a href="' . staff_portal() . '">' . staff_portal() . '</a><br><br>Username: ' . $staff_id . '<br>Password: ' . $staff_id . '<br>';
  // send_email($email,$names,sender_name(),'Employee Login Details',$message);

  if ($staff_result) {
    $success = "Staff successfully added";
    include('staff-mgt.php');
    exit;
  } else {
    $error = "Staff already exist";
    include('staff-mgt.php');
    exit;
  }
}


if (isset($_POST["upload"])) {

  $client = mysqli_real_escape_string($db, $_POST['client']);

  if ($client == '') {
    $error = "Kindly select a client";
    include('staff-mgt.php');
    exit;
  }

  //deletes the header
  $sql = "delete from emp_self_login where user = 'staff_id' or email = 'email_address'";
  $result = mysqli_query($db, $sql);

  $sql_1 = "delete from emp_leave_planner where staff_id = 'staff_id'";
  $result_1 = mysqli_query($db, $sql_1);

  $sql_2 = "delete from emp_staff_details where staff_id = 'staff_id' or email_address = 'email_address'";
  $result_2 = mysqli_query($db, $sql_2);



  $file = $_FILES['file']['tmp_name'];
  $handle = fopen($file, "r");
  $c = 0;
  while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {

    $staff_id = $filesop[1];
    $surname = $filesop[2];
    $firstname = $filesop[3];
    $middlename = $filesop[4];
    $sex = $filesop[5];
    $marital_status = $filesop[6];
    $date_of_birth = valid_date($filesop[7]);
    $date_employed = valid_date($filesop[8]);
    $location_code = $filesop[9];
    $state_origin = $filesop[10];
    $local_govt_of_origin_code = $filesop[11];
    $current_address_1 = $filesop[12];
    $email_address = $filesop[13];
    $phone_number = $filesop[14];
    $salary_band = $filesop[15];
    $names = $surname . ' ' . $firstname . ' ' . $middlename;

    if (!$email_address) {
      $email_address = $staff_id . '@' . 'noemail.com';
    }

    //check if record already exists
    $chk_result = mysqli_query($db, "select * from emp_self_login where staff_id = '$staff_id'");
    $chk_num  = mysqli_num_rows($chk_result);

    if ($chk_num == 0 && $staff_id != 'staff_id') {

      $query = "insert into emp_self_login set user = '$staff_id', pass = '$staff_id', staff_id = '$staff_id', names = '$names', email = '$email_address', phone = '$phone_number', client_code = '" . get_val('clients', 'client_name', $client, 'client_code') . "', user_type = 'user' ";

      $stmt = mysqli_prepare($db, $query);
      mysqli_stmt_execute($stmt);

      $query1 = "insert into emp_leave_planner set staff_id = '$staff_id', total_days = '20', scheduled_days = '0', last_year_days = '0', outstanding_days = '20', current_year = '" . date('Y') . "' ";
      $stmt2 = mysqli_prepare($db, $query1);
      mysqli_stmt_execute($stmt2);

      $query_2 = "insert into emp_staff_details set EmployeeID = '$staff_id', staff_id = '$staff_id', onboarding_code = '$onboarding_code', candidate_id = '$staff_id', date = '" . date('Y-m-d') . "',  surname = '$surname', firstname = '$firstname', middlename = '$middlename', sex = '$sex', marital_status = '$marital_status', date_of_birth = '$date_of_birth', date_employed = '$date_employed', company_code = '" . get_val('clients', 'client_name', $client, 'client_code') . "',  location_code = '$location_code', state_origin = '$state_origin', local_govt_of_origin_code = '$local_govt_of_origin_code', current_address_1 = '$current_address_1', email_address = '$email_address',  mobile_phone_number = '$phone_number', completed = 'N', backlog = 'yes', staff = 'yes', status = 'active', salary_band = '$salary_band'";

      //echo $query.'<br>'.$query1.'<br>'.$query_2.'<hr>';


      $message = 'You have been added into Klinhr\'s Employee Service Portal. Below is your login details. Please note that you will be required to fully complete/update your onboarding information before you can proceed to use this platform<br><br>URL: <a href="' . staff_portal() . '">' . staff_portal() . '</a><br><br>Username: ' . $staff_id . '<br>Password: ' . $staff_id . '<br>';
      //  send_email($email,$names,sender_name(),'Employee Login Details',$message);


      $stmt3 = mysqli_prepare($db, $query_2);
      mysqli_stmt_execute($stmt3);
    }

    $c = $c + 1;
  }

  if ($query) {
    //deletes the header
    $sql = "delete from emp_self_login where user = 'staff_id' or email = 'email_address'";
    $result = mysqli_query($db, $sql);

    $sql_1 = "delete from emp_leave_planner where staff_id = 'staff_id'";
    $result_1 = mysqli_query($db, $sql_1);

    $sql_2 = "delete from emp_staff_details where staff_id = 'staff_id' or email_address = 'email_address'";
    $result_2 = mysqli_query($db, $sql_2);

    $success = "File successfully imported";
    include('staff-mgt.php');
    exit;
  } else {
    $error = "File couldn't be imported";
    include('staff-mgt.php');
    exit;
  }
}
