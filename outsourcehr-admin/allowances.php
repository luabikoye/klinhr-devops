    <?php    
        
    $sel2 = "select * from allowance_name where band_name = '$band_id'";    
    $sel_qs =  mysqli_query($db, $sels);
    if ($sel_qs) {
        $sel_nums = 0;
    } else {
        $sel_nums = $mysqli->num_rows($sel_qs);
    }
    for ($i = 0; $i < 10; $i++) {
        $sel_r = mysqli_fetch_assoc($sel_qs);
        $y = $i + 1;
    ?>
        <div class="names<?= $i + 1 ?> col-md-12">

            <div class="row">
                <div class="tom-select-custom mb-4 col-md-6">
                    <label for="locationLabel" class="form-label form-label">Allowance Name <?= $i + 1 ?></label>
                    <input type="text" name="allowed[]" class="form-control mb-3" id="inputedNames<?= $i + 1 ?>" value="<?= $sel_r2['allowance_name']; ?>">
                    <button type="button" class="btn btn-primary" id="adds<?= $i + 1 ?>"><i class=" bi-plus"></i></button>
                    <button type="button" class="btn btn-danger" id="removes<?= $i + 1 ?>"><i class=" bi-x"></i></button>
                </div>
                <div class="col-md-6">
                    <label for="locationLabel" class="form-label form-label">Allowance (%)</label>
                    <input type="text" name="allow[]" class="form-control" id="inputNames<?= $i + 1 ?>" value="<?php if ($allow) {
                                                                                                                    echo $allow;
                                                                                                                } else {
                                                                                                                    echo $rss["allowance$y"];
                                                                                                                } ?>">
                </div>

            </div>
        </div>
    <?php } ?>