<!-- generate assessment -->
<div id="assessment">
    <form action="generate_assessment" method="post" enctype="multipart/form-data">
        <div class="row mb-4">

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Start Time</label>
                    <input type="date" class="form-control" name="assessment_start_time" id="departmentLabel" placeholder="Deadline" aria-label="Human resources">
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">End Time</label>
                    <input type="date" class="form-control" name="assessment_end_time" id="departmentLabel" placeholder="Deadline" aria-label="Human resources">
                </div>
                <!-- End Select -->
            </div>
        </div>

        <div class="row mb-4" id="">

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Scores</label>
                    <select class=" form-select" id="" name="assessment_scores">
                        <option value="">Select Scores</option>
                        <?php list_val_distinct('exam_result', 'total_score'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Job Title</label>
                    <select class=" form-select" id="" name="assessment_job_title">
                        <option value="">Select Job Title</option>

                        <?php list_val_distinct('exam_result', 'job_title'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-12">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-3 col-form-label form-label">Status</label>
                    <select class=" form-select" id="" name="assessment_status">
                        <option value="">Select </option>
                        <?php list_val_distinct('exam_result', 'status'); ?>
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