<?php

ob_start();
session_start();
include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header('location: logout');
    exit;
}

$check = get_val('login', 'email', $_SESSION['Klin_admin_user'], 'privilege');

if (($check) == true) {
    header("location: dashboard");
} else {
    header('location: logout?access=denied');
    exit;
}
