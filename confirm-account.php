<?php

ob_start();
session_start();
include("outsourcehr-admin/connection/connect.php");
require_once('outsourcehr-admin/inc/fns.php');
$email = base64_decode($_GET['cem']);
$auth = $_GET['auth'];



$query = "update jobseeker_signup set status = 'active' where email = '$email' && status = '$auth'";
$result = mysqli_query($db, $query);

$success = "Your account is now active. You can login to continue";
include('login.php');
exit;
