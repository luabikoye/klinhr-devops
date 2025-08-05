<?php
ob_start();
session_start();
include("connection/connect.php");
require_once('inc/fns.php');

$template_id = $_POST['template_id'];

$query = "select * from message_template where id = '" . $template_id . "'";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);
$template_subject = $row['template_subject'];
$message = $row['message'];
$sms_content = strip_tags($row['sms_content']);
$id = $row['id'];


echo json_encode(array($template_subject, $message, $sms_content, $id));
