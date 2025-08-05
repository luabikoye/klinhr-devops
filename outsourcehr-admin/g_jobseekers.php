<!-- generate job_seekers -->
<div id="job_seekers">
    <form action="generate_job_seekers" method="post" enctype="multipart/form-data">
        <div class="row mb-4">

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Start Time</label>
                    <input type="date" class="form-control" name="job_start_date" id="departmentLabel" placeholder="Deadline" aria-label="Human resources">
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">End Time</label>
                    <input type="date" class="form-control" name="job_end_date" id="departmentLabel" placeholder="Deadline" aria-label="Human resources">
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Client</label>
                    <select class=" form-select" id="" name="job_client">
                        <<option value="">Select Client</option>
                            <option value="">All Client</option>
                            <?php list_val_distinct('jobs_applied', 'client_name'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">State</label>
                    <select class=" form-select" id="" name="job_state">
                        <option value="">Select State</option>

                        <?php list_val_distinct('jobs_applied', 'state'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>


            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Local Government</label>
                    <select class=" form-select" id="" name="job_local_govt">
                        <option value="">Select Local Govt</option>
                        <?php list_val_distinct('jobs_applied', 'local_govt'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Job Title</label>
                    <select class=" form-select" id="" name="job_job_title">
                        <option value="">Select Job Title</option>
                        <?php list_val_distinct('jobs_applied', 'job_title'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Qualification</label>
                    <select class=" form-select" id="" name="job_qualification">
                        <option value="">Select Qualification</option>
                        <?php list_val_distinct('jobs_applied', 'qualification'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Job Type</label>
                    <select class=" form-select" id="" name="job_job_type">
                        <option value="">Select Job Type</option>
                        <?php list_val_distinct('jobs_applied', 'job_type'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-12">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Application Stage</label>
                    <select class=" form-select" id="" name="job_status">
                        <option value="">Select Job Type</option>
                        <?php list_val_distinct('jobs_applied', 'status'); ?>
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