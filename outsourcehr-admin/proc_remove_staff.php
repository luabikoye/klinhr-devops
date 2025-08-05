<?php 

ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');


if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}


$reason = $_POST['reason'];
$id = $_POST['id'];

$staff_id = get_val('emp_staff_details','id',$id,'staff_id');
$firstname = get_val('emp_staff_details','id',$id,'firstname');
$surname = get_val('emp_staff_details','id',$id,'surname');
$middlename = get_val('emp_staff_details','id',$id, 'middlename');
$email = get_val('emp_staff_details','id',$id, 'email_address');
$phone = get_val('emp_staff_details','id',$id, 'mobile_phone_number');
$name = $firstname.' '.$middlename.' '.$surname;

if ($reason == 'Did not Resume' || $reason == 'Resigned' || $reason == 'Terminated') {
  $reson_insert = "insert into emp_resignation set staff_id = '$staff_id', names = '$name', email = '$email', phone = '$phone',reason = '$reason',author = '".$_SESSION['Klin_admin_user']."'";
    $reason_result = mysqli_query($db,$reson_insert);
}

$query = "update employees set emp_status = 'inactive' where staff_id ='$staff_id'";
$result = mysqli_query($db,$query);

$query2 = "update emp_staff_details set staff = 'no' where staff_id ='$staff_id'";
$result2 = mysqli_query($db,$query2);

if ($result) {
    header("Location: staff-list?success=1");
}
else {
    header("location:staff-list?error=1");
}





?>