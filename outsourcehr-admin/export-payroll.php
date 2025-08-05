<?php



include('connection/connect.php');
require_once('inc/fns.php');

if (isset($_GET['token'])) {
    // Sanitize the input to avoid SQL injection
    $token = mysqli_real_escape_string($db, $_GET['token']);

    $sql = "SELECT * FROM employees WHERE pay_token = '$token'";
    $result = mysqli_query($db, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $pay_month = $row['pay_month'];

        // Open file for writing
        $file = fopen("data_$pay_month.csv", "w");

        // Write header row
        $headers = ["Onboard_id", "Staff_id", "Barcode", "Position", "Department", "Firstname", "Lastname", "Email", "Phone", "Bank Name", "Bank Account", "Pay Month", "Salary", "Paye", "Pension", "Total Deduction", "Client", "Status", "Emp Status", "Year", "Month", "Month Year"];
        fputcsv($file, $headers);

        // Write data rows
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data = [$row["onboard_id"], $row["staff_id"], $row["barcode"], $row["position"], $row["department"], $row["firstname"], $row["lastname"], $row["email"], $row["phone"], $row["bank_name"], $row["bank_account"], $row["pay_month"], $row["salary"], $row["paye"], $row["pension"], $row["total_deduction"], $row["client"], $row["status"], $row["emp_status"], $row["year"], $row["month"], $row["month_year"]];
            fputcsv($file, $data);
        }

        // Close the file
        fclose($file);

        // Provide file for download
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=data_$pay_month.csv");
        header("Content-Length: " . filesize("data_$pay_month.csv"));

        // Stream the file content
        fpassthru(fopen("data_$pay_month.csv", "r"));
        exit;
    }
}
