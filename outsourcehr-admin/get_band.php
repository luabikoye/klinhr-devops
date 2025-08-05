<?php
ob_start();
session_start();
include("connection/connect.php");
require_once('inc/fns.php');

$client = $_POST['client'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {



    $query = "select * from salary_band where client = '" . $client . "' and account_token = '".$_SESSION['account_token']."'";
    $result = mysqli_query($db, $query);
    $num = mysqli_num_rows($result);

    echo ' <select name="band" class="form-control" style="width:100%" id="salary_band">';
    echo        '<option value="select_client">Select Band</option>';
    for ($i = 0; $i < $num; $i++) {
        $row = mysqli_fetch_array($result);
        echo '<option>' . ucwords($row['band']) . '</option>';
    }
    echo '</select>';
    // echo "<input type='hidden' value='$client' id='clients'>"
    // echo json_encode(array($band));

?>


    <script>
        $(document).ready(function() {


            $("#salary_band").change(function() {

                var salary_band = $(this).val();
                var client = $('#client').val();
                $.ajax({
                    url: "get_level.php",
                    method: "POST",
                    data: {
                        salary_band: salary_band,
                        client: client
                    },
                    success: function(response) {
                        $('#level').html(response);
                    }
                });
            });
        });
    </script>

<?php } else {
    echo 'Access denied';
}
?>