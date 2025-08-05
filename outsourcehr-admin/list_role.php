               <div class="card">
                   <!-- Header -->
                   <div class="card-header card-header-content-md-between">
                       <div class="mb-2 mb-md-0">
                           <div class="input-group input-group-merge input-group-flush">
                               <div class="input-group-prepend input-group-text">
                                   <i class="bi-search"></i>
                               </div>
                               <input id="datatableSearch" type="search" class="form-control" placeholder="Search users" aria-label="Search users">
                           </div>
                       </div>
                   </div>
                   <!-- End Header -->



                   <!-- Table -->
                   <div class="table-responsive datatable-custom">

                       <table id="datatable" class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table" data-hs-datatables-options='{
                        "columnDefs": [{
                            "targets": [0],
                            "orderable": false
                            }],
                        "order": [],
                        "info": {
                            "totalQty": "#datatableWithPaginationInfoTotalQty"
                        },
                        "search": "#datatableSearch",
                        "entries": "#datatableEntries",
                        "pageLength": 15,
                        "isResponsive": false,
                        "isShowPaging": false,
                        "pagination": "datatablePagination"
                        }'>
                           <thead class="thead-light">
                               <tr>
                                   <th class="table-column-pe-0">
                                       <div class="form-check">
                                           <!-- <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll">
                                            <label class="form-check-label" for="datatableCheckAll"></label> -->
                                           S/N
                                       </div>
                                   </th>
                                   <th>Job Role</th>
                                   <th>Action</th>
                               </tr>
                           </thead>

                           <tbody>
                               <?php
                               if ($_SESSION['account_token']) {
                                    if ($_SESSION['privilege_user'] == 'administrator') {
                                        $query = "select * from role  order by id desc Where account_token = '" . $_SESSION['account_token'] . "'";
                                    } else {
                                        $query = "select * from role where user='" . $_SESSION['Klin_admin_user'] . "' and account_token = '" . $_SESSION['account_token'] . "' order by id desc";
                                    }
                               } else {
                                   if ($_SESSION['privilege_user'] == 'administrator') {
                                       $query = "select * from role  order by id desc";
                                   } else {
                                       $query = "select * from role where user='" . $_SESSION['Klin_admin_user'] . "'  order by id desc";
                                   }
                               }

                                $result = mysqli_query($db, $query);
                                $num_result = mysqli_num_rows($result);
                                for ($i = 0; $i < $num_result; $i++) {
                                    $s = $i + 1;
                                    $row = mysqli_fetch_array($result);
                                ?>
                                   <tr>
                                       <td class="table-column-pe-0">
                                           <?= $i + 1 ?>
                                       </td>
                                       <td class="table-column-ps-0">
                                           <a href="custom_objective?set_role=<?php echo base64_encode($row['role']); ?>"><?php echo $row['role']; ?></a>
                                       </td>
                                       <td>
                                           <a data-toggle="tooltip" data-placement="top" data-original-title="Delete" href="delete-record?id=<?php echo ($row['id']) ?>&tab=<?php echo ('role'); ?>&return=<?php echo ('role'); ?>" onclick="return confirm('Are you sure you want to take this action?');" class="btn btn-sm btn-outline-secondary"><i class=" bi-trash"></i></a>
                                       </td>
                                   </tr>
                               <?php } ?>
                           </tbody>
                       </table>
                   </div>
                   <!-- End Table -->

                   <!-- Footer -->
                   <div class="card-footer">
                       <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                           <div class="col-sm mb-2 mb-sm-0">
                               <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                                   <span class="me-2">Showing:</span>

                                   <!-- Select -->
                                   <div class="tom-select-custom">
                                       <select id="datatableEntries" class="js-select form-select form-select-borderless w-auto" autocomplete="off" data-hs-tom-select-options='{
                            "searchInDropdown": false,
                            "hideSearch": true
                          }'>
                                           <option value="10">10</option>
                                           <option value="15" selected>15</option>
                                           <option value="20">20</option>
                                       </select>
                                   </div>
                                   <!-- End Select -->

                                   <span class="text-secondary me-2">of</span>

                                   <!-- Pagination Quantity -->
                                   <span id="datatableWithPaginationInfoTotalQty"></span>
                               </div>
                           </div>
                           <!-- End Col -->

                           <div class="col-sm-auto">
                               <div class="d-flex justify-content-center justify-content-sm-end">
                                   <!-- Pagination -->
                                   <nav id="datatablePagination" aria-label="Activity pagination"></nav>
                               </div>
                           </div>
                           <!-- End Col -->
                       </div>
                       <!-- End Row -->
                   </div>
                   <!-- End Footer -->