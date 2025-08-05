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

$token = md5($_SESSION['Klin_admin_user'] . date('U'));


if (isset($_POST["upload"])) {

  $client = mysqli_real_escape_string($db, $_POST['client']);
  $date = mysqli_real_escape_string($db, $_POST['date']);

  if ($client == '') {
    $error = "Kindly select a client";
    include('payslip.php');
    exit;
  }

  //deletes the header
  // $sql = "delete from emp_self_payslip where user = 'staff_id' or email = 'email_address'";
  // $result = mysqli_query($db, $sql);

  // $sql_1 = "delete from emp_leave_planner where staff_id = 'staff_id' or email = 'email_address' ";
  // $result_1 = mysqli_query($db, $sql_1);

  // $sql_2 = "delete from emp_staff_details where staff_id = 'staff_id' or email = 'email_address'";
  // $result_2 = mysqli_query($db, $sql_2);



  $file = $_FILES['file']['tmp_name'];
  $handle = fopen($file, "r");
  $c = 0;
  while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {

    $staff_id = $filesop[1];
    $date = $date;
    $bank = $filesop[3];
    $account_no = $filesop[4];
    $names = $filesop[5];
    $basic = $filesop[6];
    $transportation = $filesop[7];
    $housing = $filesop[8];
    $lunch = $filesop[9];
    $health = $filesop[10];
    $dressing = $filesop[11];
    $furniture = $filesop[12];
    $leave = $filesop[13];
    $differential = $filesop[14];
    $n_month = $filesop[15];
    $reimbusable = $filesop[16];
    $utility = $filesop[17];
    $education = $filesop[18];
    $entertainment = $filesop[19];
    $cost_of_living = $filesop[20];
    $emp_contribution = $filesop[21];
    $xmas_bonus = $filesop[22];
    $gratuity = $filesop[23];
    $holiday = $filesop[24];
    $joining_bonus = $filesop[25];
    $location = $filesop[26];
    $telephone = $filesop[27];
    $domestic = $filesop[28];
    $overtime = $filesop[29];
    $arrears = $filesop[30];
    $nsitf = $filesop[31];
    $insurance = $filesop[32];
    $commission = $filesop[33];
    $passages = $filesop[34];
    $subsidy = $filesop[35];
    $tax = $filesop[36];
    $pension = $filesop[37];
    $loan = $filesop[38];
    $leave_allowance = $filesop[39];
    $n_month2 = $filesop[40];
    $nhf = $filesop[41];
    $medical = $filesop[42];
    $nubifie = $filesop[43];
    $city_ledger = $filesop[44];
    $dressing2 = $filesop[45];
    $holiday2 = $filesop[46];
    $emp_contribution_debt = $filesop[47];
    $salary_advance = $filesop[48];
    $total_deduction = $filesop[49];
    $net_pay = $filesop[50];
    $gross_pay = $filesop[51];





    $query = "insert into emp_self_payslip set token = '$token', staff_id = '$staff_id', client_code = '$client' , date = '$date', bank = '$bank', account_no = '$account_no', names = '$names', basic = '$basic', transportation = '$transportation', housing = '$housing' ,  lunch = '$lunch', health = '$health', dressing = '$dressing',furniture = '$furniture', emp_leave = '$leave' , differential = '$differential' , n_month = '$n_month' , reimbusable = '$reimbusable' , utility = '$utility' , education = '$education' , entertainment = '$entertainment' , cost_of_living = '$cost_of_living' , emp_contribution = '$emp_contribution' , xmas_bonus = '$xmas_bonus' , gratuity = '$gratuity' , holiday = '$holiday' , joining_bonus = '$joining_bonus' , location = '$location' , telephone = '$telephone' , domestic = '$domestic' , overtime = '$overtime' , arrears = '$arrears' , nsitf = '$nsitf' , insurance = '$insurance' , commission = '$commission' , passages = '$passages' , subsidy = '$subsidy' , tax = '$tax' , pension = '$pension' , loan = '$loan' , leave_allowance = '$leave_allowance' , n_month2 = '$n_month2' , nhf = '$nhf' , medical = '$medical' , nubifie = '$nubifie' , city_ledger = '$city_ledger' , dressing2 = '$dressing2' , holiday2 = '$holiday2' , emp_contribution_debt = '$emp_contribution_debt' , salary_advance = '$salary_advance' , total_deduction = '$total_deduction' , net_pay = '$net_pay' , gross_pay = '$gross_pay', uploaded_by = '" . $_SESSION['Klin_admin_user'] . "'";
    // echo $query;
    // $result = mysqli_query($db,$query);
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_execute($stmt);




    $c = $c + 1;
  }
  // exit;
  if ($query) {
    //deletes the header
    $sql = "delete from emp_self_payslip where staff_id = 'staff_id'";
    $result = mysqli_query($db, $sql);

    $success = "File successfully imported";
    include('payslip.php');
    exit;
  } else {
    $error = "File couldn't be imported";
    include('payslip.php');
    exit;
  }
}
