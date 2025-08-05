<!-- generate grievances -->
<div id="grievances">
    <form action="generate_grievances" method="post" enctype="multipart/form-data">
        <div class="row mb-4">

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Start Time</label>
                    <input type="date" class="form-control" name="grievances_start_date" id="departmentLabel" placeholder="Deadline" aria-label="Human resources">
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">End Time</label>
                    <input type="date" class="form-control" name="grievances_end_date" id="departmentLabel" placeholder="Deadline" aria-label="Human resources">
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Category</label>
                    <select class=" form-select" id="" name="category">
                        <option value="">Select </option>
                        <?php list_val_distinct('emp_complaint', 'category'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Status</label>
                    <select class=" form-select" id="" name="status">
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