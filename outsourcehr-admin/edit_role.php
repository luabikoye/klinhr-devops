<?php

ob_start();
session_start();
include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

$role = $_POST['role'];
$old_role = $_POST['old_role'];

if ($_POST['id']) {
    $id = ($_POST['id']);
}

$query = "update role set role  = '$role' where id = '$id'";
$result = mysqli_query($db, $query);
if ($result) {
    activity_log($_SESSION['Klin_admin_user'], "Edited $old_role to $role ");
    $success = "Role successfully edited";
    include('role.php');
    exit;
} else {
    $error = "Sorry, role canot be edited at this time";
    include('role.php');
    exit;
}
