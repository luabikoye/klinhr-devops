<?php

ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
    include('index.php');
    exit;
}


// Warning: move_uploaded_file(): Unable to move 'C:\xampp\tmp\php3153.tmp' to 'images/img7.jpg' in C:\xampp\htdocs\Talgen3.0\app\edit-prev-job.php on line 102

include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('Vacancies');
$id = $_POST['id'];
$id_2 = $_POST['id_2'];

$job_title = mysqli_real_escape_string($db, $_POST['job_title']);
$category = mysqli_real_escape_string($db, $_POST['category']);
$qualification = mysqli_real_escape_string($db, $_POST['qualification']);
$experience = mysqli_real_escape_string($db, $_POST['experience']);
$client_name = mysqli_real_escape_string($db, $_POST['client_name']);
$show_client = mysqli_real_escape_string($db, $_POST['show_client']);
$state = mysqli_real_escape_string($db, $_POST['state']);
$job_type = mysqli_real_escape_string($db, $_POST['job_type']);
$job_image = mysqli_real_escape_string($db, $_POST['job_image']);
$application_type = mysqli_real_escape_string($db, $_POST['application_type']);
$salary = mysqli_real_escape_string($db, $_POST['salary']);
$deadline = mysqli_real_escape_string($db, $_POST['deadline']);
$description = $_POST['description'];
$qualification_requirement = $_POST['qualification_requirement'];
$responsibilities = $_POST['responsibilities'];
$date_posted = $_POST['date_posted'];






if ($job_title == '') {
    $error = "Job title is required";
    include('edit-job.php');
    exit;
}




if ($client_name == '') {
    $error = "Client's name is required";
    include('edit-job.php');
    exit;
}

if ($description == '') {
    $error = "Description is required";
    include('edit-job.php');
    exit;
}

if ($qualification_requirement == '') {
    $error = "Qualification & requirement is required";
    include('edit-job.php');
    exit;
}

if ($responsibilities == '') {
    $error = "Responsibilities is required";
    include('edit-job.php');
    exit;
}

if ($_FILES['job_image']['name']) {

    $file_loc = $_FILES['job_image']['tmp_name'];
    $path = $_FILES['job_image']['name'];
    $file_size = $_FILES['job_image']['size'];
    $file_type = $_FILES['job_image']['type'];

    $doc_size = $file_size / 1024;

    if (validate_file($path) == 'invalid') {
        $error = 'Please reupload your file , the ony accepted file format is JPG, JPEG, PNG, PDF, DOCX, DOC ';
        include('add-job.php');
        exit;
    }

    if ($doc_size > 1550) {
        $error = 'Sorry, your file is too large, the required file size is 1.5mb below';
        include('add-job.php');
        exit;
    }

    $u = md5(date('U'));
    $ext = get_extension($path);
    $db_image = $category . '_' . $u . '.' . $ext;
    $path_name = UPLOAD_DIR.'jOBS_IMAGE/JOB' . $db_image;
    move_uploaded_file($file_loc, $path_name);

    $sql = "update job_post set job_image = '$db_image' where id = '$id'";
    $sql_result = mysqli_query($db, $sql);
}

$query = "update job_post set job_title = '$job_title', category = '$category', qualification = '$qualification', experience = '$experience', client_id = '$client_name', show_client = '$show_client',  state = '$state', job_type = '$job_type', application_type = '$application_type', salary = '$salary', deadline = '$deadline', description = '$description', qualification_requirement = '$qualification_requirement', responsibilities = '$responsibilities', date_posted = '$date_posted' where id = '$id'";
$result = mysqli_query($db, $query);
if ($result) {
    activity_log($_SESSION['Klin_admin_email'], "Edited job : ($job_title)");



    $success = "Job has been successfully edited";
    include('edit-job.php');
    exit;
} else {
    $error = "Job not edited, try again later";
    include('edit-job.php');
    exit;
}