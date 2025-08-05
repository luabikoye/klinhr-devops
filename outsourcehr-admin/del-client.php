<?php

include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('Clients');
$id = $_GET['id'];

$query = "delete from clients where id = '$id'";
$result = mysqli_query($db, $query);
if($result)
{
    activity_log($_SESSION['Klin_admin_email'], "Deleted Client");
    $success = "Client has been successfully deleted";
    include('clients.php');
    exit;
}
else
{
    $error = "Client cannot  be deleted, try again later";
    include('clients.php');
    exit;
}

