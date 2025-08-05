<?php


ob_start();
session_start();

include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
// include('timeout.php');
// SessionCheck();

$id = base64_decode($_GET['id']);
$tab = base64_decode($_GET['tab']);
$return = base64_decode($_GET['return']);



if (base64_decode($_GET['section']) == 'my-credentials') {
    // query to check if the user deletes his/her cv, if so, it should update the status
    $check_file = "select * from $tab where id = '$id' ";
    $file_result = mysqli_query($db, $check_file);
    $file_row = mysqli_fetch_array($file_result);
    if ($file_row['document'] == 'CV') {
        $update_query = "update jobseeker set completed = 'none', cv = '' where candidate_id = '" . $file_row['candidate_id'] . "' ";
        $update_result = mysqli_query($db, $update_query);
    }

    $delete_query_1 = "delete from $tab where id = '$id'  ";
    $delete_result_2 = mysqli_query($db, $delete_query_1);
    if ($delete_result_2) {
        header("Location: $return?del=success");
        exit;
    } else {
        header("Location: $return?del=failed");
        exit;
    }
}

if (base64_decode($_GET['section']) == 'notification') {

    $query = "update notification set deleted = 'Deleted', status = 'Read' where id = '$id'";
    $result = mysqli_query($db, $query);
    if ($result) {
        $success = "Notification was successfully deleted";
        include('notification.php');
        exit;
    } else {
        $error = "Notification cannot be deleted";
        include('notification.php');
        exit;
    }
}
