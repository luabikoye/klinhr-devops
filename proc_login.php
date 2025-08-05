<?php

ob_start();
session_start();


include('outsourcehr-admin/connection/connect.php');
include('outsourcehr-admin/inc/fns.php');


$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
$password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
$return = $_POST['return'];
$job_id = ($_SESSION['return_id']);



if ($email == '') {
    $error = "Email is required";
    include('login.php');
    exit;
}

if ($password == '') {
    $error = "Password is required";
    include('login.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format";
    include('login.php');
    exit;
}

$sql = "select * from jobseeker_signup where email = '$email'";
$result_1 = mysqli_query($db, $sql);
$valid = mysqli_fetch_assoc($result_1);

if ($valid['email'] != $email) {
    $error = "This email hasn't been registered on our database";
    include('login.php');
    exit;
}




//if the login user is an administrator. Redirect to backend
$query = "select * from login where email = '$email' && password = '$password'";
$result = mysqli_query($db, $query);
$num = mysqli_num_rows($result);
if ($num > 0) {
    $_SESSION['Klin_user'] = $email;
    $_SESSION['admin_email'] = $email;

    activity_log($_SESSION['admin_email'], 'Signed into backend');

    header("Location: dashboard");
    exit;
}

// echo 
$query = "select * from jobseeker_signup where email = '$email' && password = md5('$password')";
// exit;
$result = mysqli_query($db, $query);
$num = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
if ($num > 0) {
    if ($row['status'] == 'active') {

        //Confirm that user has updated basic profile
        // if(basic_profile($email) != 'complete')
        // {
        //     $error = '<div class="alert alert-danger alert-dismissible mt-2">
        //     <button type="button" class="close" data-dismiss="alert">&times;</button>
        //     <strong>You are yet to update your profile. Update your profile and start applying for jobs</strong>
        // </div>';
        //             include('profile.php');
        //             exit;
        // }


        $_SESSION['last_login_timestamp'] = time();
        $_SESSION['Klin_user'] = $email;
        $_SESSION['candidate_id'] = $row['id'];

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
    $address = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'address');
    $bustop = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'bustop');
    $local_govt = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'local_govt');
    $job_title = get_val('job_post', 'id', $job_id, 'job_title');
    $job_type = get_val('job_post', 'id', $job_id, 'job_type');
    $client_id = get_val('job_post', 'id', $job_id, 'client_id');
    $client_name = get_val('clients', 'id', $client_id, 'client_name');
    $qualification = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'first_qualification');
    $old_cv = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'cv');
    $class_degree = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'first_degree');
    $date_posted = get_val('job_post', 'id', $job_id, 'date_posted');
    $deadline = get_val('job_post', 'id', $job_id, 'deadline');
    $date_applied = date('Y-m-d');
    $status = 'Applied';

        $date_applied = date('Y-m-d');
        $status = 'Applied';


        $cv_name = $_FILES['cv']['name'];
        $cv = $_FILES['cv']['tmp_name'];


        if ($cv_name) {
            $path = $row['id'] . '_' . date('dmis') . $_FILES['cv']['name'];
            $folder = "uploads/documents/";
            $doc_size = $file_size / 1024;
            $file_name = strtolower($path);
            $file_ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if ($_FILES['cv']['size'] > 1000001) {
                $error = '<div class="alert alert-danger alert-dismissible mt-2">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Sorry, your first file is too large, the required file size is 1mb below </strong>
              </div>';
                include('login.php');
                exit;
            }

            if ($path == '') {
                $error = '<div class="alert alert-danger alert-dismissible mt-2">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>First file is required </strong>
                </div>';
                include('login.php');
                exit;
            }

            if (
                $file_ext == 'JPEG' || $file_ext == 'jpeg' || $file_ext == 'JPG' || $file_ext == 'jpg' || $file_ext == 'PNG' || $file_ext == 'png' || $file_ext == 'PDF' || $file_ext == 'pdf' || $file_ext == 'DOCX' || $file_ext == 'docx' || $file_ext == 'DOC' || $file_ext == 'doc'
            ) {
                $path = str_replace(' ', ' ', $file_name);
                if (move_uploaded_file($cv, $folder . $path) === false) {
                    $error = '<div class="alert alert-danger alert-dismissible mt-2">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Cv Not uploaded </strong>
        </div>';
                    include('login.php');
                }
            }
        }
        //if CV was uploaded insert into jobs_applied else insert cv in jobseeker table
        if(!$cv_name)
        {
            $path = $old_cv;
        }

        //if job_id 
        // if ($job_id) {
        //     $insert_job = mysqli_query($db, "INSERT INTO jobs_applied SET job_id = '$job_id', candidate_id = '" . $candidate_id . "', firstname = '" . $firstname . "', middlename = '" . $middlename . "', lastname = '" . $lastname . "', email = '".$email."', phone = '".$phone."', gender = '".$gender."', address = '" . $address . "', bustop = '" . $bustop . "', local_govt = '" . $local_govt . "', age = '" . $age . "', state = '" . $state . "', country = '" . $country . "', client_name = '" . $client_name . "', job_title = '" . $job_title . "', job_type = '" . $job_type . "',  qualification = '" . $qualification . "',  class_degree = '" . $class_degree . "', date_posted = '$date_posted', deadline = '$deadline', date_applied = '$date_applied', status = '$status', cv = '$path'");
        // }

        activity_log($_SESSION['Klin_user'], 'Logged in');

        if($return)
        {
            //if the user is returning from job details page. Just redirtect to automatically apply
            $offer = base64_encode("Hi $firstname, your job application has been received for the role of $job_title, click <a href='index'>Apply</a> to try another role ");
            
            $url = base64_decode($return)."&offer=$offer";
            header("Location: $url");
        }
        else{
            header("Location: dashboard");
        }

        exit;
    } else {
        $error = 'Your account is not active. Check your email for the activation mail or <a href="resend_confirmation?cem=' . base64_encode($email) . '">Click here</a> to resend it';
        include('login.php');
        exit;
    }
} else {
    $error = "Incorrect Password";
    include('login.php');
    exit;
}