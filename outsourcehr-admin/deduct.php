<div class="deduct">
    <h5 class="modal-title mt-2 mb-3" id="newProjectModalLabel">Staff Deduction</h5>
    <div class="mb-4">

        <?php
        $email = $row['email'];        
        $deduct = mysqli_query($db, "select * from payroll where pay_token = '$pay_token' AND email = '$email'");
        $rows = mysqli_fetch_array($deduct);
        ?>
        <div class="row align-items-center">
            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Employee Pension </label>
                <div class="input-group input-group-merge">

                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="name" value="<?= number_format($rows['pension'],2) ?>" aria-label="" readonly>
                </div>
            </div> -->
            <!-- End Col -->
            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Annual Pension</label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="name" value="<?= number_format($rows['annual_pension'],2) ?>" aria-label="" readonly>
                </div>
            </div> -->
            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Employer Pension </label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="allowance" value="<?= number_format($rows['employer_pension'],2) ?>" aria-label="" readonly>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">NHF </label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="allowance" value="<?= number_format($rows['monthly_nhf'],2) ?>" aria-label="" readonly>
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
            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Annual NHF</label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="position" value="<?= number_format($rows['annual_nhf'],2) ?>" aria-label="" readonly>
                </div>
            </div> -->
            <!-- End Col -->

            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Total Relief </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_id" value="<?= number_format($rows['total_relief'],2) ?>" aria-label="" readonly>
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
                <label for="clientNewProjectLabel" class="form-label">Taxable Income</label>
                <div class="input-group input-group-merge">
                    <input type="email" class="form-control" id="clientNewProjectLabel" placeholder="" name="email" value="<?= number_format($rows['taxable'],2) ?>" aria-label="" readonly>
                </div>
            </div> -->
            <!-- End Col -->

            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Annual Tax</label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="gross" value="<?= number_format($rows['annual_tax'],2) ?>" aria-label="" readonly>
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
                <label for="clientNewProjectLabel" class="form-label">Paye </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_vol" value="<?= number_format($rows['total_paye'],2) ?>" aria-label="" readonly>
                </div>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Total Salary Deduction </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_stat" value="<?= number_format($rows['total_deduction'],2) ?>" aria-label="" readonly>
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
                <label for="clientNewProjectLabel" class="form-label">NSITF </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="loan" value="<?= number_format($rows['nsitf'],2) ?>" aria-label="" readonly>
                </div>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">ITF </label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="allowance" value="<?= number_format($rows['itf'],2) ?>" aria-label="" readonly>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Form -->
</div>