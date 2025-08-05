<?php

date_default_timezone_set("Africa/Lagos");

function show_img($image_name)
{
  if (file_exists($image_name)) {
    echo $image_name;
  }
}

function candidate_image($tab, $can_id)
{

  global $db;
  $select = "select * from $tab where candidate_id = '$can_id'";
  $result = mysqli_query($db, $select);
  $row = mysqli_fetch_array($result);
  return $row['passport'];
}

function VerificationStatus($candidate_id)
{
  global $db;

  $query = "select * from verified_document where candidate_id = '$candidate_id' || document_name  like '%Academics%'  and document_name like '%Guarantor 1%' and document_name like '%Guarantor 2%'  ";
  // $query = "select * from verified_document where candidate_id = '$candidate_id' || document_name  like '%Academics%'  and document_name like '%Guarantor 1%' and document_name like '%Guarantor 2%'  ";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  $row = mysqli_fetch_array($result);
  if ($num > 2) {
    return '<i style="color: green; font-size: 20px;" class="bi-check"> </i>';
  } else {
    return '<i style="color: red; font-size: 20px;" class="bi-x"> </i>';
  }
}

function SessionCheck()
{
  ob_start();
session_start();
  //   include('../connection/connect.php');
  if (!isset($_SESSION['Klin_user'])) {
    include('login.php');
    exit;
  }
}

function CompleteProfile()
{
  include('../connection/connect.php');
  return $return;
}

function StatusCheck()
{
  global $db;

  $status_query = "select * from jobseeker where email = '" . $_SESSION['Klin_user'] . "' ";
  $status_result = $db->query($status_query);
  $status_row = mysqli_fetch_array($status_result);

  if ($status_row['status'] == 'registerd') {
    echo '10';
  } elseif (!$status_row['firstname'] || !$status_row['lastname']  || !$status_row['passport']) {
    echo '20';
  } elseif ((!$status_row['first_qualification'])  || (!$status_row['first_institution'])   || !$status_row['first_degree'] || !$status_row['first_course']) {
    echo '30';
  } elseif (!$status_row['name_of_org'] || !$status_row['job_level']  || !$status_row['position'] || !$status_row['exp_year_start']  || !$status_row['experience_1'] || !$status_row['industry']  || !$status_row['achievement']) {
    echo '40';
  } elseif (!$status_row['facebook'] || !$status_row['instagram'] || !$status_row['twitter'] || !$status_row['linkedin']) {
    echo '50';
  } elseif (!$status_row['refName'] || !$status_row['refEmail'] || !$status_row['refPhone'] || !$status_row['refCompany']) {
    echo '60';
  } elseif (get_val('credentials', 'candidate_id', $status_row['candidate_id'], 'document') == 'CV') {
    echo '70';
  } elseif ($status_row['completed'] == 'updated') {
    echo '100';
  } else {
    echo '0';
  }
}
function  ProfileStatus()
{
  global $db;

  $status_query = "select * from jobseeker where email = '" . $_SESSION['Klin_user'] . "' ";
  $status_result = $db->query($status_query);
  $status_row = mysqli_fetch_array($status_result);

  if ($status_row['first_qualification'] == 'BACHELOR DEGREE') {
    echo '10';
  } elseif ($status_row['first_qualification'] == 'HND') {
    echo '20';
  } elseif ($status_row['first_qualification'] == 'MASTERS') {
    echo '30';
  } elseif ($status_row['first_degree'] == 'First Class') {
    echo '40';
  } elseif ($status_row['profCert']) {
    echo '50';
  } elseif ($status_row['name_of_org'] && $status_row['exp_year_start'] && $status_row['exp_year_end'] && $status_row['position']) {
    echo '60';
  } else {
    echo '0';
  }
}

function UserCheck($email)
{
  $email = $_SESSION['Klin_user'];
  global $db;

  $user_check = "select * from jobseeker_signup where email = '$email' ";
  $user_result =  mysqli_query($db, $user_check);
  $user_row = mysqli_fetch_assoc($user_result);
  return  $user_row['fullname'];
}


function sender_name()
{
  return 'KlinHr';
}

function host_name()
{
  return 'https://' . $_SERVER['HTTP_HOST'];
}

function staff_portal()
{
  return 'https://staffportal.' . $_SERVER['HTTP_HOST'];
}

function sender_email()
{
  // return 'noreply@'.$_SERVER['HTTP_HOST'];
  return 'noreply@ecardnaija.com';
}


function reply_email()
{
  return 'solution@Klinhr.com.ng';
}



function host()
{
  return 'https://' . $_SERVER['HTTP_HOST'];
}

function assessment_link()
{
  return '' . root() . '/assessment';
}


function root()
{

  return 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
}

//  functions end
// function admin_email()
// {
//   return 'adelusumbo@gmail.com';
// }

function check_module($privilege, $menu)
{
  if (strpos($privilege, $menu) !== false) {
    return 'yes';
  }
  if ($privilege == 'Super Admin' || $privilege == 'Admin') {
    return 'yes';
  }
}

function Check_Staff_Status($staff_id)
{

  global $db;
  $query = "select * from emp_staff_details where staff_id = '$staff_id'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  if ($row['status'] != 'Active') {
    $error = "Kindly check if your profile is  up to date before you can use the Staff Portal";
    include('update_profile.php');
    exit;
  }
}

function validatePermission($module)
{

  include 'connection/connect.php';
  ob_start();
session_start();

  $modules = $_SESSION['privilege'];

  if (strpos($modules, $module) !== false) {
  } elseif ($modules == 'Super Admin' || $modules == 'Admin') {
  } else {
    header('location: dashboard?access=denied');
  }
}


function today()
{
  return date('Y-m-d');
}

function year()
{
  return date('Y');
}

function week()
{
  return date('W');
}

function doc_root()
{
  return $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['SCRIPT_NAME']);
}

function check_date()
{
  return date("Y-m-d", strtotime("-7 days", strtotime(today())));
}

function check_month()
{
  return date("Y-m-d", strtotime("-1 month", strtotime(today())));
}

function check_year()
{
  return date("Y");
}


function yesterday()
{
  return date("Y-m-d", strtotime("-1 day", strtotime(today())));
}

function end_date($effective_date)
{
  return date("Y-m-d", strtotime("+364 day", strtotime($effective_date)));
}

function long_date($date)
{
  return date('jS M, Y', strtotime($date));
}



function long_datetime($date)
{
  return date('jS M Y g:i:s A ', strtotime($date));
}
function short_date($date)
{
  return date('d M Y', strtotime($date));
}
function valid_date($date)
{
  $date = str_replace('/', '-', $date);

  return date('Y-m-d', strtotime($date));
}

function mytime()
{
  return date('Y-m-d h:i:s');
}

function now()
{
  return date('U');
}

function expire_time()
{
  return date("Y-m-d H:i:s", strtotime("+48 hours", strtotime(now())));
}

function reminder_48()
{
  return date("Y-m-d", strtotime("+48 hours", strtotime(today())));
}

function profile_img()
{
  global $db;
  $query = "select * from jobseeker where email = '" . $_SESSION['Klin_user'] . "'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  $file = 'app/document/' . $row['passport'];
  if (!$row['passport']) {
    $file =  '../images/dashpic.png';
  }
  echo $file;
}
// exam
function exam_time($job_id)
{
  global $db;
  $query = "select * from assessment where job_id = '$job_id'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['duration'];
}

function num_questions($job_id)
{
  global $db;
  $query = "select * from assessment where job_id = '$job_id'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['no_of_question'];
}

function get_exam_end_time($start, $job_id)
{
  $exam_time = exam_time($job_id);

  return date("Y-m-d H:i:s", strtotime("+ $exam_time mins", strtotime($start)));
}

function check_exam_status($email, $code)
{
  global $db;
  $query = "select * from exam_result where email = '$email' and exam_code = '$code'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['status'];
}

function check_flag($candidate_id)
{
  global $db;
  $query = "select * from application_history where candidate_id = '$candidate_id' and action = 'Returned to pool'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  $num = mysqli_num_rows($result);
  if ($num > 0) {
    return '<a href="view-comment?id=' . base64_encode($candidate_id) . '" title="Candidate returned to available pool"><small><i
	class="fas fa-x1 text-danger fa-flag"></i></small></a>';
  }
}
function get_time_left($end_time)
{
  $datetime1 = new DateTime();
  $datetime2 = new DateTime($end_time);
  $interval = $datetime1->diff($datetime2);
  //$elapsed = $interval->format('%y years %m months %a days %h hours %i minutes %s seconds');
  $elapsed = $interval->format('%i:00');
  return $elapsed;
}

function score_question($user, $q_a, $q_type)
{

  global $db;

  if ($q_type == 'multiple') {

    $q_a =  explode(',', $q_a); // seperate value by comma into array

    for ($i = 0; $i < count($q_a); $i++) {
      $ques = explode('=', $q_a[$i]);
      $ques_no = $ques[0];
      $list_ans[] = $ques[1];
    }
    sort($list_ans);
    $ans = implode(',', $list_ans);
  } else {

    $ques = explode('=', $q_a);
    $ques_no = $ques[0];
    $ans = $ques[1];
  }

  if (!$q_a) {
    return NULL;
  } else {

    $query = "select * from questions where id = '$ques_no' and answer = '$ans'";
    $result = mysqli_query($db, $query);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
      return 1;
    } else {
      return 0;
    }
  }
}
function string_by_colD($col, $id)

{
  global $db;
  $query = "select * from appraisald where appraisal_id='$id'";

  $result = mysqli_query($db, $query);

  if ($result) {

    $row = mysqli_fetch_array($result);

    return $row[$col];
  }
}


function string_by_col($col, $staff_id)

{

  global $db;
  $query = "select * from emp_appraisald_self where staff_id = '$staff_id'";
  $result = mysqli_query($db, $query);
  if ($result) {
    $row = mysqli_fetch_array($result);
    return $row[$col];
  }
}



function value_by_col($col, $id)

{

  global $db;

  $query = "select * from appraisal where appraisal_id='$id'";

  $result = mysqli_query($db, $query);


  if ($result) {

    $row = mysqli_fetch_array($result);

    return intval($row[$col]);
  } else {

    return intval(0);
  }
}

//exam

function test_expiration()
{
  $now = date("Y-m-d g:i:s");
  return date("Y-m-d g:i:s", strtotime("+48 hours", strtotime($now)));
}

function mydate($date)
{
  $date = str_replace('/', '-', $date);

  return date('Y-m-d', strtotime($date));
}


function test_code($email, $candidate_id)
{
  $char = $candidate_id . rand(120833, 999999);
  return substr($char, 0, 6);
}

function check_assessment($job_title)
{
  global $db;

  $query = "select * from assessment where assessment_name = '$job_title'";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  if ($num > 0) {
    return 'confirm';
  } else {
    return 'not available';
  }
}

function get_admin_name($user)
{

  global $db;

  $user = $_SESSION['Klin_admin_user'];
  $query = "select * from login where username = '$user'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return ucfirst($row['firstname']) . ' ' . ucfirst($row['lastname']);
}
function get_job_id()
{

  global $db;

  // $candidate = $_SESSION['Klin_user'];
  $job_id = "select * from jobs_applied where candidate_id = '" . $_SESSION['Klin_user'] . "'";
  $result = mysqli_query($db, $job_id);
  $num  = mysqli_num_rows($result);
  $row = mysqli_fetch_array($result);
  return $row['job_id'];
}


function get_job()
{

  global $db;

  // $candidate = $_SESSION['Klin_user'];
  $query = "select * from jobseeker where candidate_id = '" . $_SESSION['candidate_id'] . "'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['candidate_id'];
}

function get_user($user)
{

  global $db;

  $user = $_SESSION['Klin_user'];
  $query = "select * from login where username = '$user'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return ucfirst($row['firstname']) . ' ' . ucfirst($row['lastname']);
}
function get_onboarding_user($email)
{

  global $db;

  $query = "select * from emp_staff_details where email_address = '$email'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return ucfirst($row['firstname']) . ' ' . ucfirst($row['surname']);
}

function get_age($date)
{
  return floor((time() - strtotime($date)) / 31556926);
}

function user_name($user_name)
{

  global $db;

  $user_name = $_SESSION['Klin_admin_user'];
  $query = "select * from login where username = '$user_name'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return ucfirst($row['firstname']) . ' ' . ucfirst($row['lastname']);
}


function privilege()
{
  ob_start();
session_start();
  global $db;
  $priv = $_SESSION['Klin_admin_user'];
  $sql =  "select * from login where username = '$priv'  ";
  $result = mysqli_query($db, $sql);
  $row = mysqli_fetch_array($result);
  $privilege = $row['privilege'];
  return $privilege;
}

function get_job_post_id($job_title)
{

  global $db;
  $query = "select * from job_post where job_title = '$job_title'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['category'];
}

function get_client_name($id)
{

  global $db;
  $query = "select * from clients where id = '$id'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['client_name'];
}


function get_fullname($email)
{
  global $db;

  $query = "select * from jobseeker where email = '$email'";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  if ($num) {
    $row = mysqli_fetch_array($result);
    return $row['firstname'] . ' ' . $row['lastname'];
  } else {
    $query = "select * from login where email = '$email'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_array($result);
    return $row['firstname'] . ' ' . $row['lastname'];
  }
}

function get_firstname($email)
{
  $names = explode(' ', get_fullname($email));

  return $names[0];
}
function get_candidate_name($email)
{
  global $db;

  $query = "select * from participant where email = '$email'";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  if ($num) {
    $row = mysqli_fetch_array($result);
    return $row['firstname'] . ' ' . $row['lastname'];
  }
}

function get_post_per($job_id)
{
  global $db;
  $query = "select * from jobs_applied";
  $result = mysqli_query($db, $query);
  $total = mysqli_num_rows($result);

  $query2 = "select * from jobs_applied where job_id = '$job_id'";
  $result2 = mysqli_query($db, $query2);
  $total_post = mysqli_num_rows($result2);

  $percentage = $total_post / $total * 100;

  return round($percentage) . '%';
}

function get_candidate_status($candidate_id)
{
  global $db;
  $query = "select * from application_history where candidate_id = '$candidate_id' order by id desc";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  if ($num > 0) {
    $row = mysqli_fetch_array($result);
    return $row['status'];
  } else {
    return 'Registration';
  }
}

function status_color($value)
{
  $status = strtolower($value);

  if ($status == 'approved' || $status == 'active' || $status == 'updated') {
    return 'success';
  } else {
    return 'warning';
  }
}

function progress($value)
{
  $status = strtolower($value);

  if ($status == 'approved') {
    return '50';
  } elseif ($status == 'active') {
    return '100';
  } elseif ($status == 'updated') {
    return '25';
  } else {
    return '0';
  }
}

function progress_color($value)
{
  $status = strtolower($value);

  if ($status == 'approved') {
    return 'success';
  } elseif ($status == 'active') {
    return 'success';
  } elseif ($status == 'updated') {
    return 'primary';
  } else {
    return 'warning';
  }
}

function count_tab($tab)
{
  global $db;
  $count = mysqli_num_rows(mysqli_query($db, "select * from $tab"));
  return $count;
}

function counts()
{
  global $db;
  $count = mysqli_num_rows(mysqli_query($db, "select * from job_post where status != 'approved'"));
  return $count;
}

function seeker_percent()
{
  global $db;
  $total = mysqli_num_rows(mysqli_query($db, "select * from jobseeker_signup"));
  $count = mysqli_num_rows(mysqli_query($db, "select * from jobseeker_signup where status = 'active' "));


  $percentage = ($count / $total) * 100;
  return $percentage;
}

function not_seeker_percent()
{
  global $db;
  $seeker_percent = seeker_percent();
  $not_seeker_percent = 100 - $seeker_percent;
  return $not_seeker_percent;
}

function not_active()
{
  global $db;
  $count = mysqli_num_rows(mysqli_query($db, "select * from jobseeker_signup where status != 'active'"));
  return $count;
}

function count_tab_val($tab, $col, $val)
{
  global $db;
  if ($val == 'NULL') {
    $count = mysqli_num_rows(mysqli_query($db, "select * from $tab where $col IS NULL"));
  } else {
    $count = mysqli_num_rows(mysqli_query($db, "select * from $tab where $col = '$val'"));
  }
  return $count;
}

function get_client($tab, $col, $val)
{
  global $db;
  $query = "select * from $tab order by $val";
  $result = mysqli_query($db, $query);

  $row = mysqli_fetch_array($result);
  echo '' . $row[$val] . '"' . $row[$col] . '';
}

function get_extension($filename)

{

  $ext = explode('.', $filename);

  $ext2 = str_replace(' ', '', $ext);

  $extension = array_reverse($ext2);

  return strtolower($extension[0]);
}

function resigned_staff($staff_id)
{
  $today = date('Y-m-d');
  global $db;
  $query = "select * from emp_resignation where staff_id = '$staff_id' and date < '$today'";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  if ($num > 0) {
    return 'true';
    exit;
  }

  $query1 = "select * from emp_staff_details where staff_id = '$staff_id' and status = 'Inactive' ";
  $result1 = mysqli_query($db, $query1);
  $num1 = mysqli_num_rows($result1);
  if ($num1 > 0) {
    return 'valid';
    exit;
  }
}


function validate_file($filename)
{
  $get_ext = explode('.', $filename);
  $get_ext2 = array_reverse($get_ext);
  $file_extension = $get_ext2[0];
  $extension = strtolower($file_extension);

  if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif' || $extension == 'pdf' || $extension == 'ppt' || $extension == 'pptx') {
    return 'valid';
  } else {
    return 'invalid';
  }
}



function list_val($tab, $col, $val)
{
  global $db;
  $query = "select * from $tab order by $col";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row[$val] . '">' . $row[$col] . '</option>';
  }
}



function get_val($tab, $col, $val, $return_val)
{
  global $db;
  $query = "select * from $tab where $col = '$val'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row[$return_val];
}

function CheckValue($tab, $col, $val)
{
  global $db;
  $new_notification_query = "select * from $tab where $col = '$val' ";
  $new_notification_result = mysqli_query($db, $new_notification_query);
  $new_notification_num = mysqli_num_rows($new_notification_result);
  // $new_notification_row = mysqli_fetch_array($new_notification_result);
  if ($new_notification_num > 5) {
    echo '+';
  }
}


function random($col, $tab)
{
  global $db;
  $query = "select distinct $col from $tab where $col != ''";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row[$col] . '">' . $row[$col] . '</option>';
  }
  return [$col];
}

function list_val_distinct($tab, $col)
{
  global $db;
  $query = "select distinct $col from $tab where $col IS NOT NULL and $col != '' order by $col";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row[$col] . '">' . $row[$col] . '</option>';
  }
}

function list_job_client()
{
  global $db;
  $query = "select distinct client_id from job_post";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);

  for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row['client_id'] . '">' . get_client_name($row['client_id']) . '</option>';
  }
}

function cat_selected($cat, $assessment_id)
{
  global $db;
  $query = "select * from assessment where id = '$assessment_id' and category like '%" . $cat . "%'";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  if ($num > 0) {
    echo 'selected';
  }
}

function list_month()
{
  echo ' <option>January</option>
  <option>February</option>
  <option>March</option>
  <option>April</option>
  <option>May</option>
  <option>June</option>
  <option>July</option>
  <option>August</option>
  <option>September</option>
  <option>October</option>
  <option>November</option>
  <option>December</option>';
}

function get_remark($job_title, $score)
{
  global $db;
  $query = "select * from assessment where assessment_name = '$job_title'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);

  if ($score >= $row['pass_mark']) {
    return 'Passed';
  } else {
    return 'Failed';
  }
}
function get_off($job_title)
{
  global $db;
  $query = "select * from assessment where assessment_name = '$job_title'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);

  return $row['pass_mark'];
}
function Klin_admin_email()
{
  global $db;
  $query = "select * from login where privilege = 'admin' order by id asc";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['email'];

  // return 'luabikoye@yahoo.com';


}

function organisation()
{
  return 'Klin Hr';
}
function org()
{
  return 'KlinHr';
}

function get_end_time($start)
{

  return date("Y-m-d: H:i:s", strtotime("+ 29 mins", strtotime($start)));
}

function list_district()

{

  global $db;

  $query = "select distinct state from local_govt where country = 'Ghana'";


  $result = mysqli_query($db, $query);

  $num_result = mysqli_num_rows($result);

  for ($i = 0; $i < $num_result; $i++) {

    $row = mysqli_fetch_array($result);

    echo '<option value="' . $row['state'] . '">' . $row['state'] . '</option>';
  }
}
function list_state()

{

  global $db;

  $query = "select distinct state from local_govt order by state";


  $result = mysqli_query($db, $query);

  $num_result = mysqli_num_rows($result);

  for ($i = 0; $i < $num_result; $i++) {

    $row = mysqli_fetch_array($result);

    echo '<option value="' . $row['state'] . '">' . $row['state'] . '</option>';
  }
}


function request_status($query, $status)
{
  global $db;
  $query_run = "$query and status = '$status'";
  $result = mysqli_query($db, $query_run);
  $num = mysqli_num_rows($result);
  return $num;
  //return 10;
}
function get_status($query, $tab, $status)
{
  global $db;
  $query_run = "$query and $tab = '$status'";
  $result = mysqli_query($db, $query_run);
  $num = mysqli_num_rows($result);
  return $num;
  //return 10;
}



function activity_log($Klin_user, $action)
{
  $date_time = date('Y-m-d h:i:s');

  global $db;
  $sql_1 = "insert into activity_log set author = '$Klin_user', fullname = '" . get_fullname($Klin_user) . "', action_taken = '$action', date = '$date_time'";
  $sql_result = mysqli_query($db, $sql_1);
}

function assessment_log($ats_candidate, $action)
{
  $date_time = date('Y-m-d g:i:s A');
  $ats_candidate = $_SESSION['ats_candidate'];

  global $db;
  $sql_1 = "insert into activity_log set author = '$ats_candidate', fullname = '" . get_candidate_name($ats_candidate) . "', action_taken = '$action', date = '$date_time'";
  $sql_result = mysqli_query($db, $sql_1);
}

function application_log($candidate_id, $job_id, $action, $status = 'Applied')
{
  $date_time = date('Y-m-d h:i:s');

  global $db;
  $sql_1 = "insert into application_history set candidate_id = '$candidate_id', job_id = '$job_id', action = '$action', status = '$status', date_modified = '$date_time'";
  $sql_result = mysqli_query($db, $sql_1);
}


function bold_text($status)
{
  if ($status == 'Unread' || $status == 'unread') {
    return 'style="font-weight:bold;"';
  }
}

function list_degree()
{
  echo ' <option id="1">First Class</option>

	<option value="Second Class Upper" id="2">Second Class Upper</option>
	<option value="Second Class Lower" id="3">Second Class Lower</option>
	<option value="Third Class" id="4">Third Class</option>
	<option value="Distinction" id="5">Distinction</option>
	<option value="Upper Credit" id="6">Upper Credit</option>
	<option value="Lower Credit" id="7">Lower Credit</option>';
}
function list_job_level()
{
  echo '

  <option value="Officer">Officer</option>
  <option value="Supervisor">Supervisor</option>
  <option value="Asst. Manager">Asst. Manager</option>
  <option value="Manager">Manager</option>
  <option value="Senior Manager">Senior Manager</option>
  <option value="Asst. General Manager">Asst. General Manager</option>
  <option value="General Manager">General Manager</option>
  <option value="Director">Director</option>';
}

function list_qualifications()
{
  echo '<option value="FSLC">First School Leaving Certificate(FSLC)</option>
  <option value="SSCE">SSCE</option>
  <option value="NCE">NCE</option>
  <option value="OND">OND</option>
  <option value="HND">HND</option>
  <option value="BACHELOR DEGREE">BACHELOR DEGREE</option>
	<option value="MASTERS">MASTERS</option>';
}
function list_salary()
{
  echo '
  <option value="50,000 - 100,000">  &#8358;50,000 -  &#8358;100,000</option>
  <option value="100,000 - 150,000"> &#8358;100,000 - &#8358;150,000</option>
  <option value="150,000 - 200,000"> &#8358;150,000 - &#8358;200,000</option>
  <option value="200,000 - 300,000"> &#8358;200,000 - &#8358;300,000</option>
  <option value="300,000 - 400,000"> &#8358;300,000 - &#8358;400,000</option>
  <option value="400,000 - 500,000"> &#8358;400,000 - &#8358;500,000</option>
  <option value="500,000 and Above"> &#8358;500,000 and Above</option>

			';
}

function list_roles()
{
  echo '<option>Accounting</option>
  <option>Administrative</option>
  <option>Finance</option>
  <option>IT and Development</option>
  <option>Programmer</option>
  <option>Full Stack Developer</option>
  <option>Design</option>
  <option>Customer Service</option>
  <option>Corporate Training </option>
  <option>Engineering</option>
  <option>Electrical Works</option>
  <option>Construction</option>
  <option>Oil and Gas</option>
  <option>Transportation & Logistics</option>
  <option>Banking & Banking Operations</option>
  <option>Healthcare</option>
  <option>Real Estate</option>
  <option>Manufacturing</option>
  <option>Sales</option>
  <option>Business Development</option>
  <option>Direct Sales – Retail </option>
  <option>Telecommunications</option>
  <option>FMCG</option>
  <option>Pharmaceutical</option>
  <option>Medical Sciences</option>
  <option>Radio & TV Broadcasting</option>
  <option>Hospital Services</option>
  <option>Education and Educational Services</option>
  <option>Hospitality</option>
  <option>Legal</option>';
}
function year_list($start)
{
  for ($i = $start; $i <= date('Y'); $i++) {
    echo '<option>' . $i . '</option>';
  }
}



function list_institution()
{
  echo ' <option value="Abia State University, Uturu.">Abia State University, Uturu.</option>
      	      <option value="Abubakar Tafawa Balewa University, Bauchi">Abubakar Tafawa Balewa University, Bauchi</option>
      	      <option value="Achievers University, Owo">Achievers University, Owo</option>
      	      <option value="Adamawa State University Mubi">Adamawa State University Mubi</option>
      	      <option value="Adekunle Ajasin University, Akungba.">Adekunle Ajasin University, Akungba.</option>
      	      <option value="Adeleke University,Ede.">Adeleke University,Ede.</option>
      	      <option value="Afe Babalola University, Ado-Ekiti - Ekiti State">Afe Babalola University, Ado-Ekiti - Ekiti State</option>
      	      <option value="African University of Science &amp; Technology, Abuja">African University of Science &amp; Technology, Abuja</option>
      	      <option value="Ahmadu Bello University, Zaria">Ahmadu Bello University, Zaria</option>
      	      <option value="Ajayi Crowther University, Ibadan">Ajayi Crowther University, Ibadan</option>
      	      <option value="Akwa Ibom State University of Technology, Uyo">Akwa Ibom State University of Technology, Uyo</option>
      	      <option value="Al-Hikmah University, Ilorin">Al-Hikmah University, Ilorin</option>
      	      <option value="Ambrose Alli University, Ekpoma">Ambrose Alli University, Ekpoma,</option>
      	      <option value="American University of Nigeria, Yola">American University of Nigeria, Yola</option>
      	      <option value="Anambra State University of Science &amp; Technology, Uli">Anambra State University of Science &amp; Technology, Uli</option>
      	      <option value="Babcock University,Ilishan-Remo">Babcock University,Ilishan-Remo</option>
      	      <option value="Bauchi State University, Gadau">Bauchi State University, Gadau</option>
      	      <option value="ayero University,Kano">Bayero University,Kano</option>
      	      <option value="Baze University">Baze University</option>
      	      <option value="Bells University of Technology, Otta">Bells University of Technology, Otta</option>
      	      <option value="Benson Idahosa University,Benin City">Benson Idahosa University,Benin City</option>
      	      <option value="Benue State University, Makurdi.">Benue State University, Makurdi.</option>
      	      <option value="Bingham University, New Karu">Bingham University, New Karu</option>
      	      <option value="Bowen University, Iwo">Bowen University, Iwo</option>
      	      <option value="Bukar Abba Ibrahim University, Damaturu.">Bukar Abba Ibrahim University, Damaturu.</option>
      	      <option value="Caleb University, Lagos">Caleb University, Lagos</option>
      	      <option value="Caritas University, Enugu">Caritas University, Enugu</option>
      	      <option value="CETEP City University, Lagos">CETEP City University, Lagos</option>
      	      <option value="Covenant University Ota">Covenant University Ota</option>
      	      <option value="Crawford University Igbesa">Crawford University Igbesa</option>
      	      <option value="Crescent University,">Crescent University,</option>
      	      <option value="Cross River State University of Science &amp;Technology, Calabar">Cross River State University of Science &amp;Technology, Calabar</option>
      	      <option value="Delta State University Abraka">Delta State University Abraka</option>
      	      <option value="Ebonyi State University, Abakaliki">Ebonyi State University, Abakaliki</option>
      	      <option value="Ekiti State University">Ekiti State University</option>
      	      <option value="Elizade University, Ilara-Mokin">Elizade University, Ilara-Mokin</option>
      	      <option value="Enugu State University of Science and Technology, Enugu">Enugu State University of Science and Technology, Enugu</option>
      	      <option value="Evangel University, Akaeze">Evangel University, Akaeze</option>
      	      <option value="Federal University Gashua">Federal University Gashua</option>
      	      <option value="Federal University of Petroleum Resources, Effurun">Federal University of Petroleum Resources, Effurun</option>
      	      <option value="Federal University of Technology, Akure">Federal University of Technology, Akure</option>
      	      <option value="Federal University of Technology, Minna.">Federal University of Technology, Minna.</option>
      	      <option value="Federal University of Technology, Owerri">Federal University of Technology, Owerri</option>
      	      <option value="Federal University, Dutse, Jigawa State">Federal University, Dutse, Jigawa State</option>
      	      <option value="Federal University, Dutsin-Ma, Katsina">Federal University, Dutsin-Ma, Katsina</option>
      	      <option value="Federal University, Kashere, Gombe State">Federal University, Kashere, Gombe State</option>
      	      <option value="Federal University, Lafia, Nasarawa State">Federal University, Lafia, Nasarawa State</option>
      	      <option value="Federal University, Lokoja, Kogi State">Federal University, Lokoja, Kogi State</option>
      	      <option value="Federal University, Ndufu-Alike, Ebonyi State">Federal University, Ndufu-Alike, Ebonyi State</option>
      	      <option value="Federal University, Otuoke, Bayelsa">Federal University, Otuoke, Bayelsa</option>
      	      <option value="Federal University, Oye-Ekiti, Ekiti State">Federal University, Oye-Ekiti, Ekiti State</option>
      	      <option value="Federal University, Wukari, Taraba State">Federal University, Wukari, Taraba State</option>
      	      <option value="ederal University,Birnin Kebbi.">Federal University,Birnin Kebbi.</option>
      	      <option value="Federal University,Gusau.">Federal University,Gusau.</option>
      	      <option value="Fountain Unveristy,Oshogbo">Fountain Unveristy,Oshogbo</option>
      	      <option value="Godfrey Okoye University, Ugwuomu-Nike - Enugu State">Godfrey Okoye University, Ugwuomu-Nike - Enugu State</option>
      	      <option value="Gombe State Univeristy, Gombe">Gombe State Univeristy, Gombe</option>
      	      <option value="Gregory University, Uturu">Gregory University, Uturu</option>
      	      <option value="Ibrahim Badamasi Babangida University, Lapai">Ibrahim Badamasi Babangida University, Lapai</option>
      	      <option value="Igbinedion University Okada">Igbinedion University Okada</option>
      	      <option value="Ignatius Ajuru University of Education,Rumuolumeni.">Ignatius Ajuru University of Education,Rumuolumeni.</option>
      	      <option value="Imo State University, Owerri">Imo State University, Owerri</option>
      	      <option value="Joseph Ayo Babalola University, Ikeji-Arakeji">Joseph Ayo Babalola University, Ikeji-Arakeji</option>
      	      <option value="Kaduna State University, Kaduna">Kaduna State University, Kaduna</option>
      	      <option value="Kano University of Science &amp; Technology, Wudil">Kano University of Science &amp; Technology, Wudil</option>
      	      <option value="Katsina University, Katsina">Katsina University, Katsina</option>
      	      <option value="Kebbi State University, Kebbi">Kebbi State University, Kebbi</option>
      	      <option value="Kogi State University Anyigba">Kogi State University Anyigba</option>
      	      <option value="Kwara State University, Ilorin">Kwara State University, Ilorin</option>
      	      <option value="Ladoke Akintola University of Technology, Ogbomoso">Ladoke Akintola University of Technology, Ogbomoso</option>
      	      <option value="Lagos State University Ojo, Lagos.">Lagos State University Ojo, Lagos.</option>
      	      <option value="Landmark University,Omu-Aran.">Landmark University,Omu-Aran.</option>
      	      <option value="Lead City University, Ibada">Lead City University, Ibadan</option>
      	      <option value="Madonna University, Okija">Madonna University, Okija</option>
      	      <option value="Mcpherson University, Seriki Sotayo, Ajebo">Mcpherson University, Seriki Sotayo, Ajebo</option>
      	      <option value="Michael Okpara Uni. of Agric., Umudike">Michael Okpara Uni. of Agric., Umudike</option>
      	      <option value="Modibbo Adama University of Technology, Yola">Modibbo Adama University of Technology, Yola</option>
      	      <option value="Nasarawa State University, Keffi">Nasarawa State University, Keffi</option>
      	      <option value="National Open University of Nigeria, Lagos.">National Open University of Nigeria, Lagos.</option>
      	      <option value="Niger Delta Unversity, Yenagoa">Niger Delta Unversity, Yenagoa</option>
      	      <option value="Nigerian Defence Academy,Kaduna">Nigerian Defence Academy,Kaduna</option>
      	      <option value="Nigerian-Turkish Nile University, Abuja">Nigerian-Turkish Nile University, Abuja</option>
      	      <option value="Nnamdi Azikiwe University, Awka">Nnamdi Azikiwe University, Awka</option>
      	      <option value="Northwest University, Kano">Northwest University, Kano</option>
      	      <option value="Novena University, Ogume">Novena University, Ogume</option>
      	      <option value="Obafemi Awolowo University,Ile-Ife">Obafemi Awolowo University,Ile-Ife</option>
      	      <option value="Obong University, Obong Ntak">Obong University, Obong Ntak</option>
      	      <option value="Oduduwa University, Ipetumodu - Osun  State">Oduduwa University, Ipetumodu - Osun  State</option>
      	      <option value="Olabisi Onabanjo University Ago-Iwoye">Olabisi Onabanjo University Ago-Iwoye</option>
      	      <option value="Ondo State University of Science &amp; Technology, Okitipupa">Ondo State University of Science &amp; Technology, Okitipupa</option>
      	      <option value="Osun State University, Oshogbo">Osun State University, Oshogbo</option>
      	      <option value="Pan-African University, Lagos">Pan-African University, Lagos</option>
      	      <option value="Paul University, Awka - Anambra State">Paul University, Awka - Anambra State</option>
      	      <option value="Plateau State University, Bokkos">Plateau State University, Bokkos</option>
      	      <option value="Police Academy Wudil">Police Academy Wudil</option>
      	      <option value="Redeemers University, Mowe">Redeemer\'s University, Mowe</option>
      	      <option value="Renaissance University,Enugu">Renaissance University,Enugu</option>
      	      <option value="Rhema University, Obeama-Asa - Rivers State">Rhema University, Obeama-Asa - Rivers State</option>
      	      <option value="Rivers State University of Science &amp; Technology">Rivers State University of Science &amp; Technology</option>
      	      <option value="Salem University,Lokoja">Salem University,Lokoja</option>
      	      <option value="Samuel Adegboyega University,Ogwa.">Samuel Adegboyega University,Ogwa.</option>
      	      <option value="Sokoto State University, Sokoto">Sokoto State University, Sokoto</option>
      	      <option value="Southwestern University, Oku Owa">Southwestern University, Oku Owa</option>
      	      <option value="Tai Solarin Univ. of Education, Ijebu-Ode">Tai Solarin Univ. of Education, Ijebu-Ode</option>
      	      <option value="Tansian University,Umunya">Tansian University,Umunya</option>
      	      <option value="Taraba State University, Jalingo">Taraba State University, Jalingo</option>
      	      <option value="Technical University,Ibadan">Technical University,Ibadan</option>
      	      <option value="Umaru Musa YarAdua University, Katsina">Umaru Musa Yar\'Adua University, Katsina</option>
      	      <option value="University of Abuja, Gwagwalada">University of Abuja, Gwagwalada</option>
      	      <option value="University of Agriculture, Abeokuta.">University of Agriculture, Abeokuta.</option>
      	      <option value="University of Agriculture, Makurdi.">University of Agriculture, Makurdi.</option>
      	      <option value="University of Benin">University of Benin</option>
      	      <option value="University of Calabar">University of Calabar</option>
      	      <option value="University of Ibadan">University of Ibadan</option>
      	      <option value="University of Ilorin">University of Ilorin</option>
      	      <option value="University of Jos">University of Jos</option>
      	      <option value="University of Lagos">University of Lagos</option>
      	      <option value="University of Maiduguri">University of Maiduguri</option>
      	      <option value="University of Mkar, Mkar">University of Mkar, Mkar</option>
      	      <option value="University of Nigeria, Nsukka">University of Nigeria, Nsukka</option>
      	      <option value="University of Port-Harcourt">University of Port-Harcourt</option>
      	      <option value="University of Uyo">University of Uyo</option>
      	      <option value="Usumanu Danfodiyo University">Usumanu Danfodiyo University</option>
      	      <option value="Veritas University">Veritas University</option>
      	      <option value="Wellspring University, Evbuobanosa - Edo State">Wellspring University, Evbuobanosa - Edo State</option>
      	      <option value="Wesley Univ. of Science &amp; Tech.,Ondo">Wesley Univ. of Science &amp; Tech.,Ondo</option>
      	      <option value="Western Delta University, Oghara">Western Delta University, Oghara</option>
      	      <option value="Wukari Jubilee University,">Wukari Jubilee University,</option>
      	      <option value="Wukari Jubilee University,Wukari">Wukari Jubilee University,Wukari</option>
      	      <option >++++++++++Select Polytechnic++++++++++</option>
      	      <option value="Akperan Orshi College of Agriculture"> Akperan Orshi College of Agriculture</option>
      	      <option value="Abubakar Tafari Ali Polytechnic">Abubakar Tafari Ali Polytechnic </option>
      	      <option value="Abdul Gusau Polytechnic"> Abdul Gusau Polytechnic</option>
      	      <option value="Auchi Polytechnic"> Auchi Polytechnic</option>
      	      <option value="Adamawa State Polytechnic">Adamawa State Polytechnic </option>
      	      <option value="Akwa Ibom State Polytechnic"> Akwa Ibom State Polytechnic</option>
      	      <option value="Akwa-Ibom College of Agriculture">Akwa-Ibom College of Agriculture </option>
      	      <option value="Allover Central Polytechnic"> Allover Central Polytechnic</option>
      	      <option value="Bayelsa State College of Arts and Science">Bayelsa State College of Arts and Science </option>
      	      <option value="Benue State Polytechnic"> Benue State Polytechnic</option>
      	      <option value="Borno College of Agriculture">Borno College of Agriculture </option>
      	      <option value="Delta State College of Agriculture"> Delta State College of Agriculture</option>
      	      <option value="Delta State Polytechnic:">Delta State Polytechnic: </option>
      	      <option value="Dorben Polytechnic">Dorben Polytechnic </option>
      	      <option value="Ekwenugo Okeke Polytechnic"> Ekwenugo Okeke Polytechnic</option>
      	      <option value="Federal Polytechnic, Mubi">Federal Polytechnic, Mubi </option>
      	      <option value="Federal Polytechnic, Oko">Federal Polytechnic, Oko </option>
      	      <option value="Federal Polytechnic, Bauchi">Federal Polytechnic, Bauchi </option>
      	      <option value="Federal Polytechnic, Nekede">Federal Polytechnic, Nekede </option>
      	      <option value="Federal Polytechnic, Idah">Federal Polytechnic, Idah </option>
      	      <option value="Federal Polytechnic, Bida"> Federal Polytechnic, Bida</option>
      	      <option value="Federal Polytechnic, Birnin-Kebbi">Federal Polytechnic, Birnin-Kebbi </option>
      	      <option value="Federal Polytechnic, Nassarawa">Federal Polytechnic, Nassarawa </option>
      	      <option value="Federal Polytechnic, Damaturu">Federal Polytechnic, Damaturu </option>
      	      <option value="Federal Polytechnic, Namoda">Federal Polytechnic, Namoda </option>
      	      <option value="Federal Polytechnic, Ado-Ekiti">Federal Polytechnic, Ado-Ekiti </option>
      	      <option value="Federal Polytechnic, Offa"> Federal Polytechnic, Offa</option>
      	      <option value="Federal Polytechnic, Ilaro">Federal Polytechnic, Ilaro </option>
      	      <option value="Federal Polytechnic, Ede">Federal Polytechnic, Ede </option>
      	      <option value="Gateway Polytechnic Saapade">Gateway Polytechnic Saapade</option>
      	      <option value="Grace Polytechnic">Grace Polytechnic </option>
      	      <option value="Hassan Usman Katsina Polytechnic">Hassan Usman Katsina Polytechnic </option>
      	      <option value="Hussaini Adamu Federal Polytechnic">Hussaini Adamu Federal Polytechnic </option>
      	      <option value="Hussani Adamu Polytechnic">Hussani Adamu Polytechnic </option>
      	      <option value="Ibrahim Babangida College of Agriculture">Ibrahim Babangida College of Agriculture </option>
      	      <option value="Imo State Polytechnic">Imo State Polytechnic </option>
      	      <option value="Imo State Technological Skills Acquisition Center">Imo State Technological Skills Acquisition Center </option>
      	      <option value="Institute of Management Technology, Enugu">Institute of Management Technology, Enugu </option>
      	      <option value="Kaduna Polytechnic">Kaduna Polytechnic </option>
      	      <option value="Kano State Polytechnic">Kano State Polytechnic </option>
      	      <option value="Kebbi State Polytechnic">Kebbi State Polytechnic</option>
      	      <option value="Kogi State Polytechnic">Kogi State Polytechnic </option>
      	      <option value="Kwara State Polytechnic"> Kwara State Polytechnic</option>
      	      <option value="Lagos City Polytechnic">Lagos City Polytechnic </option>
      	      <option value="Lagos State Polytechnic">Lagos State Polytechnic </option>
      	      >
      	      <option value="Maurid Institute of Management &amp; Technology, Nasarawa"> Maurid Institute of Management &amp; Technology, Nasarawa</option>
      	      <option value="Mai Idris Alooma Polytechnic">Mai Idris Alooma Polytechnic </option>
      	      <option value="Marvic Polytechnic">Marvic Polytechnic </option>
      	      <option value="Mohammed Abdullahi Wase Polytechnic">Mohammed Abdullahi Wase Polytechnic </option>
      	      <option value="Moshood Abiola Polytechnic">Moshood Abiola Polytechnic </option>
      	      <option value="Nasarawa State Polytechnic">Nasarawa State Polytechnic </option>
      	      <option value="Niger State Polytechnic"> Niger State Polytechnic</option>
      	      <option value="Nuhu Bamalli Polytechnic"> Nuhu Bamalli Polytechnic</option>
      	      <option value="Osun State College of Technology">Osun State College of Technology </option>
      	      <option value="Osun State Polytechnic">Osun State Polytechnic </option>
      	      <option value="Our Saviour Institute of Science and Technology">Our Saviour Institute of Science and Technology </option>
      	      <option value="Plateau State Polytechnic">Plateau State Polytechnic </option>
      	      <option value="Ramat Polytechnic">Ramat Polytechnic </option>
      	      <option value="Rufus Giwa Polytechnic">Rufus Giwa Polytechnic </option>
      	      <option value="Rivers State College of Arts and Science">Rivers State College of Arts and Science </option>
      	      <option value="Rivers State Polytechnic">Rivers State Polytechnic </option>
      	      <option value="Shaka Polytechnic">Shaka Polytechnic </option>
      	      <option value="The Polytechnic, Calabar">The Polytechnic, Calabar </option>
      	      <option value="The Polytechnic, Ibadan">The Polytechnic, Ibadan </option>
      	      <option value="The Polytechnic Ile-Ife"> The Polytechnic Ile-Ife</option>
      	      <option value="Wolex Polytechnic">Wolex Polytechnic </option>
      	      <option value="Yaba College of Technology">Yaba College of Technology </option>

   	        ';
}


function list_course()
{

  echo '    <option value="Accounting">Accounting</option>

   <option value="Actuarial Science">Actuarial Science</option>

   <option value="Adult and Community Education">Adult and Community Education</option>

   <option value="Adult Education">Adult Education</option>

   <option value="Anaesthesia">Anaesthesia</option>

   <option value="Anatomy">Anatomy</option>

   <option value="Applied Entomology &amp; Pest Management">Applied Entomology &amp; Pest Management</option>

   <option value="Applied Geophysics">Applied Geophysics</option>

   <option value="Applied Physics">Applied Physics</option>

   <option value="Architecture">Architecture</option>

   <option value="Arts &amp; Social Science Education">Arts &amp; Social Science Education</option>

   <option value="Biochemistry">Biochemistry</option>

   <option value="Biology Education">Biology Education</option>

   <option value="Botany">Botany</option>

   <option value="Building">Building</option>

   <option value="Business Administration">Business Administration</option>

   <option value="Business Education">Business Education</option>

   <option value="Cell Biology and Genetics">Cell Biology and Genetics</option>

   <option value="Chemical Engineering">Chemical Engineering</option>

   <option value="Chemistry">Chemistry</option>

   <option value="Civil Engineering">Civil Engineering</option>

   <option value="Clinical Pathology">Clinical Pathology</option>

   <option value="Computer Engineering">Computer Engineering</option>

   <option value="Computer Science">Computer Science</option>

   <option value="Construction Management">Construction Management</option>

   <option value="Creative Arts">Creative Arts</option>

   <option value="Dentistry / Dental Surgery">Dentistry / Dental Surgery</option>

   <option value="Economics">Economics</option>

   <option value="Economics Education">Economics Education</option>

   <option value="Education and Business Studies">Education and Business Studies</option>

   <option value="Education and Chemistry">Education and Chemistry</option>

   <option value="Education and Christian Religious Studies">Education and Christian Religious Studies</option>

   <option value="Education and English Language">Education and English Language</option>

   <option value="Education and French">Education and French</option>

   <option value="Education and Geography">Education and Geography</option>

   <option value="Education and History">Education and History</option>

   <option value="Education and Igbo">Education and Igbo</option>

   <option value="Education and Integrated Science">Education and Integrated Science</option>

   <option value="Education and Islamic Studies">Education and Islamic Studies</option>

   <option value="Education and Mathematics">Education and Mathematics</option>

   <option value="Education and Physics">Education and Physics</option>

   <option value="Education and Religious Studies">Education and Religious Studies</option>

   <option value="Education and Science">Education and Science</option>

   <option value="Education and Yoruba">Education and Yoruba</option>

   <option value="Educational Administration">Educational Administration</option>

   <option value="Educational Administration and Planning">Educational Administration and Planning</option>

   <option value="Educational Foundations">Educational Foundations</option>

   <option value="Electrical/Electronics Engineering">Electrical/Electronics Engineering</option>

   <option value="English Language">English Language</option>

   <option value="English Literature">English Literature</option>

   <option value="Environmental Design">Environmental Design</option>

   <option value="Environmental Management">Environmental Management</option>

   <option value="Environmental Toxicology and Pollution Management">Environmental Toxicology and Pollution Management</option>

   <option value="Estate Management">Estate Management</option>

   <option value="Finance">Finance</option>

   <option value="Fishery Production">Fishery Production</option>

   <option value="Food Science">Food Science</option>

   <option value="Food Technology">Food Technology</option>

   <option value="French">French</option>

   <option value="Geographic Information System">Geographic Information System</option>

   <option value="Geography">Geography</option>

   <option value="Guidiance and Counselling">Guidiance and Counselling</option>

   <option value="Haematology and Blood Transfusion">Haematology and Blood Transfusion</option>

   <option value="Health Education">Health Education</option>

   <option value="History">History</option>

   <option value="History and Strategic Studies">History and Strategic Studies</option>

   <option value="Home Economics Education">Home Economics Education</option>

   <option value="Human Kinetics">Human Kinetics</option>

   <option value="Human Kinetics and Health Education">Human Kinetics and Health Education</option>

   <option value="Igbo">Igbo</option>

   <option value="Igbo/Linguistics">Igbo/Linguistics</option>

   <option value="Industrial Relation/Personal Management">Industrial Relation/Personal Management</option>

   <option value="Industrial Relations &amp; Personnel Management">Industrial Relations &amp; Personnel Management</option>

   <option value="Insurance">Insurance</option>

   <option value="Languages and Linguistics">Languages and Linguistics</option>

   <option value="Law">Law</option>

   <option value="Linguistics">Linguistics</option>

   <option value="Linguistics and Urhobo">Linguistics and Urhobo</option>

   <option value="Linguistics/Yoruba">Linguistics/Yoruba</option>

   <option value="Management">Management</option>

   <option value="Marine Biology &amp; Fisheries">Marine Biology &amp; Fisheries</option>

   <option value="Marketing">Marketing</option>

   <option value="Mass Communication">Mass Communication</option>

   <option value="Mathematics">Mathematics</option>

   <option value="Mechanical Engineering">Mechanical Engineering</option>

   <option value="Medical Microbiology and Parasitology">Medical Microbiology and Parasitology</option>

   <option value="Medical Physics">Medical Physics</option>

   <option value="Medicine and Surgery">Medicine and Surgery</option>

   <option value="Metallurgical and Materials Engineering">Metallurgical and Materials Engineering</option>

   <option value="Microbiology">Microbiology</option>

   <option value="Music">Music</option>

   <option value="Natural Resources Conservation">Natural Resources Conservation</option>

   <option value="Office Management & Technology">Office Management & Technology</option>

   <option value="Operations Research">Operations Research</option>

   <option value="Parasitology &amp; Bioinformatics">Parasitology &amp; Bioinformatics</option>

   <option value="Petroleum and Gas Engineering">Petroleum and Gas Engineering</option>

   <option value="Pharmaceutics and Pharmaceutical Technology">Pharmaceutics and Pharmaceutical Technology</option>

   <option value="Pharmacognosy">Pharmacognosy</option>

   <option value="Pharmacology">Pharmacology</option>

   <option value="Pharmacy">Pharmacy</option>

   <option value="Philosophy">Philosophy</option>

   <option value="Physics">Physics</option>

   <option value="Physiology">Physiology</option>

   <option value="Physiotherapy">Physiotherapy</option>

   <option value="Political Science">Political Science</option>

   <option value="Psychology">Psychology</option>

   <option value="Public Administration">Public Administration</option>

   <option value="Public Health">Public Health</option>

   <option value="Radiography">Radiography</option>

   <option value="Russian">Russian</option>

   <option value="Secretarial Studies">Secretarial Studies</option>

   <option value="Social Work">Social Work</option>

   <option value="Sociology">Sociology</option>

   <option value="Statistics">Statistics</option>

   <option value="Surveying and Geoinformatics">Surveying and Geoinformatics</option>

   <option value="System Engineering">System Engineering</option>

   <option value="Technology Education">Technology Education</option>

   <option value="Urban and Regional Planning">Urban and Regional Planning</option>

   <option value="Yoruba">Yoruba</option>

   <option value="Zoology">Zoology</option>

  ';
}

function list_relationship()
{
  echo '<option value="Husband">Husband</option>
        <option value="Wife">Wife</option>
        <option value="Father">Father</option>
        <option value="Mother">Mother</option>
        <option value="Daughter">Daughter</option>
        <option value="Son">Son</option>
        <option value="Brother">Brother</option>
        <option value="Sister">Sister</option>
        <option value="Aunt">Aunt</option>
        <option value="Uncle">Uncle</option>
        <option value="Niece">Niece</option>
        <option value="Nephew">Nephew</option>
        <option value="Cousin(female)">Cousin(female)</option>
        <option value="Cousin(male)">Cousin(male)</option>
        <option value="Grandmother">Grandmother</option>
        <option value="Grandfather">Grandfather</option>
        <option value="Stepsister">Stepsister</option>
        <option value="Stepbrother">Stepbrother</option>
        <option value="Stepmother">Stepmother</option>
        <option value="Stepfather">Stepfather</option>';
}

function list_industry()

{
  return list_val('category', 'industry', 'industry');
}

function list_experience()

{

  echo '

	<option value="0">None</option>

	<option value="0-1yr">0-1yr</option>

	<option value="1-2yrs">1-2yrs</option>

	<option value="2">2-3yrs</option>

	<option value="2-3yrs">3-4yrs</option>

	<option value="4-5yrs">4-5yrs</option>

	<option value="5 yrs and above">5 yrs and above</option>';
}

function list_cert()
{
  echo '<option value="ICAN - Accounting">ICAN - Accounting</option>
   <option value="ACCA - Accounting">ACCA - Accounting</option>
   <option value="ANAN - Accounting">ANAN - Accounting</option>
   <option value="CISA - Audit">CISA - Audit</option>
   <option value="CIA - Audit">CIA - Audit</option>
   <option value="CFA - Finance">CFA - Finance</option>
   <option value="CRE - Risk">CRE - Risk</option>
   <option value="CITN -Tax">CITN -Tax</option>
   <option value="CIS">CIS</option>
   <option value="ACIPM - HR">ACIPM - HR</option>
   <option value="ACIPD -HR">ACIPD -HR</option>
   <option value="SPHRi - HR">SPHRi - HR</option>
   <option value="GPHR - HR">GPHR - HR</option>
   <option value="PHRi - HR">PHRi - HR</option>
   <option value="PMP - Project Mgt">PMP - Project Mgt</option>
   <option value="Prince II - Project Mgt">Prince II - Project Mgt
   </option>
   <option value="NIM - Management">NIM - Management</option>
   <option value="COREN - Engineers">COREN - Engineers</option>
   <option value="CIPS - Supply Chain">CIPS - Supply Chain</option>
   <option value="NEBOSH: IOSH - EHSSQ">NEBOSH: IOSH - EHSSQ
   </option>
   <option value="NEBOSH: IOGC - EHSSQ">NEBOSH: IOGC - EHSSQ
   </option>
   <option value="NEBOSH: IGC - EHSSQ">NEBOSH: IGC - EHSSQ</option>
   <option value="ITIL - IT">ITIL - IT</option>
   <option value="CISCO - IT">CISSP - IT</option>
   <option value="VMware - IT">JAVA - IT</option>';
}


function list_comment_options()
{
  echo '<option>Not qualified</option>
   <option>Would do better in another role</option>
   <option>Not presentable</option>';
}

function get_stage_subject($stage)
{
  if ($stage == 'First Level Interview' || $stage == 'Second Level Interview') {
    return $stage;
  } elseif ($stage == 'Assessment') {

    return 'You have been scheduled for a Test';
  } else {
    return 'Update on your Job Application';
  }
}

function request_report($query, $col, $col_val)
{
  global $db;
  $query_run = "$query and $col = '$col_val'";
  $result = mysqli_query($db, $query_run);
  $num = mysqli_num_rows($result);
  return $num;
}

function request_client()
{
  global $db;
  $query_run = "select distinct client_id from job_post";
  $result = mysqli_query($db, $query_run);
  $num = mysqli_num_rows($result);

  for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_array($result);
    echo '<option value="' . $row['client_id'] . '">' . get_client_name($row['client_id']) . '</option>';
  }
}


function export_to_recruiter($id)
{
  //if parameter is an array use it else make it an array
  if (is_array($id)) {
    $jobs_applied_id = $id;
  } else {
    $jobs_applied_id = explode(',', $id);
  }


  global $db;

  // Filter the excel data
  function filterData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // Excel file name for download
  $fileName = get_fullname($_SESSION['Klin_admin_user']) . "_Applicants" . ' ' . date('Y-m-d') . ' ' . ".xls";

  $fields = array('ID', 'FIRST NAME', 'LAST NAME', 'EMAIL', 'PHONE', 'GENDER', 'AGE', 'STATE', 'JOB TITLE', 'QUALIFICATION', 'CLASS DEGREE', 'DATE APPLIED');

  // Display column names as first row
  $excelData = implode("\t", array_values($fields)) . "\n";

  for ($i = 0; $i < count($jobs_applied_id); $i++) {
    $id_list[] = " or id = '" . $jobs_applied_id[$i] . "'";
  }
  $clause = implode('', $id_list);
  $query = $db->query("SELECT * FROM jobs_applied where id = '" . $jobs_applied_id[0] . "' " . $clause);



  if ($query->num_rows > 0) {
    // Output each row of the data
    while ($row = $query->fetch_assoc()) {
      // $status = ($row['status'] == 1)?'Active':'Inactive';
      $lineData = array($row['id'], $row['firstname'], $row['lastname'], $row['email'], $row['phone'], $row['gender'], $row['age'], $row['state'], $row['job_title'], $row['qualification'], $row['class_degree'], $row['date_applied']);
      array_walk($lineData, 'filterData');
      $excelData .= implode("\t", array_values($lineData)) . "\n";
    }
  } else {
    $excelData .= 'No records found...' . "\n";
  }

  // Headers for download

  header("Content-Type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=\"$fileName\"");
  //Save file
  $exported_file = 'upload/exports/' . $fileName;
  $myfile = fopen($exported_file, "w");
  fwrite($myfile, $excelData);
  fclose($myfile);

  //Send mail to admin user
  $sub = 'Candidates Moved for Second Level Interview';
  $message = 'Attached is the list of candidates moved for second level interview';
  send_email(Klin_admin_email(), get_fullname(Klin_admin_email()), 'Outsoource Hr', $sub, $message, $exported_file);
}

function move_file_to_folder($candidate_id, $firstname, $lastname, $job_title, $folder)
{
  global $db;
  $query = "select * from credentials where candidate_id='$candidate_id' and document = 'CV'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);

  $file = 'document/' . $row['filepath'];

  if (file_exists($file)) {
    $newfile_location = $folder . '/' . strtoupper($firstname . ' ' . $lastname . ' ' . $job_title) . '_' . $row['filepath'];

    //copy credentials to new location
    copy($file, $newfile_location);

    return $newfile_location;
  }
}


function createZipArchive($files = array(), $destination = '', $overwrite = false)
{

  if (file_exists($destination) && !$overwrite) {
    return false;
  }

  $validFiles = array();
  if (is_array($files)) {
    foreach ($files as $file) {
      if (file_exists($file)) {
        $validFiles[] = $file;
      }
    }
  }

  if (count($validFiles)) {
    $zip = new ZipArchive();
    if ($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) == true) {
      foreach ($validFiles as $file) {
        $zip->addFile($file, $file);
      }
      $zip->close();
      return file_exists($destination);
    } else {
      return false;
    }
  } else {
    return false;
  }
}


//  function rq_company_name()

//  {

//    return 'U-Connect-Ng Limited';	

//  }


function rq_company_phone()

{

  return '083888388883';
}

function rq_company_email()

{

  return 'solution@Klinhr.com.ng';
}


function rq_get_staff_company($user)
{
  global $db;
  $query = "select * from emp_self_login where user = '$user'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['client_code'];
}

function HrName($user)
{
  global $db;
  $query = "select * from login where client like '%" . ($user) . "%' ";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  return $row['firstname'] . ' ' . $row['lastname'];
}

function HrEmail($user)
{
  global $db;
  $query = "select * from login where client like '%" . ($user) . "%' ";
  $result = mysqli_query($db, $query);
  $num = mysqli_num_rows($result);
  $row = mysqli_fetch_array($result);

  return $row['email'];
}

function rq_get_hr_email($client_code)
{

  global $db;

  //  $client_code= $_SESSION['client_code'];

  $query_cl = "select * from clients where client_code LIKE '$client_code'";
  $result_cl = mysqli_query($db, $query_cl);
  $row_cl = mysqli_fetch_array($result_cl);
  $client_email = $row_cl['email'];

  return $client_email;
}

function rq_get_no_of_days($outstanding_days)
{

  global $db;
  ob_start();
session_start();
  $staff_id = $_SESSION['staff_id'];

  echo $query_cl = "select * from emp_leave_planner where staff_id = '$staff_id'";
  $result_cl = mysqli_query($db, $query_cl);
  $row_cl = mysqli_fetch_array($result_cl);
  $outstanding_days = $row_cl['outstanding_days'];

  return $outstanding_days;
}


function rq_get_client_name($client_code)
{


  global $db;
  ob_start();
session_start();
  //  $client_code= $_SESSION['client_code'];

  $query_cl = "select * from clients where client_code LIKE '$client_code'";
  $result_cl = mysqli_query($db, $query_cl);
  $row_cl = mysqli_fetch_array($result_cl);
  $client_name = $row_cl['contact_person'];

  return $client_name;
}

function rq_get_name($staff_id)
{

  global $db;

  $query = "select * from emp_self_login where staff_id= '$staff_id'";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result);
  $name = $row['names'];

  return ucwords($name);
}

// functions from uconnect
function status($status)
{
  if ($status == 'active') {

    echo '<i class="fa fa-check-circle" style="font-size:30px;color:green;"></i>';
  } else {

    echo '<i class="fa fa-pause" style="font-size:30px;color:red;"></i>';
  }
}
function fa_status($status)
{
  if ($status == 'done') {

    echo '<i class="bi-check-circle" style="font-size:30px;color:green;"></i>';
  } elseif ($status == 'denied') {
    echo '<i class="" style="font-size:15px;color:red;">Leave Denied</i>';
  } else {

    echo '<i class="bi-pause" style="font-size:30px;color:red;"></i>';
  }
}

function search_leave_priviledge($priviledge)
{
  $priviledge = explode(',', $_SESSION['privilege_user']);
  return $clause = implode("%' and leave_type != 'Leave Resumption' or access_type like '%", $priviledge);
}
function user_privilege($privilege)
{
  $privilege = explode(',', $_SESSION['privilege']);
  return $clause = implode("%' or privilege like '%", $privilege);
}
function download_privilege($priviledge)
{
  $priviledge = explode(',', $_SESSION['client_code']);
  return $clause = implode("%' or access_type like '%", $priviledge);
}
function get_priviledge($priviledge)
{
  $priviledge = explode(',', $_SESSION['privilege_user']);
  return $clause = implode("%' or access_type like '%", $priviledge);
}

function get_priviledge_2($priviledge)
{
  $priviledge = explode(',', $_SESSION['privilege_user']);
  return $clause = implode("%' or company_code like '%", $priviledge);
}
function get_priviledge_3($priviledge)
{
  $priviledge = explode(',', $_SESSION['privilege_user']);
  return $clause = implode("%' or client_code like '%", $priviledge);
}
function get_priviledge_4($client)
{
  $priviledge = explode(',', $client);
  return $clause = implode("%' or client_name like '%", $priviledge);
}
function get_priviledge_5($client_code)
{
  // $priviledge = explode(',',$client_code);
  $priviledge = "SELECT GROUP_CONCAT(clients) ";
  return $priviledge;
}

function staff_id($candidate_id, $id_format)
{

  if (strlen($candidate_id) == 1) {
    $candidate_id = '00' . $candidate_id;
  } elseif (strlen($candidate_id) == 2) {
    $candidate_id = '0' . $candidate_id;
  } elseif (strlen($candidate_id) == 3) {
    $candidate_id = $candidate_id;
  } elseif (strlen($candidate_id) == 4) {
    $candidate_id = $candidate_id;
  } else {
    return $candidate_id;
  }
  $year = date('y');
  $format_year =  str_replace('{YY}', $year, $id_format);
  $return_val = str_replace('{ID}', $candidate_id, $format_year);
  return $return_val;
}

function get_staff_id($candidate_id)
{
  global $db;
  $query = "select * from emp_staff_details where id='$candidate_id'";

  $result = mysqli_query($db, $query);

  $row = mysqli_fetch_array($result);

  return $row['staff_id'];
}




function fixed_score()

{
  global $db;
  $query = "select sum(weight) from fixed_q";

  $result = mysqli_query($db, $query);

  $row = mysqli_fetch_array($result);

  $total = 100 - $row[0];



  return $total;
}
function table_row($tab)

{
  global $db;
  if ($tab == 'custom_q') {
    $query = "select * from $tab where role = '" . $_SESSION['role'] . "' and user = '" . $_SESSION['Klin_admin_user'] . "'";
    // $query = "select * from $tab where role = '$role' and user = '".$_SESSION['Klin_admin_user']."'";
  } else {
    $query = "select * from $tab";
  }

  $result = mysqli_query($db, $query);

  $num_result = mysqli_num_rows($result);

  return $num_result;
}


function search_priviledge($priviledge)

{
  $priviledge = explode(',', $_SESSION['privilege_user']);

  return $clause = implode("%' or access_type like '%", $priviledge);
}
function total_schedule($staff_id)

{
  global $db;
  $query = "select * from emp_leave_planner where staff_id='$staff_id' and current_year = '" . year() . "'";

  $result = mysqli_query($db, $query);


  $num_result = mysqli_num_rows($result);

  $row = mysqli_fetch_array($result);

  return $row['scheduled_days'];
}

function insert_leave($staff_id, $leave)

{

  global $db;
  $query = "insert into emp_leave_planner values ('', '" . $staff_id . "','" . $leave . "', '', '" . $leave . "', '" . year() . "')";

  mysqli_query($db, $query);


  //Remove column name

  // mysqli_query($db,"delete from self_leave_planner where staff_id = 'staff_id'");

}

function get_leave_days($staff_id)

{
  global $db;

  $query = "select * from emp_leave_planner where staff_id='$staff_id' and current_year = '" . year() . "'";

  $result = mysqli_query($db, $query);

  $row = mysqli_fetch_array($result);

  return $row['total_days'];
}


function update_status($tab, $id, $status)

{
  global $db;
  $query = "update $tab set status = '$status' where id= '" . $id . "'";
  mysqli_query($db, $query);
}

function get_access_type($user)

{
  global $db;
  $query = "select * from emp_self_login where user='$user'";

  $result = mysqli_query($db, $query);

  $row = mysqli_fetch_array($result);

  return $row['priviledge'];
}

function delete_leave_details($staff_id, $start_date, $end_date)

{
  global $db;
  $diff = date_difference(strtotime($start_date), strtotime($end_date));



  //update schedule table

  $query2 = "update `emp_leave_planner` set scheduled_days= scheduled_days-$diff, outstanding_days=outstanding_days+$diff where staff_id='$staff_id'";

  mysqli_query($db, $query2);
}
function date_difference($start, $end)
{

  $datediff = $end - $start;
  return floor($datediff / (60 * 60 * 24));
}


function get_emails($staff_id)

{
  global $db;
  $query = "select * from emp_self_login where staff_id='$staff_id'";
  $result = mysqli_query($db, $query);
  $num_result = mysqli_num_rows($result);

  $row = mysqli_fetch_array($result);
  return $row['email'];
}

function mail_approval($approval_type, $staff_id, $names, $leave_type, $start_date, $end_date, $purpose, $manager_email, $reason, $user_priviledge)

{



  if (!$reason) {

    $reason = 'Not stated';
  }



  //get client details and assign email variables/

  $to = get_emails($staff_id);

  $subject = $names . ' <br>Leave application has been ' . $approval_type;

  $mailcontent  = '<br>Hello ' . $names . ',

				<br><br>Your Leave application has been <strong>' . $approval_type . '</strong>. See details below:<br><br>

				Start Date: ' . long_date($start_date) . "<br>"

    . 'End Date: ' . long_date($end_date) . "<br>"

    . 'Type of leave: ' . $leave_type . "<br>"

    . 'Purpose: ' . $purpose . "<br><br>"

    . 'Reason: ' . $reason . "<br><br>"

    . 'For any information or clarification, please send us an email: ' . hr_email($user_priviledge);

  send_email($to, $names, organisation(), $subject, $mailcontent);


  $mail_supervisor  = '<br><br>' . $names . ' leave has been <strong>' . $approval_type . '</strong>.<br> See details below:<br><br>

				Start Date: ' . long_date($start_date) . "<br>"

    . 'End Date: ' . long_date($end_date) . "<br>"

    . 'Type of leave: ' . $leave_type . "<br>"

    . 'Purpose: ' . $purpose . "<br><br>"

    . 'Reason: ' . $reason . "<br><br>"

    . 'For any information or clarification, please send us an email: ' . hr_email($user_priviledge);

  send_email($manager_email, 'Supervisor/Manager', organisation(), 'Leave Approval for ' . $names, $mail_supervisor);
}

function hr_email($user_type)

{
  global $db;
  $query = "select * from emp_self_login where user_type='staff' and priviledge like '%" . $user_type . "%'";

  $result = mysqli_query($db, $query);

  $row = mysqli_fetch_array($result);

  return $row['email'];
}

function get_names($staff_id)

{

  global $db;
  $query = "select * from emp_self_login where user='$staff_id'";

  $result = mysqli_query($db, $query);



  $row = mysqli_fetch_array($result);

  return $row['names'];
}

//  functions end
function admin_email()
{
  return 'akerelejohn6@gmail.com,john@aledoyhost.com';
}

// function send_sms($to,$message)
// {

// $msg = str_replace(' ', '+', $message);

// $url = "https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=fYvkXgZB4FjCVFLVQNtjykhNGt1fJm0Xqp0juIYFlsopzQxHeO14Yhw6xKMZ&from=".org()."&to=$to&body=$msg&dnd=2";

// $f = @fopen($url, "r");
// $answer = fgets($f, 255);

// }

function send_job_approval($to, $job_post, $fromName, $subject, $message)
{



  // Mail Template
  $mailcontent  = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:500,700,400,300" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
</head>

<body style="font-family: Calibri;">
<div style="width:100%; background-color:#FFF; padding:20px;">
	<div style="width:100%; margin:auto; padding:10px; background:#FFFFFF;">
    	 <div style="clear:both"></div>

         	<div id="white_area" style="background-color:#FFFFFF; ">
			<div style="font-size:16px; color:#010E42; padding-top:10px;">

			<div>
			<div style="margin-bottom:15px;" id="username">


				<p>Hello Admin,</p>
				<p>' . $job_post . ' posted a new job.</p>
			</div>
			</div>

			<div style="font-size:16px;"> <p></p>' . $message . '

			</div>
			<br>
		   </div>
       	   </div><!-- White area ends here -->
    <div style="color:#FFF; margin-top:20px; margin-bottom:20px;">
    	<div style="text-align:center; font-size:36px;"></div>
    </div>

    <div style="clear:both;"></div>

    <div style="clear:both;"></div>
    </div>
</div>
</body>
</html>';

  // More headers
  //    $headers = "MIME-Version: 1.0" . "\r\n";
  //    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

  //    // More headers
  //    $headers .= "From: $fromName <".sender_email().">";
  //mail($to, $subject, $mailcontent, $headers);



  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->Port = 465;
  $mail->SMTPAuth = true;
  //sendgrid
  $mail->Username = 'newsletter@aledoyhost.com';
  $mail->Password = 'Aledoy101!';  //yahoo app password for noreply email 
  $mail->Host = 'mail.aledoyhost.com';
  $mail->SMTPSecure = 'ssl';
  $mail->From = sender_email();
  $mail->FromName = $fromName;
  $mail->AddAddress($to);

  //  $mail->MsgHTML($sbody);
  $mail->CharSet = 'UTF-8';
  $mail->IsHTML(true);
  $mail->Body    = $mailcontent;
  $mail->Subject = $subject;
  $mail->IsHTML(true);
  $mail->Send();

  return $mailcontent;
}


///
function send_email($to, $name, $fromName, $subject, $message, $attach = 'nofile')
{

  // Mail Template
  $mailcontent  = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:500,700,400,300" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
</head>

<body style="font-family: Calibri;">
<div style="width:100%; background-color:#FFF; padding:20px;">
	<div style="width:100%; margin:auto; padding:10px; background:#FFFFFF;">
    	 <div style="clear:both"></div>
         
         	<div id="white_area" style="background-color:#FFFFFF; ">
			<div style="font-size:16px; color:#010E42; padding-top:10px;">
			
			<div>
			<div style="margin-bottom:15px;" id="username">
            <input type="image" src="' . root() . '/../outsourcehr-admin/uploads/JOB<?= client_detail('client_logo')?>"
style="width:150px;" />

<p>Dear ' . ucwords($name) . ',</p>

</div>
</div>

<div style="font-size:16px;">
    <p></p>' . $message . '
    <p>Best Regards,<br>Klin Hr Team<br><br>

    </p>
</div>
<br>
</div>
</div><!-- White area ends here -->
<div style="color:#FFF; margin-top:20px; margin-bottom:20px;">
    <div style="text-align:center; font-size:36px;"></div>
</div>

<div style="clear:both;"></div>

<div id="copyright" style="font-size:13px; margin-top:5px;">Copyright &copy; - ' . date('Y') . '. ' . organisation() . '
</div>
<div style="clear:both;"></div>
</div>
</div>
</body>

</html>';




$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Port = 2525;
$mail->SMTPAuth = true;
//sendgrid
$mail->Username = 'domains@aledoy.com';
$mail->Password = 'ADBA19CD382F5E991BCA2F02CA5F461D68D4'; //yahoo app password for noreply email
$mail->Host = 'smtp.elasticemail.com';
$mail->SMTPSecure = 'tls';

$mail->From = 'domains@aledoy.com';
$mail->FromName = $fromName;
$mail->AddAddress($to);

$mail->CharSet = 'UTF-8';
$mail->IsHTML(true);
$mail->Body = $mailcontent;
$mail->Subject = $subject;
$mail->IsHTML(true);
$mail->Send();

return $mailcontent;
}


function mail_candidate($to, $subject, $message)
{


// Mail Template
$mailcontent = '<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:500,700,400,300" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
</head>

<body style="font-family: Calibri;">
    <div style="width:100%; background-color:#FFF; padding:20px;">
        <div style="width:100%; margin:auto; padding:10px; background:#FFFFFF;">
            <div style="clear:both"></div>

            <div id="white_area" style="background-color:#FFFFFF; ">
                <div style="font-size:16px; color:#010E42; padding-top:10px;">

                    <div>
                        <div style="margin-bottom:15px;" id="username">
                            <input type="image" src="' . root() . '/images/Klin.png" style="width:150px;" />
                        </div>

                    </div>

                    <div style="font-size:16px;">
                        <p></p>' . $message . '

                    </div>
                    <br>
                </div>
            </div><!-- White area ends here -->
            <div style="color:#FFF; margin-top:20px; margin-bottom:20px;">
                <div style="text-align:center; font-size:36px;"></div>
            </div>

            <div style="clear:both;"></div>


            <div style="clear:both;"></div>
        </div>
    </div>
</body>

</html>';

// // // More headers
// // $headers = "MIME-Version: 1.0" . "\r\n";
// // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// // // More headers
// // $headers .= "From: ".organisation()." <".sender_email().">";
    // // //mail($to, $subject, $mailcontent, $headers);



    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    //sendgrid
    $mail->Username = 'noreply@ecardnaija.com';
    $mail->Password = 'Aledoy101!'; //yahoo app password for noreply email
    $mail->Host = 'smtp.office365.com';
    $mail->SMTPSecure = 'tls';
    $mail->From = sender_email();
    $mail->FromName = sender_name();
    $mail->AddAddress($to);

    // $mail->MsgHTML($body);
    $mail->CharSet = 'UTF-8';
    $mail->IsHTML(true);
    $mail->Body = $mailcontent;
    $mail->Subject = $subject;
    $mail->IsHTML(true);
    $mail->Send();

    return $mailcontent;
    }

    function mail_client($to, $cc, $subject, $message, $file)
    {


    // Mail Template
    $mailcontent = '<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:500,700,400,300" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
    </head>

    <body style="font-family: Calibri;">
        <div style="width:100%; background-color:#FFF; padding:20px;">
            <div style="width:100%; margin:auto; padding:10px; background:#FFFFFF;">
                <div style="clear:both"></div>

                <div id="white_area" style="background-color:#FFFFFF; ">
                    <div style="font-size:16px; color:#010E42; padding-top:10px;">

                        <div>
                            <div style="margin-bottom:15px;" id="username">
                                <input type="image" src="' . root() . '/images/Klin.png" style="width:150px;" />



                            </div>
                        </div>

                        <div style="font-size:16px;">
                            <p></p>' . $message . '
                            <p>Best Regards,<br>Klin Consulting Team<br><br>

                            </p>
                        </div>
                        <br>
                    </div>
                </div><!-- White area ends here -->
                <div style="color:#FFF; margin-top:20px; margin-bottom:20px;">
                    <div style="text-align:center; font-size:36px;"></div>
                </div>

                <div style="clear:both;"></div>

                <div id="copyright" style="font-size:13px; margin-top:5px;">Copyright &copy; - ' . date('Y') . '. ' .
                    organisation() . '</div>
                <div style="clear:both;"></div>
            </div>
        </div>
    </body>

    </html>';


    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    //sendgrid
    $mail->Username = 'noreply@ecardnaija.com';
    $mail->Password = 'Aledoy101!'; //yahoo app password for noreply email
    $mail->Host = 'smtp.office365.com';
    $mail->SMTPSecure = 'tls';
    $mail->From = sender_email();
    if ($file) {
    $mail->addAttachment($file);
    }
    $mail->FromName = organisation();
    $mail->AddAddress($to);
    $mail->addCC($cc);

    //$mail->MsgHTML($sbody);
    $mail->CharSet = 'UTF-8';
    $mail->IsHTML(true);
    $mail->Body = $mailcontent;
    $mail->Subject = $subject;
    $mail->IsHTML(true);
    $mail->Send();

    return $mailcontent;
    }