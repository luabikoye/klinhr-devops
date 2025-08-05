<?php
ob_start();
session_start();
include("outsourcehr-admin/connection/connect.php");
require_once('outsourcehr-admin/inc/fns.php');
require_once('outsourcehr-admin/PHPMailer/PHPMailerAutoload.php');

$id = base64_decode($_GET['valid']);
$app_type = base64_decode($_GET['app_type']);

if (!isset($_SESSION['Klin_user'])) {
    $_SESSION['return_id'] = $id;
    $return = base64_encode('job-description?valid=' . $_GET['valid']);
    // $error = 'You need to <a style="color:#1b0670;" href="login?return=' . $return . '">login</a> to apply for this job. If you are a new user <a style="color:#1b0670;" href="create-account">Register now</a>.';
    include('apply-form.php');
    exit;
}


$query = "select * from jobseeker where email = '" . $_SESSION['Klin_user'] . "' and completed = 'updated'";
$result = mysqli_query($db, $query);
$num = mysqli_num_rows($result);

if ($num > 0) {
    $_SESSION['updated'] = 'yes';

    $job_id = $id;
    $candidate_id = get_val('jobseeker_signup', 'email', $_SESSION['Klin_user'], 'id');
    $firstname = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'firstname');
    $lastname = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'lastname');
    $middlename = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'middlename');
    $email = $_SESSION['Klin_user'];
    $phone = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'phone');
    $gender = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'gender');
    $age = get_age(get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'dob'));
    $state = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'state');
    $country = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'country');
    $local_govt = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'local_govt');
    $bustop = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'bustop');
    $address = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'address');
    $job_title = get_val('job_post', 'id', $id, 'job_title');
    $job_type = get_val('job_post', 'id', $id, 'job_type');
    $client_id = get_val('job_post', 'id', $id, 'client_id');
    $client_name = get_val('clients', 'id', $client_id, 'client_name');
    $qualification = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'first_qualification');
    $cv = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'cv');
    $class_degree = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'first_degree');
    $date_posted = get_val('job_post', 'id', $id, 'date_posted');
    $deadline = get_val('job_post', 'id', $id, 'deadline');
    $points = 0;


    $job_id = $id; //job post id
    $age = get_age($dob);
    $client_id = get_val('job_post', 'id', $job_id, 'client_id');
    $client_name = get_val('clients', 'id', $client_id, 'client_name');
    $job_degree = get_val('job_post', 'id', $job_id, 'qualification');
    $job_experience = get_val('job_post', 'id', $job_id, 'experience');
    $job_state = get_val('job_post', 'id', $job_id, 'state');
    $job_title = get_val('job_post', 'id', $job_id, 'job_title');
    $job_type = get_val('job_post', 'id', $job_id, 'job_type');
    $date_posted = get_val('job_post', 'id', $job_id, 'date_posted');
    $deadline = get_val('job_post', 'id', $job_id, 'deadline');
    $date_applied = date('Y-m-d');
    $status = 'Applied';
    $ch_query = "select * from jobs_applied where candidate_id = '$candidate_id' and job_id = '$job_id'";
    $ch_result = mysqli_query($db, $ch_query);
    $ch_num = mysqli_num_rows($ch_result);

    if ($ch_num > 0) {
        $error = 'It appears you have applied for this job earlier';
        include('apply.php');
        exit;
    }

    // Set points

    if ($age > 22 && $age < 28) {
        $points = $points + 5;
    }

    if ($first_qualification == 'BACHELOR DEGREE' || $first_qualification == 'MASTERS' || $first_qualification == 'HND') {
        $points = $points + 5;
    }


    if (strpos($job_state, $state) !== false) { {
            $points = $points + 5;
        }
    }

    if (strpos($job_experience, $experience_1) !== false) { {
            $points = $points + 5;
        }
    }

    if (strpos($job_degree, $first_qualification) !== false) { {
            $points = $points + 5;
        }
    }

    application_log($_SESSION['candidate_id'], $job_id, 'Applied for the role  ' . $job_title);
    // echo
    $query = "insert into jobs_applied set job_id = '$job_id', candidate_id = '$candidate_id', firstname = '$firstname', lastname = '$lastname', middlename = '$middlename', email = '$email', phone = '$phone', gender = '$gender', age = '$age', state = '$state', country = '$country', local_govt = '$local_govt', address = '$address', bustop = '$bustop', job_title = '$job_title', job_type = '$job_type', client_name = '$client_name', qualification = '$qualification', class_degree = '$class_degree', cv = '$cv', date_posted = '$date_posted', deadline = '$deadline', date_applied = '$date_applied', status = '$status', points = '$points'";
    // exit;
    $result = mysqli_query($db, $query);


    if ($result) {

        $applied_id = mysqli_insert_id($db);

        if ($_SESSION['secured']) {
            unset($_SESSION['secured']);
        }

        $message = "This is to confirm your application for the role <b>$job_title.</b> <br><br> You will be contacted if you meet our requirement";

        send_email($email, $firstname, organisation(), 'Job Application Successful', $message);

        $msg = "Your job application has been receieved for the role of $job_title. Our Recruiters will contact you if you meet the requirements stated for this role.";
        if ($points >= approved_points()) {
            push_for_nextstage('Assessment', $applied_id);
        }


        $query2 = "insert into notification set candidate_id = '$candidate_id', notifier = 'Admin', message = '$msg', status = 'Unread', date = '$date_applied'";
        $result2 =  mysqli_query($db, $query2);


        $offer = "Hi $firstname, your job application has been received for the role of $job_title, click <a href='index'>Apply</a> to try another role ";
        include('job-description.php');
        exit;
    } else {
        $error = 'It appears you have applied for this job earlier';
        include('job-description.php');
        exit;
    }
} else {
    // $_SESSION['updated'] = 'no';
    // include('personal.php');
    header("location: dashboard?updated=no");
    exit;
}