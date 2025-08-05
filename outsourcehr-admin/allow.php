<div class="allow">
    <h5 class="modal-title mt-2 mb-3" id="newProjectModalLabel">Staff Allowance</h5>
    <div class="mb-4">

        <?php
        $email = $row['email'];
        $deduct = mysqli_query($db, "select * from payroll where pay_token = '$pay_token' AND email = '$email'");
        $rows = mysqli_fetch_array($deduct);
        ?>
        <div class="row align-items-center">
            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Monthly Gross </label>
                <div class="input-group input-group-merge">

                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="name" value="<?= number_format($rows['gross'], 2) ?>" aria-label="" readonly>
                </div>
            </div>
            <!-- End Col -->
            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Annual Salary </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_id" value="<?= number_format(($rows['gross'] * 12),2) ?>" aria-label="" readonly>
                </div>
            </div>
            <div class="col-12 col-md-12 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Basic </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_id" value="<?= number_format($rows['basic'], 2) ?>" aria-label="" readonly>
                </div>
            </div>
            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Annual Gross</label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="name" value="<?= number_format($rows['gross_income'], 2) ?>" aria-label="" readonly>
                </div>
            </div> -->
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Form -->

    <!-- Form -->
    <div class="mb-4">

        <div class="row align-items-center">
            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Annual Gross</label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="position" value="<?= number_format($rows['annual_gross_income'], 2) ?>" aria-label="" readonly>
                </div>
            </div> -->
            <!-- End Col -->

            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Basic </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_id" value="<?= number_format($rows['basic'], 2) ?>" aria-label="" readonly>
                </div>
            </div> -->
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Form -->

    <!-- Form -->
    <div class="mb-4">

        <div class="row align-items-center">
            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Housing</label>
                <div class="input-group input-group-merge">
                    <input type="email" class="form-control" id="clientNewProjectLabel" placeholder="" name="email" value="<?= number_format($rows['housing'], 2) ?>" aria-label="" readonly>
                </div>
            </div>
            <!-- End Col -->

            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Transport</label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="gross" value="<?= number_format($rows['transport'], 2) ?>" aria-label="" readonly>
                </div>
            </div>

            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Form -->

    <!-- Form -->
    <div class="mb-4">

        <div class="row align-items-center">
            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Utility </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_vol" value="<?= number_format($rows['utility'], 2) ?>" aria-label="" readonly>
                </div>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Leave Allowance </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_stat" value="<?= number_format($rows['leave_allo'], 2) ?>" aria-label="" readonly>
                </div>
            </div>
            <!-- End Col -->

            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Form -->

    <!-- Form -->
    <div class="mb-4">

        <div class="row align-items-center">
            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">13<sup>th</sup> Month </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="loan" value="<?= number_format($rows['13th_month'], 2) ?>" aria-label="" readonly>
                </div>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Entertainment </label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="allowance" value="<?= number_format($rows['meals'], 2) ?>" aria-label="" readonly>
                </div>
            </div>
            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Consolidated Relief </label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="allowance" value="<?= number_format($rows['consolidated_relief'], 2) ?>" aria-label="" readonly>
                </div>
            </div> -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Form -->
</div>