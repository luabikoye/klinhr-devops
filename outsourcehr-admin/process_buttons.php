<?php

ob_start();
session_start();

ob_start();

if (!isset($_SESSION['Klin_admin_user'])) {
    include('index.php');
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');

if (isset($_POST['btn_export'])) {
    $candidate_id = $_POST['candidate_id'];
    include('process-app.php');
    exit;
}

if (isset($_POST['btn_export'])) {
    $candidate_id = $_POST['candidate_id'];
    include('process-app.php');
    exit;
}

if (isset($_POST['download_selected'])) {
    $_SESSION['id'] = $_POST['id'];
    header("Location: generate_offer_letter/?type=download");
}

if (isset($_POST['mail_selected'])) {
    $_SESSION['id'] = $_POST['id'];
    header("Location: generate_offer_letter/?type=mail");
}
