<?php
	//create MySQL connection
include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('Employee Appraisal');

$col = base64_decode($_GET['col']);
$val = base64_decode($_GET['val']);
$status = base64_decode($_GET['status']);

$id = base64_decode($_GET['id']);

$individual_id = $_POST['id'];

    // Filter the excel data 
    function filterData(&$str){ 
        $str = preg_replace("/\t/", "\\t", $str); 
        $str = preg_replace("/\r?\n/", "\\n", $str); 
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
    } 
    
    // Excel file name for download 
    $fileName = "Staff Appraisal" .' '. date('Y-m-d') . ' '. ".xls"; 

    if($_GET['id'] || $col || $individual_id)
    {
        $fields = array('ID', 'DATE', 'STAFF ID ', 'FIRSTNAME ', 'LASTNAME ', 'BRANCH', 'CURRENT JOB','EMPLOYMENT DATE','APPRAISAL PERIOD', 'EMAIL','PHONE','COMMENT 1', 'COMMENT 2', 'COMMENT 3','COMMENT 4','TOTAL','RECOMMENDATION'); 
    }
    
        
    // Display column names as first row 
    $excelData = implode("\t", array_values($fields)) . "\n"; 
    
    // Fetch records from database 
    if($col)
    {
        $query = $db->query("SELECT * FROM emp_appraisald_self  ORDER BY id ASC"); 
    }

    // IF THERE IS AN ARRAY OF SELECTED RECORDS
    
    elseif($individual_id)
    {
        for($i=0; $i<count($individual_id); $i++)
        {
            $id_list[] = " or id = '".$individual_id[$i]."'";
        }

        $clause = implode('' ,$id_list);        
        
        $query = $db->query("SELECT * FROM emp_appraisald_self where id = '".$individual_id[0]."' ".$clause);        
    }

    elseif(($_GET['id']))
    {
        $query = $db->query("SELECT * FROM emp_appraisald_self where appraisal_id = '".base64_decode($_GET['id'])."' ORDER BY id ASC");         
    }

   

    if($query->num_rows > 0)
    { 
        // Output each row of the data 
        while($row = $query->fetch_assoc())
        {         
            $lineData = array($row['id'], $row['date'], $row['staff_id'],  $row['firstname'], $row['lastname'], 
            $row['branch'], $row['current_job'], $row['employment_date'], $row['appraisal_period'], 
            $row['email'], $row['phone'], $row['comment1'], $row['coment2'], $row['	comment3'], $row['coment4'], $row['total'], $row['recomendation']); 
            array_walk($lineData, 'filterData'); 
        
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