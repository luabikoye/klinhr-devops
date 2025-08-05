<?php


ob_start();
session_start();
if (!isset($_SESSION['Klin_user'])) {
    include('login.php');
    exit;
}

include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');


$id = base64_decode($_GET['id']);

$query = "update notification set deleted = 'Deleted' where id = '$id'";
$result = mysqli_query($db, $query);
if ($result) {
    $success = "Notification was successfully deleted";
    include('notifications.php');
    exit;
} else {
    $error = "Notification cannot be deleted";
    include('notifications.php');
    exit;
}
