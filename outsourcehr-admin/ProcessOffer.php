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


if (isset($_POST['btn_generate'])) {
    $email = ($_POST['email']);
    $check = "select * from emp_self_login where email = '$email' ";
    $check_result = mysqli_query($db, $check);
    $row = mysqli_fetch_array($check_result);

    $client = ($_POST['client']);
    $valid_id = $_POST['id'];
    $pool_id = $_POST['id'];
    $id_format = $_POST['id_format'];
    $job = ($_POST['job']);
    $effective_date = ($_POST['date']);

    $leave =  ($_POST['leave']);
    $basic_salary = $_POST['basic'];
    $housing = $_POST['housing'];
    $transport = $_POST['transport'];
    $meal = $_POST['meal'];
    $utility = $_POST['utility'];
    $leave_allowance = $_POST['leave_allowance'];
    $monthly_net = $_POST['monthly_net'];
    $annual_pay = $_POST['salary'];
    $band = $_POST['band'];

    $code = rand(1000, 600);
    $char = array('' . substr(get_val('emp_staff_details', 'id', $pool_id, 'firstname'), 0, 2) . get_val('emp_staff_details', 'id', $pool_id, 'candidate_id'));
    $a_char = strtoupper($char[0]);
    $user = $a_char . $code;

    $staff_ids_array = [];
    $pool_id_array = [];

    if (strpos($valid_id, ',') !== false) {
        $valid_id = explode(',', $valid_id);
        $valid_length = count($valid_id);

        $pool_id = explode(',', $pool_id);

        for ($i = 0; $i < $valid_length; $i++) { // Corrected the loop condition
            $staff_id = staff_id($valid_id[$i], $id_format);
            $staff_ids_array[] = $staff_id; // Append to the array                                     
            $pool_id_array[] = $pool_id[$i]; // Append individual pool_id to the array

            $firstname = get_val('emp_staff_details', 'id', $pool_id_array[$i], 'firstname');
            $lastname = get_val(
                'emp_staff_details',
                'id',
                $pool_id_array[$i],
                'surname'
            );
            $middlename = get_val('emp_staff_details', 'id', $pool_id_array[$i], 'middlename');
            $candidate_id = get_val('emp_staff_details', 'id', $pool_id_array[$i], 'candidate_id');
            $fullname = $firstname . ' ' . $lastname . ' ' . $middlename;

            echo $update_query = "UPDATE emp_staff_details 
                         SET EmployeeID = '{$staff_ids_array[$i]}', 
                             staff_id = '{$staff_ids_array[$i]}', 
                             company_code ='$client', 
                             position_code = '$job', 
                             date_employed = '$effective_date', 
                             location_code = '$location', 
                             effective_date = '$effective_date', 
                             salary = '$basic_salary', 
                             date_moved = '" . today() . "', 
                             completed = 'Client' ,
                             salary_band = '$band'
                         WHERE id = '{$pool_id_array[$i]}'";
            exit;

            $result2 =  mysqli_query($db, $update_query);
            activity_log($_SESSION['Klin_admin_user'], 'Assigned ' . get_val('emp_staff_details', 'id', $pool_id_array[$i], 'firstname') . ' ' . get_val('emp_staff_details', 'id', $id, 'surname') . ' to ' . get_val('emp_staff_details', 'id', $pool_id_array[$i], 'company_code') . '');

            $msg = 'Hello ' . get_val('emp_staff_details', 'id', $pool_id_array[$i], 'firstname') . ', you have successfully been assigned to ' . ucwords(get_val('emp_staff_details', 'id', $pool_id_array[$i], 'company_code')) . ' ';

            $query3 = "insert into notification set candidate_id = '" . get_val('emp_staff_details', 'id', $pool_id_array[$i], 'candidate_id') . "', notifier = 'Admin', message = '$msg', status = 'Unread', date = '" . today() . "'";
            $result2 =  mysqli_query($db, $query3);
            $job_val = get_val('positions', 'positionCode', $job, 'positionName');
            $location_val = get_val('locations', 'locationCode', $location, 'locationName');

            $hrb_message = "Candidate Details:<br><br><b>Fullname : </b> $fullname<br><b>Client : </b> $client 
        <br><b>Job Role : </b> $job_val 
        <br><b>Assessment Scores: </b> $scores%
        <br><b>Resumption Date : </b> $effective_date 
        <br><b>Work Location : </b> $location_val 
        <br><b>Salary : </b> $basic_salary 
        <br><b>Staff ID : </b> $staff_id 
        <br><a href='" . root() . "/client?client_link=yes&single=" . base64_encode($pool_id_array[$i]) . "'>Click here to view details</a>";
            $notification_check = "select * from login where privilege like '%HRBP%' and client like '%$client_code%'";


            $notification_result =  mysqli_query(
                $db,
                $notification_check
            );
            $notification_num = mysqli_num_rows($notification_result);
            for ($notify = 0; $notify < $notification_num; $notify++) {
                $notification_row = mysqli_fetch_array($notification_result);


                send_email($notification_row['email'], 'HRBP', org(), $fullname . ' has been assigned to Client', $hrb_message);
            }
        }

        $success = "Candidates successfully assigned to client";
        include('pool.php');
        exit;
    } else {



        // Optionally, you can print the array to check the result


        // Insert into emp_self_login
        $firstname = get_val('emp_staff_details', 'id', $pool_id, 'firstname');
        $lastname = get_val('emp_staff_details', 'id', $pool_id, 'surname');
        $middlename = get_val('emp_staff_details', 'id', $pool_id, 'middlename');
        $candidate_id = get_val('emp_staff_details', 'id', $pool_id, 'candidate_id');
        $fullname = $firstname . ' ' . $lastname . ' ' . $middlename;

        $staff_id = staff_id($valid_id, $id_format);



        if (staff_id_exists($staff_id) == 'yes') {
            $error = 'Staff ID already in the system. Please change staff ID';
            header("Location: pool?cat=cG9vbA==&error=$error");
            exit;
        }

        //update staff Records and Other information
        $update_query = "update emp_staff_details set EmployeeID = '$staff_id', staff_id = '$staff_id', company_code ='$client', position_code = '$job', date_employed = '$effective_date', location_code = '$location', effective_date= '$effective_date', salary = '$basic_salary', date_moved = '" . today() . "', completed = 'Client',salary_band = '$band' where id = '$pool_id'";


        $result2 = mysqli_query($db, $update_query);

        activity_log($_SESSION['Klin_admin_user'], 'Assigned ' . get_val('emp_staff_details', 'id', $pool_id, 'firstname') . ' ' . get_val('emp_staff_details', 'id', $id, 'surname') . ' to ' . get_val('emp_staff_details', 'id', $pool_id, 'company_code') . '');


        // $msg = 'Hello ' . get_val('emp_staff_details', 'id', $pool_id, 'firstname') . ', you have successfully been assigned to ' . ucwords(get_val('emp_staff_details', 'id', $pool_id, 'company_code')) . ' ';

        $query3 = "insert into notification set candidate_id = '" . get_val('emp_staff_details', 'id', $pool_id, 'candidate_id') . "', notifier = 'Admin', message = '$msg', status = 'Unread', date = '" . today() . "'";
        $result2 = mysqli_query($db, $query3);


        $job_val = get_val('positions', 'positionCode', $job, 'positionName');
        $location_val = get_val('locations', 'locationCode', $location, 'locationName');

        $hrb_message = "Candidate Details:<br><br><b>Fullname : </b> $fullname<br><b>Client : </b> $client 
        <br><b>Job Role : </b> $job_val 
        <br><b>Assessment Scores: </b> $scores%
        <br><b>Resumption Date : </b> $effective_date 
        <br><b>Work Location : </b> $location_val 
        <br><b>Salary : </b> $basic_salary 
        <br><b>Staff ID : </b> $staff_id 
        <br><a href='" . root() . "/client?client_link=yes&single=" . base64_encode($pool_id) . "'>Click here to view details</a>";

        // send email to HRBP in charge of employee based on client 
        $notification_check = "select * from login where privilege like '%HRBP%' and client like '%$client_code%'";


        $notification_result = mysqli_query($db, $notification_check);
        $notification_num = mysqli_num_rows($notification_result);
        for ($notify = 0; $notify < $notification_num; $notify++) {
            $notification_row = mysqli_fetch_array($notification_result);


            send_email($notification_row['email'], 'HRBP', org(), $fullname . ' has been assigned to Client', $hrb_message);
        }


        // Send to people who are under the deployment email notification

        $notification_check = "select * from notification_email where privilege = 'Deployment'";

        $notification_result = mysqli_query($db, $notification_check);
        $notification_num = mysqli_num_rows($notification_result);
        for ($notify = 0; $notify < $notification_num; $notify++) {
            $notification_row = mysqli_fetch_array($notification_result);

            send_email($notification_row['email'], 'Legal', org(), $fullname . ' has been assigned to Client', $hrb_message);
        }




        $success = "Candidate successfully assigned to client";
        include('pool.php');
        exit;
    }
}


$candidate_id = base64_decode($_GET['candidate_id']);


if (isset($_POST['btn_send_offer'])) {
    $id =  mysqli_real_escape_string($db, $_POST['id']);
    $candidates_id = mysqli_real_escape_string($db, $_POST['candidates_id']);
    $staff_id = mysqli_real_escape_string($db, $_POST['staff_id']);

    $client = mysqli_real_escape_string($db, $_POST['client']);
    $filename = $_POST['filename'];
    $candidate = mysqli_real_escape_string($db, $_POST['candidate']);
    $email =   mysqli_real_escape_string($db, $_POST['email']);
    $subject = mysqli_real_escape_string($db, $_POST['subject']);
    $cc = $_POST['cc'];
    $message = $_POST['message'];
    $file = 'generate_offer_letter/' . $filename;

    // $check = "select * from emp_self_login where email = '$email' ";
    // $check_result = mysqli_query($db, $check);
    // $row = mysqli_fetch_array($check_result);
    // if($row['email'] == $email)
    // {
    //     $error = "Offer Letter already generated";
    //     include('pool.php');
    //     exit;
    // }

    // for($i=0; $i<count($id); $i++)
    // {


    $pool_update = "update emp_staff_details set completed = 'client' where id = '$id'";
    $update_result = mysqli_query($db, $pool_update);
    if ($update_result) {

        $insert = "INSERT INTO emp_edit_staff_details select * from emp_staff_details where id = '$id' ";
        $insert_query = mysqli_query($db, $insert);

        application_log(get_val('emp_staff_details', 'candidate_id', $candidates_id, 'candidate_id'), get_val('jobs_applied', 'candidate_id', $candidates_id, 'job_id'), 'Assigned to ' . $client . ' ', 'Assigned to ' . get_val('emp_staff_details', 'id', $id, 'company_code') . ' ');

        activity_log($_SESSION['Klin_admin_user'], 'Assigned ' . get_val('emp_staff_details', 'id', $id, 'firstname') . ' ' . get_val('emp_staff_details', 'id', $id, 'surname') . ' to ' . get_val('emp_staff_details', 'id', $id, 'company_code') . '');


        $msg = 'Hello ' . get_val('emp_staff_details', 'candidate_id', $candidates_id, 'firstname') . ', you have successfully been assigned to ' . ucwords(get_val('emp_staff_details', 'id', $id, 'company_code')) . ' ';

        $query3 = "insert into notification set candidate_id = '" . get_val('emp_staff_details', 'candidate_id', $candidates_id, 'candidate_id') . "', notifier = 'Admin', message = '$msg', status = 'Unread', date = '" . today() . "'";
        $result2 =  mysqli_query($db, $query3);


        $default_msg = 'Kindly use this link <b><a href="staffportal.Talgen.net">STAFF PORTAL</a></b> to access the staffportal.<br>
        Your Staff Id is <b>' . get_val('emp_staff_details', 'id', $id, 'staff_id') . '</b> which is also your username.<br>
        Your Password is <b>' . get_val('emp_self_login', 'staff_id', $staff_id, 'pass') . '</b> ';

        mail_client($email, $cc, $subject, $message . ' ' . $default_msg, $file);

        // include('insert_candidate.php');



        $success = "Candidate successfully assigned to client";
        include('pool.php');
        exit;
    } else {
        $error = "Candidate already assigned to client";
        include('pool.php');
        exit;
    }
} else {
    echo 'Error';
    exit;
}
