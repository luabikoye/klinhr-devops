<?php

ob_start();
session_start();


include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');

$username = mysqli_real_escape_string($db, $_POST['username']);
$password = mysqli_real_escape_string($db, $_POST['password']);
$port = mysqli_real_escape_string($db, $_POST['port']);
$secure = mysqli_real_escape_string($db, $_POST['secure']);
$host = mysqli_real_escape_string($db, $_POST['host']);
$admin = mysqli_real_escape_string($db, $_POST['admin']);
$sender = mysqli_real_escape_string($db, $_POST['sender']);
$reply = mysqli_real_escape_string($db, $_POST['reply']);

$update = mysqli_query($db, "UPDATE  smtp SET username = '$username', password = '$password', port = '$port', secure = '$secure', host = '$host', admin = '$admin', sender = '$sender', reply = '$reply' WHERE id = '1'");
if ($update) {
    header("Location: smtp?success=1");
} else {
    header("Location: smtp?error=1");
}
