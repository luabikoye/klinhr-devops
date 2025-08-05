<!-- generate resignation -->
<div id="resignation">
    <form action="generate_resignation" method="post" enctype="multipart/form-data">
        <div class="row mb-4">

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Start Time</label>
                    <input type="date" class="form-control" name="resignation_start_date" id="departmentLabel" placeholder="Deadline" aria-label="Human resources">
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">End Time</label>
                    <input type="date" class="form-control" name="resignation_end_date" id="departmentLabel" placeholder="Deadline" aria-label="Human resources">
                </div>
                <!-- End Select -->
            </div>
        </div>

        <div class="row mb-4" id="">

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Resignation Date</label>
                    <input type="date" class="form-control" name="resignation_date" id="departmentLabel" placeholder="Deadline" aria-label="Human resources">
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Job Role</label>
                    <select class=" form-select" id="" name="resignation_job_role">
                        <option value="">Select Refefence</option>
                        <?php list_val_distinct('emp_resignation', 'job_role'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>
        </div>

        <div class="row mb-4" id="">

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Client</label>
                    <select class=" form-select" id="" name="resignation_client">
                        <option value="">Select </option>
                        <?php list_val_distinct('emp_resignation', 'access_type'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Status</label>
                    <select class=" form-select" id="" name="resignation_status">
                        <option value="">Select </option>
                        <option value="done">Done </option>
                        <option value="pending">Pending </option>
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