<?php

ob_start();
session_start();
include("outsourcehr-admin/connection/connect.php");
require_once('outsourcehr-admin/inc/fns.php');
require_once('outsourcehr-admin/PHPMailer/PHPMailerAutoload.php');

$firstname = mysqli_real_escape_string($db, $_POST['firstname']);
$return = mysqli_real_escape_string($db, $_POST['return']);
$lastname = mysqli_real_escape_string($db, $_POST['lastname']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$password = mysqli_real_escape_string($db, $_POST['password']);
$phone = mysqli_real_escape_string($db, $_POST['phone']);
$gender = mysqli_real_escape_string($db, $_POST['gender']);
$country = mysqli_real_escape_string($db, $_POST['country']);
$country_code = mysqli_real_escape_string($db, $_POST['country_code']);
$dob = mysqli_real_escape_string($db, $_POST['dob']);
$address = mysqli_real_escape_string($db, $_POST['address']);
$state = mysqli_real_escape_string($db, $_POST['state']);
$first_institution = mysqli_real_escape_string($db, $_POST['first_institution']);
$first_qualification = mysqli_real_escape_string($db, $_POST['first_qualification']);
$class_degree = mysqli_real_escape_string($db, $_POST['class_degree']);
$experience_1 = mysqli_real_escape_string($db, $_POST['experience_1']);
$position = mysqli_real_escape_string($db, $_POST['position']);
$desire = mysqli_real_escape_string($db, $_POST['desire']);
$id = mysqli_real_escape_string($db, $_POST['id']);
$available = mysqli_real_escape_string($db, $_POST['available']);
$points = 0;

$file = $_FILES['file']['name'];
$file_loc = $_FILES['file']['tmp_name'];
$file_size = $_FILES['file']['size'];
$file_type = $_FILES['file']['type'];


if (!$firstname || !$lastname || !$email || !$password || !$phone || !$gender || !$dob || !$first_institution || !$first_qualification || !$class_degree || !$file) {
    $error = '<div class="alert alert-danger alert-dismissible mt-2">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Sorry, all information on this are required to apply for job </strong>
      </div>';
    include('apply-form.php');
    exit;
}

$phones = $country_code . $phone;
$fullname = $firstname . ' ' . $lastname;
$select = "SELECT * FROM jobseeker_signup WHERE email = '$email'";
$result1 = mysqli_query($db, $select);
$num = mysqli_num_rows($result1);
if ($num == 0) {

    $insert = "INSERT INTO jobseeker_signup SET firstname = '$firstname', lastname = '$lastname', email = '$email', password = md5('$password'), phone = '$phones', fullname = '$fullname', status = 'active'";

    $result = mysqli_query($db, $insert);
    $candidate_id = mysqli_insert_id($db);
    if ($result) {

        $insert2 = "INSERT INTO jobseeker SET candidate_id = '$candidate_id', firstname = '$firstname', lastname = '$lastname', email = '$email', phone = '$phones', gender = '$gender', country = '$country', address = '$address', dob = '$dob', first_institution = '$first_institution', first_qualification = '$first_qualification', experience_1 ='$experience_1', position = '$position', prefjob = '$desire', availDate = '$available', completed = 'updated'";


        $result2 = mysqli_query($db, $insert2);
        if ($result2) {


            //get cv and upload
            $candidate = mysqli_insert_id($db);
            $path = $candidate . '_' . date('dmis') . $_FILES['file']['name'];


            $folder = "uploads/documents/";

            $doc_size = $file_size / 1024;

            $file_name = strtolower($path);

            $file_ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));


            if ($_FILES['file']['size'] > 1000001) {
                $error = '<div class="alert alert-danger alert-dismissible mt-2">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Sorry, your file is too large, the required file size is 1mb below </strong>
              </div>';
                include('apply-form.php');
                exit;
            }

            if ($path == '') {
                $error = '<div class="alert alert-danger alert-dismissible mt-2">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>File is required </strong>
                </div>';
                include('apply-form.php');
                exit;
            }

            // if(strlen($file_name) > 25)
            // {
            //     $error = "Your file file name is too long, kindly rename it to at least 20 letters";
            //     include('my-credentials.php');
            //     exit;
            // }

            if ($file_ext == 'JPEG' || $file_ext == 'jpeg' || $file_ext == 'JPG' || $file_ext == 'jpg' || $file_ext == 'PNG' || $file_ext == 'png'  || $file_ext == 'PDF' || $file_ext == 'pdf' || $file_ext == 'DOCX'  || $file_ext == 'docx' || $file_ext == 'DOC' || $file_ext == 'doc') {
                $path = str_replace(' ', ' ', $file_name);
                move_uploaded_file($file_loc, $folder . $path);
            } else {
                $error = '<div class="alert alert-danger alert-dismissible mt-2">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Please reupload your file , the ony accepted file format is JPG, JPEG, PNG, PDF, DOCX, DOC </strong>
                </div>';
                include('apply-form.php');
                exit;
            }



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

            $insert3 = "INSERT INTO jobs_applied SET job_id = '$job_id', candidate_id = '$candidate_id', firstname = '$firstname', lastname = '$lastname', email = '$email', phone = '$phone', address = '$address', state = '$state', gender = '$gender', age = '$age', client_name = '$client_name', job_title = '$job_title', job_type = '$job_type',  qualification = '$first_qualification',  class_degree = '$class_degree',  cv = '$path', date_posted = '$date_posted', deadline = '$deadline', date_applied = '$date_applied', status = '$status', points = '$points' ";
            $result3 = mysqli_query($db, $insert3);
            if ($result3) {

                $applied_id = mysqli_insert_id($db);

                application_log($candidate_id, $job_id, 'Applied for the role  ' . $job_title);

                // insert CV
                $query2 = "insert into credentials set document = 'cv', filepath = '$path', candidate_id = '$candidate_id'";
                $result2 = mysqli_query($db, $query2);



                //update jobseeker table with CV file path
                 $up_cv = "UPDATE jobseeker SET cv = '$path' where  email = '$email'";
                 $result = mysqli_query($db, $up_cv);


                if ($_SESSION['secured']) {
                    unset($_SESSION['secured']);
                }

                $message = "This is to confirm your application for the role <b>$job_title.</b> <br><br> You will be contacted if you meet our requirement";

                send_email($email, $firstname, organisation(), 'Job Application Successful', $message);

                $msg = "Your job application has been receieved for the role of $job_title. Our Recruiters will contact you if you meet the requirements stated for this role.";

                $query2 = "insert into notification set candidate_id = '$candidate_id', notifier = 'Admin', message = '$msg', status = 'Unread', date = '$date_applied'";
                $result2 = mysqli_query($db, $query2);

                if ($points >= approved_points()) {
                    push_for_nextstage('Assessment', $applied_id);
                }


                $offer = "Hi $firstname, your job application has been received for the role of $job_title, click <a href='jobs'>Apply</a> to try another role ";

                include('thank-you.php');
                exit;
            }
        }

        include('thank-you.php');
        exit;
    } else {
        $error = "Database error";
        include('apply-form.php');
        exit;
    }
} else {
    $error = "It appears that you have already signed up before please <a href='login'>login</a> to apply for this job";
    include('apply-form.php');
    exit;
}