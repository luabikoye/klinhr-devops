<?php
ob_start();
session_start();
include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}
$id = $_POST['id'];
$name = mysqli_real_escape_string($db, $_POST['name']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$phone = mysqli_real_escape_string($db, $_POST['phone']);
$skill = mysqli_real_escape_string($db, $_POST['skill']);
$course = mysqli_real_escape_string($db, $_POST['course']);
$date = date('Y-m-d');

if ($id) {
    mysqli_query($db, "update facilitators set name = '$name', email = '$email', phone = '$phone', skill = '$skill', courses = '$course' where id = '$id'");

    header('Location: view-facilitator?success=1');
    exit;
} else {
    mysqli_query($db, "insert into facilitators set name = '$name', email = '$email', phone = '$phone', skill = '$skill', courses = '$course', date = '$date'");

    header('Location: add-facilitator?success=1');
    exit;
}
