<?php

ob_start();
session_start();

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');
validatePermission('Employee Appraisal');
$id = base64_decode($_GET['id']);


$query = "select * from appraisal where id = '" . $id . "'";
$result = mysqli_query($db, $query);
$num = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);

$role = $row['role'];
$client = $row['client'];
$appraisal_role = $row['appraisal_role'];
$year = date('Y');
if ($appraisal_role == '360 Appraisal') {    
    $select = mysqli_query($db, "SELECT * FROM performance_period WHERE year = '$year' AND approve = 'Approved'");
    $num = mysqli_num_rows($select);    
    for ($i=0; $i < $num; $i++) {
        $row = mysqli_fetch_array($select);
        $staff = $row['staff_id'];
        $first_line_manager = $row['manager_name'];        
        $first_line_manager_email = $row['manager_email'];
        $query_emp = "select * from emp_staff_details where company_code = '" . get_val('clients', 'client_name', $client, 'client_code') . "' and position_code = '$role' and staff_id = '$staff'";        
        $result_emp = mysqli_query($db, $query_emp);
        $num_emp = mysqli_num_rows($result_emp);
        if ($num_emp != 0) {
            for ($i = 0;
                $i < $num_emp;
                $i++
            ) {
                $row_emp = mysqli_fetch_array($result_emp);

                $query_app = "insert into emp_appraisald_self set staff_id = '" . $row_emp['staff_id'] . "', firstname =  '" . $row_emp['firstname'] . "', lastname =  '" . $row_emp['surname'] . "', current_job =  '" . $row_emp['position_code'] . "', appraisal_id =  '" . $id . "', employment_date =  '" . $row_emp['effective_date'] . "', appraisal_period = '" . date('F, Y') . "', email =  '" . $row_emp['email_address'] . "', phone =  '" . $row_emp['mobile_phone_number'] . "', status = 'Pending', first_line_manager = '$first_line_manager', first_line_email = '$first_line_manager_email'";                
                                
                $result_app = mysqli_query($db, $query_app);
                if ($result_app) {
                    //mail staff about appraisal                                        
                    $start = mysqli_query($db, "SELECT * FROM performance_objective WHERE staff_id = '$staff'");
                    $start_num = mysqli_num_rows($start);
                    for ($i=0; $i < $start_num; $i++) { 
                        $start_row = mysqli_fetch_array($start);
                        $kpi_p = $start_row['perspective'];
                        $kra = $start_row['resultarea'];
                        $kpi_d = $start_row['description'];
                        $question = $start_row['measure'];
                        $weight = $start_row['weight'];
                        $score = $start_row['target'];
                        $user = $_SESSION['Klin_admin_user'];
                        $staff_id = $row_emp['staff_id'];
                        // "INSERT INTO custom_q SET kpi_p = '$kpi_p', kra = '$kra', kpi_d = '$kpi_d', question = '$question', weight = '$weight', score = '$score', role = '360 Appraisal', staff_id = '$staff_id', user = '$user'"
                        $custom = mysqli_query($db, "INSERT INTO custom_q SET kpi_p = '$kpi_p', kra = '$kra', kpi_d = '$kpi_d', question = '$question', weight = '$weight', score = '$score', role = '360 Appraisal', staff_id = '$staff_id', user = '$user'");
                    }                    
                    $message = 'You have been scheduled for appraisal. Kindly logon to the staff portal using the URL below and click on the appraisal menu. <b><a href="' . staff_portal() . '"> STAFF PORTAL - ' . staff_portal() . '</a> </b> ';
                    
                    // send_email($row_emp['email_address'], $row_emp['firstname'].' '.$row_emp['surname'], organisation(),'You have been scheduled for Appraisal', $message);


                }
                else{
                    $error = "Sorry this appraisal has already started";
                    include('set-appraisal.php');
                    exit;
                }
            }            
            //update appraisal table status
            
            $query = "update appraisal set status = 'Started' where id = '" . $id . "'";
            $result = mysqli_query($db, $query);            
        }
    }    
}
else {
    //get staff of the role and client above
    $query_emp = "select * from emp_staff_details where company_code = '" . get_val('clients', 'client_name', $client, 'client_code') . "' and position_code = '$role'";
    $result_emp = mysqli_query($db, $query_emp);
    $num_emp = mysqli_num_rows($result_emp);
    for ($i = 0; $i < $num_emp; $i++) {
        $row_emp = mysqli_fetch_array($result_emp);

        $query_app = "insert into emp_appraisald_self set staff_id = '" . $row_emp['staff_id'] . "', firstname =  '" . $row_emp['firstname'] . "', lastname =  '" . $row_emp['surname'] . "', current_job =  '" . $row_emp['position_code'] . "', appraisal_id =  '" . $id . "', employment_date =  '" . $row_emp['effective_date'] . "', appraisal_period = '" . date('F, Y') . "', email =  '" . $row_emp['email_address'] . "', phone =  '" . $row_emp['mobile_phone_number'] . "', status = 'Pending'";
        $result_app = mysqli_query($db, $query_app);
        if ($result_app) {
            //mail staff about appraisal
            $message = 'You have been scheduled for appraisal. Kindly logon to the staff portal using the URL below and click on the appraisal menu. <b><a href="' . staff_portal() . '"> STAFF PORTAL - ' . staff_portal() . '</a> </b> ';

            // send_email($row_emp['email_address'], $row_emp['firstname'].' '.$row_emp['surname'], organisation(),'You have been scheduled for Appraisal', $message);


        }
    }
    //update appraisal table status

    $query = "update appraisal set status = 'Started' where id = '" . $id . "'";
    $result = mysqli_query($db, $query);
    // $num = mysqli_num_rows($result);
}

header("Location: set-appraisal");