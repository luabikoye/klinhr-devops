<?php


include('connection/connect.php');


// Filter the excel data 
function filterData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// Excel file name for download 
$fileName = "KlinHr - Payslip Details" . ' ' . date('Y-m-d') . ' ' . ".xls";
//id	staff_id	date	bank	account_no	names	basic	transportation	housing	lunch	health	dressing	furniture	leave	differential	n_month	reimbusable	utility	education	entertainment	cost_of_living	emp_contribution	xmas_bonus	gratuity	holiday	joining_bonus	location	telephone	domestic	overtime	arrears	nsitf	insurance	commission	passages	subsidy	tax	pension	loan	leave_allowance	n_month2	nhf	medical	nubifie	city_ledger	dressing2	holiday2	emp_contribution_debt	salary_advance	total_deduction	net_pay	gross_pay

// Column names 
$fields = array('staff_id', 'date', 'bank', 'account_no', 'names', 'basic', 'transportation', 'housing', 'lunch', 'health', 'dressing', 'furniture', 'leave', 'differential', 'n_month', 'reimbusable', 'utility', 'education', 'entertainment', 'cost_of_living', 'emp_contribution', 'xmas_bonus', 'gratuity', 'holiday', 'joining_bonus', 'location', 'telephone', 'domestic', 'overtime', 'arrears', 'nsitf', 'insurance', 'commission', 'passages', 'subsidy', 'tax', 'pension', 'loan', 'leave_allowance', 'n_month2', 'nhf', 'medical',    'nubifie',    'city_ledger', 'dressing2',    'holiday2',    'emp_contribution_debt', 'salary_advance', 'total_deduction', 'net_pay',    'gross_pay');

// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n";

// Fetch records from database 
$token = base64_decode($_GET['t']);
if ($token) {
    $query = $db->query("SELECT * FROM emp_self_payslip where token = '$token' ORDER BY id ASC");
} else {

    $query = $db->query("SELECT * FROM emp_self_payslip ORDER BY id  ASC");
}



if ($query->num_rows > 0) {
    // Output each row of the data 
    while ($row = $query->fetch_assoc()) {
        // $status = ($row['status'] == 1)?'Active':'Inactive'; 
        $lineData = array($row['staff_id'], $row['date'],  $row['bank'], $row['account_no'], $row['names'],  $row['basic'], $row['transportation'], $row['housing'],  $row['lunch'], $row['health'], $row['dressing'],  $row['furniture'], $row['emp_leave'], $row['differential'],  $row['n_month'], $row['reimbusable'], $row['utility'],  $row['education'], $row['entertainment'], $row['cost_of_living'],  $row['emp_contribution'], $row['xmas_bonus'], $row['gratuity'],  $row['holiday'], $row['joining_bonus'], $row['location'],  $row['telephone'], $row['domestic'], $row['overtime'],  $row['arrears'], $row['nsitf'], $row['insurance'],  $row['commission'], $row['passages'], $row['subsidy'],  $row['tax'], $row['pension'], $row['loan'],  $row['leave_allowance'], $row['n_month2'], $row['nhf'],  $row['medical'], $row['nubifie'], $row['city_ledger'],  $row['dressing2'], $row['holiday2'], $row['emp_contribution_debt'],  $row['salary_advance'], $row['total_deduction'], $row['net_pay'],  $row['gross_pay']);
        array_walk($lineData, 'filterData');
        $excelData .= implode("\t", array_values($lineData)) . "\n";
    }
} else {
    $excelData .= 'No records found...' . "\n";
}

// Headers for download 

header("Content-Type:  application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$fileName\"");


// Render excel data 
echo $excelData;

exit;
