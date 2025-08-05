<!-- generate appraisal -->
<div id="appraisal">
    <form action="generate_appraisal" method="post" enctype="multipart/form-data">
        <div class="row mb-4">

            <div class="col-md-6">
                <!-- Select -->
                <label for="locationLabel" class="col-sm-6 col-form-label form-label">Date Appraised</label>
                <div class="tom-select-custom mb-4">
                    <input type="date" class="form-control" name="appraisal_start_date" id="departmentLabel" placeholder="Deadline" aria-label="Human resources">
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <label for="locationLabel" class="col-sm-6 col-form-label form-label">Due Date</label>
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <input type="date" class="form-control" name="appraisal_end_date" id="departmentLabel" placeholder="Deadline" aria-label="Human resources">
                </div>
                <!-- End Select -->
            </div>
        </div>

        <div class="row mb-4" id="">

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Job Role</label>
                    <select class=" form-select" id="" name="appraisal_job_role">
                        <option value="">Select Role</option>
                        <?php list_val_distinct('appraisal', 'job_role'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>


            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Client</label>
                    <select class=" form-select" id="" name="appraisal_client">
                        <option value="">Select </option>
                        <?php list_val_distinct('appraisal', 'client'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>
        </div>
        <div class="row mb-4" id="">

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Appraisal Role</label>
                    <select class=" form-select" id="" name="appraisal_role">
                        <option value="">Select </option>
                        <?php list_val_distinct('appraisal', 'appraisal_role'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Status</label>
                    <select class=" form-select" id="" name="appraisal_status">
                        <option value="">Select </option>
                        <?php list_val_distinct('appraisal', 'status'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end align-items-center">
            <input type="submit" class="btn btn-primary" value="Generate Report" class="btn-sm btn btn-primary" onclick="return confirm('Click OK to generate this report'); ">

        </div>
    </form>
</div>