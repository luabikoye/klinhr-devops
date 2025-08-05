<?php

ob_start();
session_start();

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('Employee Appraisal');

$id = base64_decode($_GET['id']);


$query = "update appraisal set status = 'Stopped' where id = '" . $id . "'";
$result = mysqli_query($db, $query);


header("Location: set-appraisal.php");