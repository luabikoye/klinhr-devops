<?php


ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');
validatePermission('Vacancies');
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

if ($_POST['recruitment']) {
    $recruitment = mysqli_real_escape_string($db, $_POST['recruitment']);
} else {
    $recruitment = 'no';
}
if ($_POST['verify']) {
    $verify = mysqli_real_escape_string($db, $_POST['verify']);
} else {
    $verify = 'no';
}
$name = mysqli_real_escape_string($db, $_POST['name']);
$abbr = mysqli_real_escape_string($db, $_POST['abbr']);
$result = mysqli_real_escape_string($db, $_POST['result']);
$job_img = mysqli_real_escape_string($db, $_POST['job_image']);
$gua = mysqli_real_escape_string($db, $_POST['gua']);
$employer = mysqli_real_escape_string($db, $_POST['employer']);
$about = mysqli_real_escape_string($db, $_POST['about']);

if ($name == '') {
    $error = "Client Name is required";
    include('settings.php');
    exit;
}

if ($abbr == '') {
    $error = "Client Abbrivation is required";
    include('settings.php');
    exit;
}

if ($about == '') {
    $error = "About Client is required";
    include('settings.php');
    exit;
}
if ($result == '') {
    $result = "no";
}
if ($job_img == '') {
    $job_img = "no";
}
if ($_FILES['logo']['name']) {
    $logo_tmp = $_FILES['logo']['tmp_name'];
    $logo_name = $_FILES['logo']['name'];

    if (validate_file($logo_name) == 'invalid') {
        $error = 'Please reupload your file , the ony accepted file format is JPG, JPEG, PNG ';
        include('settings.php');
        exit;
    }

    $u = md5(date('U'));
    $ext = get_extension($logo_name);
    $job_image = $abbr . '_' . $u . '.' . $ext;
    $path_name = FILE_DIR . 'JOB' . $job_image;
    if (move_uploaded_file($logo_tmp, $path_name) === false) {
        $error = 'File Not Uploaded ';
        include('settings.php');
        exit;
    }
} else {
    $job_image = client_detail('client_logo');
}



$query = "UPDATE client_setting SET client_name = '$name', client_abbr = '$abbr', assessment = '$result', client_logo = '$job_image', job_img = '$job_img', verification = '$cerify', recruitment = '$recruitment', guarantor = '$gua', employer = '$employer', about = '$about' WHERE id = 1";
$result = mysqli_query($db, $query);
if ($result) {

    activity_log($_SESSION['Klin_admin_email'], "Updated Client details");

    $success = "Client Details Updated";
    include('settings.php');
    exit;
} else {
    $error = "Database error";
    include('settings.php');
    exit;
}
