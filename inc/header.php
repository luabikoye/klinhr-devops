<nav class="navbar navbar-expand-md sticky-top navbar-light" id="navbar">
  <div class="container">
    <a class="navbar-brand" href="./"><img src="<?php echo FILE_DIR; ?>JOB/<?= client_detail('client_logo') ?>" style="width: 150px;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <!-- <li class="nav-item left-nav">
        <a class="nav-link" href="./">Home</a>
      </li> -->
        <!-- <li class="nav-item">
        <a class="nav-link" href="latest-jobs">Latest Job</a>
      </li> -->
        <!-- <li class="nav-item">
        <a class="nav-link" href="contact">Contact Us</a>
      </li> -->
        <?php if (!$_SESSION['Klin_user']) {
        ?>
          <li class="nav-item right-nav">
            <a class="nav-link" href="create-account"><button class="primary-btn">Sign Up</button></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login"><button class="sec-btn">Login</button></a>
          </li>
        <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link" href="dashboard"><button class="sec-btn">My Dashboard</button></a>
          </li>

        <?php } ?>
      </ul>
    </div>
  </div>
</nav>

<script>
  $(document).ready(function() {
    $(window).scroll(function() {
      var scroll = $(window).scrollTop();
      if (scroll > 300) {
        $(".navbar").css("background", "#FFF");
      } else {
        $(".navbar").css("background", "transparent");
      }
    })
  })
</script>

<script>
  $(document).ready(function() {
    $(window).scroll(function() {
      var scroll = $(window).scrollTop();
      if (scroll > 300) {
        $(".primary-btn").css("background", "#006BFF");
      } else {
        $(".primary-btn").css("background", "transparent");
      }
    })
  })
</script>