<!-- generate reference -->
<div id="reference">
        <form action="generate_reference" method="post" enctype="multipart/form-data">
        <div class="row mb-4">

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Start Time</label>
                    <input type="date" class="form-control"  name="reference_start_date" id="departmentLabel" placeholder="Deadline" aria-label="Human resources">
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">End Time</label>
                    <input type="date" class="form-control"  name="reference_end_date" id="departmentLabel" placeholder="Deadline" aria-label="Human resources">
                </div>
                <!-- End Select -->
            </div>
        </div>

        <div class="row mb-4" id="">

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Refefence Type</label>
                    <select class=" form-select"  id="" name="reference_type">
                        <option value="">Select Refefence</option>
                        <?php list_val_distinct('emp_reference', 'ref_type'); ?>
                    </select>
                </div>
                <!-- End Select -->
            </div>

            <div class="col-md-6">
                <!-- Select -->
                <div class="tom-select-custom mb-4">
                    <label for="locationLabel" class="col-sm-6 col-form-label form-label">Client</label>
                    <select class=" form-select"  id="" name="reference_client">
                        <option value="">Select </option>
                        <?php list_val_distinct('emp_reference', 'access_type'); ?>
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
                    <select class=" form-select"  id="" name="reference_status">
                        <option value="">Select </option>
                        <option value="done">Done </option>
                        <option value="pending">Pending </option>
                    </select>
                </div>
                <!-- End Select -->
            </div>
        </div>
    </form>
</div>