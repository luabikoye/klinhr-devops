<?php 
$query = "select * from activity_log where date >= ".check_date(today())."  order by id desc limit 0, 10";
$result = mysqli_query($db, $query);
$num = mysqli_num_rows($result);
?>
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasActivityStream" aria-labelledby="offcanvasActivityStreamLabel">
    <div class="offcanvas-header">
      <h4 id="offcanvasActivityStreamLabel" class="mb-0">Activity stream</h4>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <!-- Step -->
      <ul class="step step-icon-sm step-avatar-sm">
        <!-- Step Item -->
        <?php for ($i=0; $i < $num; $i++) { 
          $row = mysqli_fetch_array($result);
                  ?>
        <li class="step-item">
          <div class="step-content-wrapper">
            <div class="step-avatar">
              <img class="step-avatar" src="./assets/img/160x160/img1.jpg" alt="Image Description">
            </div>

            <div class="step-content">
              <h5 class="mb-1"><?= $row['fullname']?></h5>

              <p class="fs-5 mb-1"><?= $row['action_taken'] ?></p>              

              <span class="small text-muted text-uppercase">Now</span>
            </div>
          </div>
        </li>
        <?php }?>
        <!-- End Step Item -->
      </ul>
      <!-- End Step -->

      <div class="d-grid">
        <a class="btn btn-white" href="javascript:;">View all <i class="bi-chevron-right"></i></a>
      </div>
    </div>
  </div>