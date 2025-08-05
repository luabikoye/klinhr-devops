<?php
ob_start();
session_start();


include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

$cop_stat = mysqli_real_escape_string($db, $_POST['comp_stat_cont']);
$staff_stat = mysqli_real_escape_string($db, $_POST['staff_stat_cont']);

$deduct = $_POST['deduct'];
$deducted = $_POST['deducted'];
$result = array_filter($deducted);
$deducted = array_values($result);
$deduct_result = array_filter($deduct);
$deduct = array_values($deduct_result);
// print_r($deduct);
// exit;
$count_deduct = count($deducted);

$deduct1 = $deduct[0];
$deduct2 = $deduct[1];
$deduct3 = $deduct[2];
$deduct4 = $deduct[3];
$deduct5 = $deduct[4];
$deduct6 = $deduct[5];
$deduct7 = $deduct[6];
$deduct8 = $deduct[7];
$deduct9 = $deduct[8];
$deduct10 = $deduct[9];

$allow = $_POST['allow'];
$allowed = $_POST['allowed'];


$result = array_filter($allowed);
$allowed = array_values($result);
$count_allow = count($allowed);

$allow1 = $allow[0];
$allow2 = $allow[1];
$allow3 = $allow[2];
$allow4 = $allow[3];
$allow5 = $allow[4];
$allow6 = $allow[5];
$allow7 = $allow[6];
$allow8 = $allow[7];
$allow9 = $allow[8];
$allow10 = $allow[9];





if ($_POST['basic']) {
    $basic = mysqli_real_escape_string($db, $_POST['basic']);
} else {
    $basic = 0;
}
if ($_POST['housing']) {
    $house = mysqli_real_escape_string($db, $_POST['housing']);
} else {
    $house = 0;
}
if ($_POST['transport']) {
    $trans = mysqli_real_escape_string($db, $_POST['transport']);
} else {
    $trans = 0;
}
if ($_POST['leave_allo']) {
    $leave = mysqli_real_escape_string($db, $_POST['leave_allo']);
} else {
    $leave = 0;
}
if ($_POST['utility']) {
    $utility = mysqli_real_escape_string($db, $_POST['utility']);
} else {
    $utility = 0;
}
if ($_POST['meals']) {
    $meals = mysqli_real_escape_string($db, $_POST['meals']);
} else {
    $meals = 0;
}
if ($_POST['dressing']) {
    $dress = mysqli_real_escape_string($db, $_POST['dressing']);
} else {
    $dress = 0;
}
if ($_POST['13th_month']) {
    $month13 = mysqli_real_escape_string($db, $_POST['13th_month']);
} else {
    $month13 = 0;
}
$nhf = mysqli_real_escape_string($db, $_POST['nhf']);
$band = mysqli_real_escape_string($db, $_POST['band']);
$client = mysqli_real_escape_string($db, $_POST['client']);
$loan = mysqli_real_escape_string($db, $_POST['loan']);
$tax = mysqli_real_escape_string($db, $_POST['tax']);
$date = date('Y-m-d');

$band_id = get_band_id($band, $client);

$stmt = $db->prepare("DELETE FROM deduct_name WHERE band_name = ?");
$stmt->bind_param("s", $band_id); // Bind user input ($deduct) to statement
$stmt->execute();

//deduct
for ($i = 0; $i < $count_deduct; $i++) {
    $stmt = $db->prepare("INSERT INTO deduct_name SET band_name = ?, deduct_name = ?, deduct_id = ?");
    $stmt->bind_param("sss", $band_id, $deducted[$i], $deduct[$i]); // Bind relevant variables
    $stmt->execute();
}
$stmt = $db->prepare("DELETE FROM allowance_name WHERE band_name = ?");
$stmt->bind_param("s", $band_id); // Bind user input ($deduct) to statement
$stmt->execute();

//deduct
for ($i = 0; $i < $count_allow; $i++) {
    $stmt = $db->prepare("INSERT INTO allowance_name SET band_name = ?, allowance_name = ?, allowance_id = ?");
    $stmt->bind_param("sss", $band_id, $allowed[$i], $allow[$i]); // Bind relevant variables
    $stmt->execute();
}
// exit;

if ($band != "") {
    $qs = mysqli_query($db, "select * from settings where band = '{$_POST['band']}' && client = '$client'");
} else {
    $qs = mysqli_query($db, "select * from settings");
}
$ns = mysqli_num_rows($qs);

if ($ns > 0) {

    if ($band != "") {

        mysqli_query($db, "update settings set comp_stat_cont = '$cop_stat', staff_stat_cont = '$staff_stat',  pen_cop_vol = '$cop_vol', basic = '$basic', housing = '$house', transport = '$trans', leave_allo = '$leave', utility = '$utility', meals = '$meals', dressing = '$dress', 13th_month = '$month13', nhf = '$nhf', date = '$date', tax= '$tax', loan = '$loan', deduct1 = '$deduct1',deduct2 = '$deduct2',deduct3 = '$deduct3',deduct4 = '$deduct4',deduct5 = '$deduct5',deduct6 = '$deduct6',deduct7 = '$deduct7',deduct8 = '$deduct8',deduct9 = '$deduct9',deduct10 = '$deduct10', allowance1 = '$allow1',allowance2 = '$allow2',allowance3 = '$allow3',allowance4 = '$allow4',allowance5 = '$allow5',allowance6 = '$allow6',allowance7 = '$allow7',allowance8 = '$allow8',allowance9 = '$allow9',allowance10 = '$allow10' where band = '$band' && client = '$client'");


        header('Location:payroll-setting?band=' . base64_encode($bc) . '&msg=sucsess');
        exit;
    } else {

        mysqli_query($db, "update settings set comp_stat_cont = '$cop_stat', staff_stat_cont = '$staff_stat', pen_cop_vol = '$cop_vol', basic = '$basic', housing = '$house', transport = '$trans', leave_allo = '$leave', utility = '$utility', meals = '$meals', dressing = '$dress', 13th_month = '$month13', nhf = '$nhf', date = '$date', tax= '$tax', loan = '$loan', deduct1 = '$deduct1',deduct2 = '$deduct2',deduct3 = '$deduct3',deduct4 = '$deduct4',deduct5 = '$deduct5',deduct6 = '$deduct6',deduct7 = '$deduct7',deduct8 = '$deduct8',deduct9 = '$deduct9',deduct10 = '$deduct10', allowance1 = '$allow1',allowance2 = '$allow2',allowance3 = '$allow3',allowance4 = '$allow4',allowance5 = '$allow5',allowance6 = '$allow6',allowance7 = '$allow7',allowance8 = '$allow8',allowance9 = '$allow9',allowance10 = '$allow10'where band is null || band = ''");

        header('Location:payroll-setting?msg=sucsess');
        exit;
    }
} else {

    mysqli_query($db, "insert into settings set client = '$client', band = '$band', comp_stat_cont = '$cop_stat', staff_stat_cont = '$staff_stat', pen_cop_vol = '$cop_vol', basic = '$basic', housing = '$house', transport = '$trans', leave_allo = '$leave', utility = '$utility', meals = '$meals', dressing = '$dress', 13th_month = '$month13', nhf = '$nhf', settings = 'yes', date = '$date', tax= '$tax', loan = '$loan', deduct1 = '$deduct1',deduct2 = '$deduct2',deduct3 = '$deduct3',deduct4 = '$deduct4',deduct5 = '$deduct5',deduct6 = '$deduct6',deduct7 = '$deduct7',deduct8 = '$deduct8',deduct9 = '$deduct9',deduct10 = '$deduct10',allowance1 = '$allow1',allowance2 = '$allow2',allowance3 = '$allow3',allowance4 = '$allow4',allowance5 = '$allow5',allowance6 = '$allow6',allowance7 = '$allow7',allowance8 = '$allow8',allowance9 = '$allow9',allowance10 = '$allow10'");

    if ($band != "") {
        header('Location:payroll-setting?band=' . base64_encode($bc) . '&msg=sucsess');
        exit;
    } else {
        header('Location:payroll-setting?msg=sucsess');
        exit;
    }
}
