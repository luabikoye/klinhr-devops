<!-- generate vacancies -->
<div id="vacancies">
<form action="generate_vacancies" method="post" enctype="">
        <div class="row mb-4">

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Start Time</label>
                    <input type="date" class="form-control" name="vacancy_start_date" id="departmentLabel" placeholder="Deadline" aria-label="Human resources">
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">End Time</label>
                    <input type="date" class="form-control" name="vacancy_end_date" id="departmentLabel" placeholder="Deadline" aria-label="Human resources">
                </div>
                <!-- End Select -->
            </div>
        </div>

        <div class="row mb-4" id="">

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Category</label>
                    <select class=" form-select" id="" name="vacancy_category">
                        <option value="">Select Category</option>
                        <?php list_val_distinct('job_post', 'category'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>


            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Qualification</label>
                    <select class=" form-select" id="" name="vacancy_qualification">
                        <option value="">Select Qualification</option>

                        <?php list_val_distinct('job_post', 'qualification'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>
        </div>

        <div class="row mb-4" id="">

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Experience</label>
                    <select class=" form-select" id="" name="vacancy_experience">
                        <option value="">Select Experience</option>
                        <?php list_val_distinct('job_post', 'experience'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">State</label>
                    <select class=" form-select" id="" name="vacancy_state">
                        <option value="">Select State</option>
                        <?php list_val_distinct('job_post', 'state'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>
        </div>
        <div class="row mb-4" id="">

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Job Type</label>
                    <select class=" form-select" id="" name="vacancy_job_type">
                        <option value="">Select Job Type</option>
                        <?php list_val_distinct('job_post', 'job_type'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Client</label>
                    <select class=" form-select" id="" name="vacancy_client">
                        <option value="">Select Client</option>
                        <option value="">All Client</option>
                        <?php list_job_client(); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>
        </div>
        <div class="row mb-4" id="">
            <label for="locationLabel" class="col-sm-3 col-form-label form-label">Status</label>

            <div class="col-md-12">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <select class=" form-select" id="" name="vacancy_status">
                        <option value="">Select Status</option>
                        <?php list_val_distinct('job_post', 'status'); ?>
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