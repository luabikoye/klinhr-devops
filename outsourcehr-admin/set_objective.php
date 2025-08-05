<?php if ($success) echo '<div class="alert alert-success">' . $success . '</div>'; ?>
                    <?php if ($error) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>

<?php for($i=1; $i<=20; $i++)
{
    ?>
<div id="obj<?php echo $i; ?>" class="objectives">
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

<p class="m-5"><a id="addmore<?php echo $i; ?>">[+]Add more objectives</a> </p>
</div>
<?php }
?>
    