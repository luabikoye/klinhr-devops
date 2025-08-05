<?php
include('connection/connect.php');

if (isset($_POST['value'])) {
    $value = $_POST['value'];

    $select = "select * from course where skill = '$value'";
    $result = mysqli_query($db, $select);

    if ($result) {
        $row = mysqli_fetch_array($result);
        // Value is present in the database, send it back to JavaScript
        $courses =  explode(',',$row['course']);

        echo '<select data-hs-tom-select-options="{
            "placeholder": "Select option"
        }" class="js-select form-select" id="locationLabel2" name="course" multiple>';
        echo '<option value="" disabled>Choose One</option>';
        
        for($i=0; $i<count($courses); $i++)
        {
            echo '<option>'.$courses[$i].'</option>';
        }

               echo' </select>';

    } else {
        // Value is not present in the database
        echo '';
    }
}
?>

