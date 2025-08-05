<?php
	//create MySQL connection
include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('Assessment');

$col = base64_decode($_GET['col']);
$val = base64_decode($_GET['val']);

    // Filter the excel data 
    function filterData(&$str){ 
        $str = preg_replace("/\t/", "\\t", $str); 
        $str = preg_replace("/\r?\n/", "\\n", $str); 
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
    } 
    
    // Excel file name for download 
    $fileName = "Applicants_Exam_Result" .' '. date('Y-m-d') . ' '. ".xls"; 
    
    $fields = array('ID', 'FIRST NAME', 'LAST NAME', 'EMAIL', 'PHONE', 'JOB TITLE', 'SCORES', 'STATUS', 'START TIME', 'END TIME'); 
    
    // Display column names as first row 
    $excelData = implode("\t", array_values($fields)) . "\n"; 
    
    
if($array_id)
{
    for ($i = 0; $i < count($array_id); $i++) {
        $id_list[] = " or id = '" . $array_id[$i] . "'";
    }
    $clause = implode('', $id_list);
    $query = $db->query("SELECT * FROM exam_result where job_applied_id = '" . $array_id[0] . "' " . $clause);
    
}
else{
        $query = $db->query("select * from exam_result where archieved IS NULL order by id desc"); 
    }


    if($query->num_rows > 0){ 
        // Output each row of the data 
        while($row = $query->fetch_assoc()){ 
            // $status = ($row['status'] == 1)?'Active':'Inactive'; 
            $lineData = array($row['id'], $row['fname'], $row['lname'], $row['email'], $row['phone'], $row['job_title'], $row['average'], $row['start_time'], $row['end_time'], $row['status']); 
            array_walk($lineData, 'filterData'); 
            $excelData .= implode("\t", array_values($lineData)) . "\n"; 
        } 
    }else{ 
        $excelData .= 'No records found...'. "\n"; 
    } 
    
    // Headers for download 

    header("Content-Type: application/vnd.ms-excel"); 
    header("Content-Disposition: attachment; filename=\"$fileName\""); 

    
    // Render excel data 
    echo $excelData; 
    
    exit;