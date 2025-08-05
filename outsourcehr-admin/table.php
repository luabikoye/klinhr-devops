<?php

session_start();

                    $key = base64_encode('l7l4kE5' . '7f4b3e88c885405fb1908a476287e4c7');
                    echo $key;                    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sample Table</title>
    <style>
        table {
            border-collapse: collapse;
            width: 60%;
            margin: 20px auto;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 8px 12px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <h2 style="text-align:center;">Sample HTML Table</h2>

    <div class="row" style="margin-bottom: 10px;">
        <div class="col-sm-12 col-md-7">
            <div class="entries-selector">
                <label for="entries-select">Show</label>
                <select id="entriesPerPage" class="form-select form-select-sm">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="-1">All</option>
                </select>
                <span>entries</span>

            </div>
        </div>
        <div class="col-sm-12 col-md-2"></div>
        <div class="col-sm-12 col-md-3">
            <div class="show__entries-right">
                Search: <input type="text" id="tableSearch">
            </div>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>S/n</th>
                <th class="table-column-ps-0">Staff Id</th>
                <th>FullName</th>
                <th>Position</th>
                <th>Client</th>
                <th>Qualifiation</th>
                <th>Class Of Degree</th>
                <th>Date Joined</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div id="datatablePagination" class="datatablePagination"></div>

</body>
<script>
    localStorage.setItem('userPrivilege', '<?php echo 'Super Admin'; ?>');
    localStorage.setItem('cat', '<?php echo 'N'; ?>');
    window.APP_CONFIG = {
        FILE_DIR: '<?php echo 'uploads/documents' ?>'
    };
</script>

</html>
<script src="staff_list.js"></script>