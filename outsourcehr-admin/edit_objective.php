               <?php

                ob_start();
                session_start();

                if ($_SESSION['privilege_user'] == 'administrator') {
                    $query = "select * from custom_q where role = '" . $_SESSION['role'] . "' ";
                } else {
                    $query = "select * from custom_q where role = '" . $_SESSION['role'] . "'";
                }
                $result = mysqli_query($db, $query);
                $num_rows = mysqli_num_rows($result);
                for ($i = 1; $i <= $num_rows; $i++) {
                    $row = mysqli_fetch_array($result);
                ?>
                   <?php if ($success) echo '<div class="alert alert-success">' . $success . '</div>'; ?>
                   <?php if ($error) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>


                   <div id="obj<?php echo $i; ?>" class="objectives_none">
                       <div class="step-content">
                           <h3 class="">Objective <?php echo $i; ?></h3>
                       </div>

                       <!-- End Step -->

                       <!-- Content Step Form -->
                       <div id="addUserStepFormContent">
                           <!-- Card -->
                           <div id="addUserStepProfile" class="card card-lg active">
                               <!-- Body -->
                               <div class="card-body">



                                   <!-- Form -->
                                   <div class="row mb-4">
                                       <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">Key Perspective </label>

                                       <div class="col-sm-9">
                                           <input type="text" class="form-control" name="kpi_p[]" id="question" title="Enter KPI" value="<?php echo $row['kpi_p']; ?>">
                                       </div>
                                   </div>
                                   <!-- End Form -->

                                   <!-- Form -->
                                   <div class="row mb-4">
                                       <label for="locationLabel" class="col-sm-3 col-form-label form-label">Key Result Area</label>

                                       <div class="col-sm-9">
                                           <!-- Select -->
                                           <input type="text" class="form-control" name="kra[]" id="question" title="Enter KPI" value="<?php echo $row['kra']; ?>">
                                       </div>
                                       <!-- End Form -->
                                   </div>


                                   <!-- Form -->
                                   <div class="row mb-4">
                                       <label for="locationLabel" class="col-sm-3 col-form-label form-label">KPI Description</label>

                                       <div class="col-sm-9">
                                           <!-- Select -->
                                           <input type="text" class="form-control" name="kpi_d[]" id="question" title="Enter KPI" value="<?php echo $row['kpi_d']; ?>">
                                           <!-- End Select -->
                                       </div>
                                   </div>
                                   <!-- End Form -->


                                   <!-- Form -->
                                   <div class="row mb-4">
                                       <label for="locationLabel" class="col-sm-3 col-form-label form-label">KPI Measure</label>

                                       <div class="col-sm-9">
                                           <!-- Select -->
                                           <input type="text" class="form-control" name="question[]" id="question" title="Enter KPI" value="<?php echo $row['question']; ?>">
                                           <!-- End Select -->
                                       </div>
                                   </div>
                                   <!-- End Form -->
                                   <!-- End Form -->



                                   <!-- Form -->
                                   <div class="row mb-4">
                                       <label for="locationLabel" class="col-sm-3 col-form-label form-label">Weight %</label>

                                       <div class="col-sm-9">
                                           <!-- Select -->
                                           <input type="text" class="form-control weight" name="weight[]" title="Enter KPI" placeholder="Weight" id="weight %" value="<?php echo $row['weight']; ?>">
                                           <!-- End Select -->
                                       </div>
                                   </div>
                                   <!-- End Form -->

                                   <!-- Form -->
                                   <div class="row mb-4">
                                       <label for="locationLabel" class="col-sm-3 col-form-label form-label">Target</label>

                                       <!-- clients logo  -->
                                       <div class="col-sm-9">
                                           <input type="text" class="form-control score" name="score[]" id="score" placeholder="Target" value="<?php echo $row['score']; ?>">
                                       </div>
                                       <!-- / clients logo  -->
                                   </div>
                                   <!-- End Form -->
                               </div>
                               <!-- End Body -->
                           </div>
                       </div>
                       <p class="m-5"><a id="addmore<?php echo $i; ?>">[+]Add more objectives</a> </p>
                   </div>
               <?php }
                ?>


               <!--  for new records -->

               <?php
                //max number of additional KPI
                $max_row = 20 - $num_rows;
                $cont_num = $num_rows + 1;

                for ($x = $cont_num; $x <= $max_row; $x++) {
                ?>
                   <div id="obj<?php echo $x; ?>" class="objectives">
                       <div class="step-content">
                           <h3 class="">Objective <?php echo $x; ?></h3>
                       </div>

                       <!-- End Step -->

                       <!-- Content Step Form -->
                       <div id="addUserStepFormContent">
                           <!-- Card -->
                           <div id="addUserStepProfile" class="card card-lg active">
                               <!-- Body -->
                               <div class="card-body">



                                   <!-- Form -->
                                   <div class="row mb-4">
                                       <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">Key Perspective </label>

                                       <div class="col-sm-9">
                                           <input type="text" class="form-control" name="kpi_p[]" id="question" title="Enter KPI">
                                       </div>
                                   </div>
                                   <!-- End Form -->

                                   <!-- Form -->
                                   <div class="row mb-4">
                                       <label for="locationLabel" class="col-sm-3 col-form-label form-label">Key Result Area</label>

                                       <div class="col-sm-9">
                                           <!-- Select -->
                                           <input type="text" class="form-control" name="kra[]" id="question" title="Enter KPI">
                                       </div>
                                       <!-- End Form -->
                                   </div>


                                   <!-- Form -->
                                   <div class="row mb-4">
                                       <label for="locationLabel" class="col-sm-3 col-form-label form-label">KPI Description</label>

                                       <div class="col-sm-9">
                                           <!-- Select -->
                                           <input type="text" class="form-control" name="kpi_d[]" id="question" title="Enter KPI">
                                           <!-- End Select -->
                                       </div>
                                   </div>
                                   <!-- End Form -->


                                   <!-- Form -->
                                   <div class="row mb-4">
                                       <label for="locationLabel" class="col-sm-3 col-form-label form-label">KPI Measure</label>

                                       <div class="col-sm-9">
                                           <!-- Select -->
                                           <input type="text" class="form-control" name="question[]" id="question" title="Enter KPI">
                                           <!-- End Select -->
                                       </div>
                                   </div>
                                   <!-- End Form -->
                                   <!-- End Form -->



                                   <!-- Form -->
                                   <div class="row mb-4">
                                       <label for="locationLabel" class="col-sm-3 col-form-label form-label">Weight %</label>

                                       <div class="col-sm-9">
                                           <!-- Select -->
                                           <input type="text" class="form-control weight" name="weight[]" title="Enter KPI" placeholder="Weight" id="weight %">
                                           <!-- End Select -->
                                       </div>
                                   </div>
                                   <!-- End Form -->

                                   <!-- Form -->
                                   <div class="row mb-4">
                                       <label for="locationLabel" class="col-sm-3 col-form-label form-label">Target</label>

                                       <!-- clients logo  -->
                                       <div class="col-sm-9">
                                           <input type="text" class="form-control score" name="score[]" id="score" placeholder="Target">
                                       </div>
                                       <!-- / clients logo  -->
                                   </div>
                                   <!-- End Form -->
                               </div>
                               <!-- End Body -->
                           </div>
                       </div>

                       <p class="m-5"><a id="addmore<?php echo $x; ?>">[+]Add more objectives</a> </p>
                   </div>
               <?php }
                ?>