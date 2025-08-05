<?php

    include('connection/connect.php');
    require_once('inc/fns.php');
    validatePermission('General Setting');
    $id = $_GET['id'];

    $query = "delete from message_template where id = '$id'";
    $result = mysqli_query($db, $query);
    if($result)
    {
        $success = "Template has been successfully deleted";
        include('msg-template.php');
        exit;
    }
    else
    {
        $error = "Template cannot  be deleted, try again later";
        include('msg-template.php');
        exit;
    }
?>