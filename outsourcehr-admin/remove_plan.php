<?php

ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');


validatePermission('Hr Operations');
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

    $id = $_GET['id'];
    $date_diff = $_GET['date_diff'];
    $staff_id = $_GET['staff_id'];
    $names = get_val('emp_self_login', 'staff_id', $staff_id, 'names');

     $query = "update emp_leave_form set status = 'denied' where id = '$id'";
    $result = mysqli_query($db,$query);
    if($result)
    {
     echo   $query2 = "update `emp_leave_planner` set scheduled_days= scheduled_days-$date_diff, outstanding_days=outstanding_days+$date_diff where staff_id='$staff_id'";
        mysqli_query($db,$query2);

        activity_log($_SESSION['Klin_admin_user'], "Cancelled leave for : $names($staff_id) ");

        
        header("Location: leave-application?leave=cancel");	 
    }

?>