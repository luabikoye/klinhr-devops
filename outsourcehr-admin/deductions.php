 <?php

 $sels = "select * from deduct_name where band_name = '$band_id'";
    $sel_qs =  mysqli_query($db, $sels);
    if ($sel_qs) {
        $sel_nums = 0;
    }
    else {
        $sel_nums = $mysqli->num_rows($sel_qs);
    }
    for ($i = 0; $i < 10; $i++) {
        $sel_r = mysqli_fetch_assoc($sel_qs);
        $y = $i + 1;
    ?>
     <div class="name<?= $y ?> col-md-12">
         <div class="row ">

             <div class="tom-select-custom mb-4 col-md-6">
                 <label for="locationLabel" class="form-label form-label">Deduction Name <?= $y ?></label>
                 <input type="text" name="deducted[]" class="form-control mb-3" id="inputedName<?= $y ?>" value="<?= $sel_r['deduct_name']; ?>">
                 <button type="button" class="btn btn-primary" id="add<?= $y ?>"><i class=" bi-plus"></i></button>
                 <button type="button" class="btn btn-danger" id="remove<?= $i + 1 ?>"><i class=" bi-x"></i></button>
             </div>
             <div class="col-md-6">
                 <label for="locationLabel" class="form-label form-label">Deduction (%) </label>
                 <input type="text" name="deduct[]" class="form-control" id="inputName<?= $i + 1 ?>" value="<?php if ($deduct) {
                                                                                                                echo $deduct;
                                                                                                            } else {
                                                                                                                echo $rss["deduct$y"];
                                                                                                            } ?>">
             </div>
         </div>
        </div>
 <?php } ?>
