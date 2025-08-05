<?php
ob_start();
session_start();


include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}


$band = $_POST['band'];
$client = $_POST['client'];


if ($_POST['salary']) {
    $salary = $_POST['salary'];
} else {
    $salary = 0;
}


$select = "select * from salary_band where client = '$client' && band = '$band'";

$res = mysqli_query($db, $select);

$num = mysqli_num_rows($res);

if ($num == 0) {


    $select = "select * from settings where band = 'default'";
    $sel_result = mysqli_query($db, $select);
    $row = mysqli_fetch_array($sel_result);



    $basic = $row['basic'];
    $housing = $row['housing'];
    $transport = $row['transport'];
    $meals = $row['meals'];
    $utility = $row['utility'];
    $leave_allo = $row['leave_allo'];
    $comp_stat_cont = $row['comp_stat_cont'];
    $staff_stat_cont = $row['staff_stat_cont'];
    $loan = $row['loan'];
    $tax = $row['tax'];
    $month_13 = $row['13th_month'];
    $nhf = $row['nhf'];
    $dressing = $row['dressing'];
    $leave_allo = $row['leave_allo'];

    $select1 = "select * from deduct_name where band_name = 'default'";
    $sel_result1 = mysqli_query($db, $select1);
    $select2 = "select * from allowance_name where band_name = 'default'";
    $sel_result2 = mysqli_query($db, $select2);

    $insert = "insert into salary_band set band = '$band', client = '$client', salary = '$salary'";

    $result = mysqli_query($db, $insert);

    if ($result) {
        $query = "insert into settings set basic = '$basic', housing = '$housing', transport = '$transport', meals = '$meals', utility = '$utility', leave_allo = '$leave_allo', band = '$band', comp_stat_cont = '$comp_stat_cont', staff_stat_cont = '$staff_stat_cont', loan = '$loan', tax = '$tax',13th_month = '$month_13', nhf = '$nhf', dressing = '$dressing',client = '$client'";
        $result_que = mysqli_query($db, $query);

        //     if ($result_que) {
        //         $select1 = "select * from deduct_name where band_name = 'default'";
        //         $sel_result1 = mysqli_query($db, $select1);        
        //         $select2 = "select * from allowance_name where band_name = 'default'";
        //         $sel_result2 = mysqli_query($db, $select2);        
        //         for ($i = 0; $i < 10; $i++) {
        //             $y = $i + 1;
        //             $row1 = mysqli_fetch_array($sel_result1);
        //             $row2 = mysqli_fetch_array($sel_result2);
        //             $deduct[$y] = $row1["deduct_name"];
        //             $allow[$y] = $row2["allowance_name"];
        //             $ins = "update settings set deduct$y = '$deduct[$y]', allowance$y = '$allow[$y]' where client = '$client';";
        //             $resulted = mysqli_query($db, $ins);

        //         }

        // }
        header('Location:salary_band?client=' . base64_encode($client) . '&msg=sucsess');
    } else {
        header('Location:salary_band?client=' . base64_encode($client) . '&msg=error');
    }
} else {
    header('Location:salary_band?client=' . base64_encode($client) . '&msg1=error');
}
