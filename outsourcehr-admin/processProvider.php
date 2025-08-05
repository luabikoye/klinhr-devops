<?php
ob_start();
session_start();


include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}



if (isset($_POST['submitSettings'])) {

    $pfa = $_POST['pfa'];
    $pfc = $_POST['pfc'];
    $acc_name = $_POST['account_name'];
    $code = $_POST['code'];
    $acc_no = $_POST['account_number'];
    $provider = $_POST['provider'];

    $query = mysqli_query($db, "select * from pension_provider where provider = '$provider'");
    $num = mysqli_num_rows($query);
    if ($num > 0) {

        mysqli_query($db, "update pension_provider set pfa = '$pfa', pfc = '$pfc', account_name = '$acc_name', code = '$code', account_number = '$acc_no' where provider = '$provider'");

        header('Location:schedule-setting?msg=1');
        exit;
    } else {

        mysqli_query($db, "insert into pension_provider set pfa = '$pfa', pfc = '$pfc', account_name = '$acc_name', code = '$code', account_number = '$acc_no', provider = '$provider'");

        header('Location:schedule-setting?msg=1');
        exit;
    }
} else {
    header('Location: schedule-setting?err');
    exit;
}
