<?php
ob_start();
session_start();


include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}


$band = mysqli_real_escape_string($db, $_POST['band']);
$id = mysqli_real_escape_string($db, $_POST['id']);
if ($_POST['salary']) {
    $salary = $_POST['salary'];
} else {
    $salary = 0;
}

$insert = "update salary_band set band = '$band', salary = '$salary' where id = '$id'";
$result = mysqli_query($db, $insert);

if ($result) {
    header('Location:salary_band?client=' . base64_encode($client) . '&msg=sucsess');
} else {
    header('Location:salary_band?client=' . base64_encode($client) . '&msg=error');
}
