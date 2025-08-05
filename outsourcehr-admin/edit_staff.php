<?php



ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');

if (isset($_POST['btn_edit'])) {
    $id = $_POST['id'];
    $names = mysqli_real_escape_string($db, $_POST['names']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $client = mysqli_real_escape_string($db, $_POST['client']);
    $leave = mysqli_real_escape_string($db, $_POST['leave']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);

    $staff_id = mysqli_real_escape_string($db, $_POST['staff_id']);

    $status = mysqli_real_escape_string($db, $_POST['status']);
    $reason = mysqli_real_escape_string($db, $_POST['reason']);
    $info = mysqli_real_escape_string($db, $_POST['info']);
    $date = mysqli_real_escape_string($db, $_POST['date']);
    
    if ($_POST['status'] == 'Yes') {
        $status == 'active';
    }

    if ($_POST['status']) {
      echo  $sql_1 = "update emp_staff_details set status = '$status'  where staff_id = '$staff_id' "; exit;
        $result_1 = $db->query($sql_1);
        $letter = $_FILES['letter']['tmp'];
        $letter_name = $_FILES['letter']['name'];
        if ($letter_name) {
            $ext = strtolower(pathinfo($letter_name, PATHINFO_EXTENSION));
            $uploaded_image = '../staffportal/uploads/resignation/upload_letter/' . 'upload_letter' . $id . '.' . $ext;
        }
        if ($_POST['status'] == 'resigned') {
            "INSERT INTO emp_resignation SET reason = '$reason', date = '$date', additional_info = '$info', names = '$names', email = '$email', staff_id = '$staff_id', phone = '$phone', access_type = '$client', img_path = '$uploaded_image'";
            $resign = mysqli_query($db, "INSERT INTO emp_resignation SET reason = '$reason', date = '$date', additional_info = '$info', names = '$names', email = '$email', staff_id = '$staff_id', phone = '$phone', access_type = '$client', image_path = '$uploaded_image'");
            activity_log($_SESSION['Klin_admin_user'], "Resigned $names");
        }
    }

    $query = "update emp_self_login set names = '$names', pass = '$password', email = '$email', client_code = '$client' where id = '$id' ";
    $result = $db->query($query);
    if ($result) {

        $sql = "update emp_leave_planner set total_days = '$leave', outstanding_days = '$leave'  where staff_id = '$staff_id' ";
        $result1 = $db->query($sql);



        $success = "Staff  successfully edited";
        include('staff-mgt.php');
        exit;
    } else {
        $error = "You cannot edit this staff at this time, try again later";
        include('staff-mgt.php');
        exit;
    }
} else {
    header('location: staff-mgt');
    exit;
}