<?php



include('connection/connect.php');
require_once('inc/fns.php');

if ($_GET['token']) {
  $token = $_GET['token'];
}

// SQL query
$sql = "SELECT * FROM employees where pay_token = '$token'";
$res = mysqli_query($db, $sql);
$row = mysqli_fetch_array($res);
$pay_month = $row['pay_month'];

  

// Open file for writing
$file = fopen("data_$pay_month.csv", "w");

// Write header row
$headers = ["Onboard_id", "Staff_id", "Position", "Department", "Firstname", "Lastname", "Email", "Phone", "Bank Name", "Bank Account", "Pay Month", "Salary", "Paye", "Pension", "Total Deduction", "Client"];
fputcsv($file, $headers);

// Process result set
$result = mysqli_query($db, $sql);
$num = mysqli_num_rows($result);
for ($i = 0; $i < $num; $i++) {
  $row = mysqli_fetch_array($result);
  $data = [$row["onboard_id"], $row["staff_id"], $row["position"], $row["department"], $row["firstname"], $row["lastname"], $row["email"], $row["phone"], $row["bank_name"], $row["bank_account"], $row["pay_month"], $row["salary"], $row["paye"], $row["pension"], $row["total_deduction"], $row["client"]];
  fputcsv($file, $data);
}

// Close file and connection
fclose($file);
// $db->close();

// // echo "Data exported successfully!";
// header("Content-Type: application/octet-stream");
// header("Content-Disposition: attachment; filename=data.csv");
// header("Content-Length: " . filesize("data.csv")); // Replace with actual file size

// // Stream the file content
// fpassthru(fopen("data.csv", "r"));

?>
