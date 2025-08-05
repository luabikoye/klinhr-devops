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


$job_title = mysqli_real_escape_string($db, $_POST['job_title']);
$industry = mysqli_real_escape_string($db, $_POST['industry']);
$qualification = mysqli_real_escape_string($db, $_POST['qualification']);
$experience = mysqli_real_escape_string($db, $_POST['experience']);
$client_id = mysqli_real_escape_string($db, $_POST['client']);
$show_client = mysqli_real_escape_string($db, $_POST['show_client']);
$state = mysqli_real_escape_string($db, $_POST['state']);
$country = mysqli_real_escape_string($db, $_POST['country']);
$job_type = mysqli_real_escape_string($db, $_POST['job_type']);
$application_type = mysqli_real_escape_string($db, $_POST['application_type']);
$salary = mysqli_real_escape_string($db, $_POST['salary']);
$deadline = mysqli_real_escape_string($db, $_POST['deadline']);
$category = mysqli_real_escape_string($db, $_POST['category']);
$description = mysqli_real_escape_string($db, $_POST['description']);
$qualification_requirement = mysqli_real_escape_string($db, $_POST['qualification_requirement']);
$responsibilities = mysqli_real_escape_string($db, $_POST['responsibilities']);
$account_token = $_SESSION['account_token'] ? $_SESSION['account_token'] : 'NULL';
$date_posted = date('Y-m-d');
$job_post = $_SESSION['Klin_admin_user'];
$date = date('Y-m-d g:i:s A');
if (recruitment_approval() == 'no' || recruitment_approval() == NULL) {
    $now = 'approved';
}
$client_name = get_client_name(mysqli_real_escape_string($db, $_POST['client']));

if ($job_title == '') {
    $error = "Job title is required";
    include('add-job.php');
    exit;
}

if ($description == '') {
    $error = "Description is required";
    include('add-job.php');
    exit;
}

if ($qualification_requirement == '') {
    $error = "Qualification & requirement is required";
    include('add-job.php');
    exit;
}
// echo 'NO';
// exit;

if ($responsibilities == '') {
    $error = "Responsibilities is required";
    include('add-job.php');
    exit;
}

if ($category == 'Select Category') {
    $error = "Category is required";
    include('add-job.php');
    exit;
}

if ($qualification == 'Select Qualification') {
    $error = "Qualification is required";
    include('add-job.php');
    exit;
}

if ($experience == 'Select Experience') {
    $error = "Experience is required";
    include('add-job.php');
    exit;
}

if ($state == 'Select State') {
    $error = "State is required";
    include('add-job.php');
    exit;
}

if ($job_type == 'Select Job') {
    $error = "Job type is required";
    include('add-job.php');
    exit;
}

$query = "insert into job_post(job_title, category, qualification, experience, client_id, show_client, state, country,  job_type, application_type,  salary,  deadline, description, qualification_requirement, responsibilities, date_posted, user, status, account_token) values('$job_title',  '$category', '$qualification',  '$experience',  '$client_id',  '$show_client', '$state', '$country',  '$job_type', '$application_type',  '$salary',  '$deadline', '$description',  '$qualification_requirement', '$responsibilities', '$date_posted', '$job_post', '$now', '$account_token')";

$result = mysqli_query($db, $query);
if ($result) {
    // $_SESSION['job_title'] = $job_title;

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
       $path_name = UPLOAD_DIR . 'jOBS_IMAGE/JOB' . $db_image;
        move_uploaded_file($file_loc, $path_name);
        $id = mysqli_insert_id($db);

        $sql = "update job_post set job_image = '$db_image' where id = '$id'";
        $sql_result = mysqli_query($db, $sql);
    }

    $job_post_id = mysqli_insert_id($db);

    $query1 = "select * from login where username = '$job_post'";
    $result1 = mysqli_query($db, $query1);
    $row1 = mysqli_fetch_array($result1);
    $name =  ucfirst($row1['firstname']) . ' ' . ucfirst($row1['lastname']);

    activity_log($_SESSION['Klin_admin_email'], "Added a new job post with title: $job_title");

    if (recruitment_approval() == 'yes') {
        $now = base64_encode('approved');
        $message = 'A new job posted has been uploaded by ' . $admin_fullname . '. Below are the details<br><br>
    Job Title: ' . $job_title . '<br>' .
            'Category: ' . $category . '<br>' .
            'Minimum Qualification: ' . $qualification . '<br>' .
            'Experience: ' . $experience . '<br>' .
            'State: ' . $state . '<br>' .
            'Job Type: ' . $job_type . '<br>' .
            'Application Type: ' . $application_type . '<br>' .
            'Salary: ' . $salary . '<br>' .
            'Deadline: ' . $deadline . '<br>' .
            'Date Posted: ' . $date_posted . '<br>' .
            'Client Name: ' . $client_name . '<br>' .
            '<br><br><br><u>RECRUITMENT PLAN</u></b><br>' .
            'Recruitment Manager Name: ' . $recruiting_manager_name . '<br>' .
            'Employment Terms: ' . $employment_terms . '<br>' .
            'Candidate Persona: ' . $candidate_persona . '<br>' .
            'Sourcing Strategy: ' . $sourcing_strategy . '<br>' .
            'Applicant Evaliuation: ' . $applicant_evaluation . '<br>' .
            'Is Travel Involved: ' . $travel_involved . '<br>' .
            'Testing Involved: ' . $test . '<br>' .
            'Duration: ' . $duration . '<br><br><br> Please click <b><a href="' . root() . '/confirm_job?auth=' . $now . '&cem=' . base64_encode($job_title) . '&jid=' . base64_encode($job_post_id) . '">APPROVE NOW</a></b> to approve this job.';

        $sub = 'Job Post Approval (' . $job_title . ')';
        send_email(notification_email('Vacancies'), 'Admin', organisation(), $sub, $message);
    }
    //Send a mail to admin for job approval    

    $sql_3 = "insert into recruitment_plan set client_name = '$client_name', job_title = '$job_title', recruiting_manager_name = '$recruiting_manager_name', candidate_persona = '$candidate_persona', sourcing_strategy = '$sourcing_strategy', applicant_evaluation = '$applicant_evaluation', travel_involved = '$travel_involved', testing = '$test', employment_terms = '$employment_terms', duration = '$duration', job_post_id = '$job_post_id' ";
    $result_3 = mysqli_query($db, $sql_3);

    $success = "Job has been successfully added";
    include('add-job.php');
    exit;
} else {
    $error = "Job not added, check if all information were correctly entered";
    include('add-job.php');
    exit;
}