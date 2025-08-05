<?php
	//create MySQL connection
include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('Job Seeker');

    // Filter the excel data 
    function filterData(&$str){ 
        $str = preg_replace("/\t/", "\\t", $str); 
        $str = preg_replace("/\r?\n/", "\\n", $str); 
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
    } 
    
    // Excel file name for download 
    $fileName = "Registered Users" .' '. date('Y-m-d') . ' '. ".xls"; 
    
    $fields = array('ID', 'FIRST NAME', 'LAST NAME', 'EMAIL', 'PHONE', 'STATUS'); 
    
    // Display column names as first row 
    $excelData = implode("\t", array_values($fields)) . "\n"; 
    
    // Fetch records from database 
    if($col)
    {
        $query = $db->query("SELECT * FROM jobseeker_signup ORDER BY id ASC"); 
    }
    
if($_POST['check_id'])
{
    // for($i=0; $i<count($array_id); $i++)
    // {
    //     $id_list[] = " or id = '".$array_id[$i]."'";
    // }
    $id = $_POST['check_id'];
    $clause = implode(" or id = ", $id);
    $query = $db->query("SELECT * FROM  jobseeker_signup where id = $clause ORDER BY id ASC ");
    
}
else{
        $query = $db->query("SELECT * FROM jobseeker_signup ORDER BY id ASC"); 
    }


    if($query->num_rows > 0){ 
        // Output each row of the data 
        while($row = $query->fetch_assoc()){ 
            // $status = ($row['status'] == 1)?'Active':'Inactive'; 
            if($row['status'] == 'active')
            {
                $status = 'active';
            }
            else
            {
                $status = 'pending';
            }
            $lineData = array($row['id'], $row['firstname'], $row['lastname'], $row['email'], $row['phone'],ucwords($status)); 
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