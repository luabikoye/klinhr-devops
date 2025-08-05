<?php
	//create MySQL connection
include('connection/connect.php');

$col = base64_decode($_GET['col']);
$val = base64_decode($_GET['val']);
$status = base64_decode($_GET['status']);

    // Filter the excel data 
    function filterData(&$str){ 
        $str = preg_replace("/\t/", "\\t", $str); 
        $str = preg_replace("/\r?\n/", "\\n", $str); 
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
    } 
    
    // Excel file name for download 
    $fileName = "Applicants" .' '. date('Y-m-d') . ' '. ".xls"; 

    if($status || $_POST['candidate_id'])
    {
        $fields = array('ID', 'EMPLOYEE ID', 'ONBOARDING CODE', 'STAFF ID', 'CANDIDATE ID','DATE', 'STATUS', 'SURNAME','FIRSTNAME','MIDDLENAME', 'SEX','MARITAL STATUS', 'DOB','DATE EMPLOYED','COMPANY CODE', 'LOCATION CODE', 'REGION CODE','DEPARTMENT CODE','GRADE CODE','POSITION CODE','PAYMENT CODE','BANK ACCOUNT NUMBER','PFA CODE','PENSION PIN','NHF PIN','MOBILE PHONE NUMBER','HOME PHONE NUMBER', 'EMAIL ADDRESS','STATE OF ORIGIN','LOCAL GOVT ORIGIN CODE','COUNTRY CODE', 'CURRENT ADDRESS 1','CURRENT ADDRESS 2','CURRENT ADDRESS TOWN','CURRENT ADDRESS STATE CODE','1ST PREVIOUS EMPLOYER NAME', '1ST PREVIOUS EMPLOYER POSITION','1ST PREVIOUS EMPLOYER ADDRESS 1','1ST PREVIOUS EMPLOYER ADDRESS 2','1ST PREVIOUS EMPLOYER PERSON','1ST PREVIOUS EMPLOYER EMAIL','1ST PREVIOUS EMPLOYER PHONE','1ST PREVIOUS EMPLOYER TOWN','1ST PREVIOUS EMPLOYER STATE CODE','2ND PREVIOUS EMPLOYER NAME','2ND PREVIOUS EMPLOYER ADDRESS 1','2ND PREVIOUS EMPLOYER ADDRESS 2','2ND PREVIOUS EMPLOYER PERSON','2ND PREVIOUS EMPLOYER EMAIL','2ND PREVIOUS EMPLOYER PHONE','2ND PREVIOUS EMPLOYER TOWN','2ND PREVIOUS EMPLOYER STATE CODE','1ST REFEREE NAME','1ST REFEREE ADDRESS 1','1ST REFEREE ADDRESS 2','1ST REFEREE TOWN','1ST REFEREE STATE CODE','1ST REFEREE PHONE','1ST REFEREE EMAIL','2ND REFEREE NAME','2ND REFEREE ADDRESS 1','2ND REFEREE ADDRESS 2','2ND REFEREE TOWN','2ND REFEREE STATE CODE','2ND REFEREE PHONE','2ND REFEREE EMAIL','1ST GUARANTOR NAME','1ST GUARANTOR ADDRESS 1','1ST GUARANTOR ADDRESS 2','1ST GUARANTOR TOWN','1ST GUARANTOR STATE CODE','1ST GUARANTOR PHONE','1ST GUARANTOR EMAIL','1ST GUARANTOR COMPANY','1ST GUARANTOR COMPANY ADDRESS','1ST GUARANTOR GRADE','1ST GUARANTOR NO OF YEARS','2ND GUARANTOR NAME','2ND GUARANTOR ADDRESS 1','2ND GUARANTOR ADDRESS 2','2ND GUARANTOR TOWN','2ND GUARANTOR STATE CODE','2ND GUARANTOR PHONE','2ND GUARANTOR EMAIL','2ND GUARANTOR COMPANY','2ND GUARANTOR COMPANY ADDRESS','2ND GUARANTOR GRADE','2ND GUARANTOR NO OF YEARS','NEXT OF KIN NAME','NEXT OF KIN RELATIONSHIP','NEXT OF KIN ADDRESS 1','NEXT OF KIN ADDRESS 2','NEXT OF KIN TOWN','NEXT OF KIN STATE CODE','NEXT OF KIN PHONE','NEXT OF KIN EMAIL','1ST INSTITUTION CODE','1ST QUALIFICATION CODE','1ST COURSE CODE','1ST RESULT GRADE','1ST GRADUATION YEAR','2ND INSTITUTION CODE','2ND QUALIFICATION CODE','2ND COURSE CODE','2ND RESULT GRADE','2ND GRADUATION YEAR','NYSC ID NO','START DATE','END DATE','SALARY','EFFECTIVE DATE','LEAVE DAYS','DATE PENDING','DATE MOVED','CREATED BY'); 
    }
    else
    {

        $fields = array('ID', 'FIRST NAME', 'LAST NAME', 'EMAIL', 'PHONE', 'GENDER', 'AGE', 'STATE', 'JOB TITLE', 'QUALIFICATION', 'CLASS DEGREE', 'DATE APPLIED'); 
    }
    
    
    // Display column names as first row 
    $excelData = implode("\t", array_values($fields)) . "\n"; 
    
    // Fetch records from database 
    if($col)
    {
        $query = $db->query("SELECT * FROM jobs_applied where $col = '$val' ORDER BY id ASC"); 
    }

    // if($status)
    // {
    //     $query = $db->query("SELECT * FROM emp_staff_details where $col = '$status' ORDER BY id ASC"); 
    // }
    
    if($array_id )
    {
        for($i=0; $i<count($array_id); $i++)
        {
            $id_list[] = " or id = '".$array_id[$i]."'";
        }

        $clause = implode('' ,$id_list);
        
        if($_POST['candidate_id'])
        {
            $query = $db->query("SELECT * FROM emp_staff_details where id = '".$array_id[0]."' ".$clause);
        }
        else
        {
            $query = $db->query("SELECT * FROM jobs_applied where id = '".$array_id[0]."' ".$clause);
        }
       
        
    }

    elseif($status)
    {
        $query = $db->query("SELECT * FROM emp_staff_details where $col = '$status' ORDER BY id ASC"); 
    }
    else
    {
        $query = $db->query("SELECT * FROM jobs_applied ORDER BY id ASC"); 
    }


    if($query->num_rows > 0)
    { 
        // Output each row of the data 
        while($row = $query->fetch_assoc())
        { 
            if($status || $_POST['candidate_id'])
            {
                $lineData = array($row['id'], $row['EmployeeId'], $row['onboarding_code'], $row['staff_id'], $row['candidate_id'], 
                $row['date'], $row['status'], $row['surname'], $row['firstname'], 
                $row['middlename'], $row['sex'], $row['marital_status'], $row['date_of_birth'], 
                $row['date_employed'], $row['company_code'], $row['location_code'], $row['region_code'], $row['	department_code'], $row['grade_code'], $row['position_code'], $row['payment_code'], $row['bank_account_number'], $row['	pfa_code'], $row['pension_pin'], $row['nhf_pin'], $row['mobile_phone_number'], $row['home_phone_number'], $row['email_address'], $row['state_origin'], $row['local_govt_of_origin_code'], $row['country_code'], $row['current_address_1'], $row['current_address_2'], $row['current_address_town'], $row['current_address_state_code'], $row['1st_previous_employer_name'], $row['prev_employer_position'], $row['1st_previous_employer_address_1'], $row['1st_previous_employer_address_2'], $row['n_prev_1st_emp_person'], $row['n_prev_1st_emp_email'], $row['n_prev_1st_emp_phone'], $row['1st_previous_employer_town'], $row['1st_previous_employer_state_code'], $row['2nd_previous_employer_name'], $row['2nd_previous_employer_address_1'], $row['2nd_previous_employer_address_2'], $row['n_prev_2nd_emp_person'], $row['n_prev_2nd_emp_email'], $row['n_prev_2nd_emp_phone'], $row['2nd_previous_employer_town'], $row['2nd_previous_employer_state_code'], $row['1st_referee_name'], $row['1st_referee_address_1'], $row['1st_referee_address_2'], $row['1st_referee_town'], $row['1st_referee_state_code'], $row['1st_referee_phone'], $row['1st_referee_email'], $row['2nd_referee_name'], $row['2nd_referee_address_1'], $row['2nd_referee_address_2'], $row['2nd_referee_town'], $row['2nd_referee_state_code'], $row['2nd_referee_phone'], $row['2nd_referee_email'], $row['1st_guarantor_name'], $row['1st_guarantor_address_1'], $row['1st_guarantor_address_2'], $row['1st_guarantor_town'], $row['1st_guarantor_state_code'], $row['1st_guarantor_phone'], $row['1st_guarantor_email'], $row['n_1st_guarantor_company'], $row['n_1st_guarantor_address'], $row['n_1st_guarantor_grade'], $row['n_1st_guarantor_no_years'], $row['2nd_guarantor_name'], $row['2nd_guarantor_address_1'], $row['2nd_guarantor_address_2'], $row['2nd_guarantor_town'], $row['2nd_guarantor_state_code'], $row['2nd_guarantor_phone'], $row['2nd_guarantor_email'], $row['n_2nd_guarantor_company'], $row['n_2nd_guarantor_address'], $row['n_2nd_guarantor_grade'], $row['n_2nd_guarantor_no_years'], $row['next_of_kin_name'], $row['nok_relationship'], $row['next_of_kin_address_1'], $row['next_of_kin_address_2'], $row['next_of_kin_town'], $row['	next_of_kin_state_code'], $row['next_of_kin_phone'], $row['next_of_kin_email'], $row['1st_institution_code'], $row['1st_qualification_code'], $row['1st_course_code'], $row['1st_result_grade'], $row['1st_graduation_year'], $row['	2nd_institution_code'], $row['2nd_qualification_code'], $row['2nd_course_code'], $row['2nd_result_grade'], $row['2nd_graduation_year'], $row['nysc_id_no'], $row['start_date'], $row['end_date'], $row['salary'], $row['effective_date'], $row['leave_days'], $row['date_pending'], $row['date_moved'], $row['created_by']); 
                array_walk($lineData, 'filterData'); 

            }
            else
            {
                // $status = ($row['status'] == 1)?'Active':'Inactive'; 
                $lineData = array($row['id'], $row['firstname'], $row['lastname'], $row['email'], $row['phone'], $row['gender'], $row['age'], $row['state'], $row['job_title'], $row['qualification'], $row['class_degree'], $row['date_applied']); 
                array_walk($lineData, 'filterData'); 
            }
            $excelData .= implode("\t", array_values($lineData)) . "\n"; 
        } 
    }
    else
    { 
        $excelData .= 'No records found...'. "\n"; 
    } 
    
    // Headers for download 
    header("Content-Type: application/vnd.ms-excel"); 
    header("Content-Disposition: attachment; filename=\"$fileName\""); 

    // Render excel data 
    echo $excelData; 

  
    
    exit;