<?php
ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');

$today = date('Y-m-d');

$sql = mysqli_query($db, "select * from employees");
$num = mysqli_num_rows($sql);

for ($i = 0; $i < $num; $i++) {
    $row = mysqli_fetch_assoc($sql);
    $pay .= '{"amount" => ' . number_format($row['salary'], 2) . ',
"recipient" => "' . $row['recipient_code'] . '",
"reference" => "ref_' . uniqid() . '"
},';
}

$url = "https://api.paystack.co/transfer/bulk";
$fields = [
    "currency" => "NGN",
    "source" => "balance",
    "transfers" => [
        $pay
    ]
];
$fields_string = http_build_query($fields);
//open connection
$ch = curl_init();
//set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Authorization: Bearer sk_test_1eb21d21f2343674435b21c5e86ab8c4a40ac9bf",
    "Cache-Control: no-cache",
));

//So that curl_exec returns the contents of the cURL; rather than echoing it
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute post
$result = curl_exec($ch);
echo $result;
exit;

header('Location:disburse?success=1');
exit;
