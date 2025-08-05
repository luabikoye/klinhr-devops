<header id="header" class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-container navbar-bordered bg-white">
  <?php

  $emails = $_SESSION['Klin_admin_user'];

  $sel = "select * from login where username = '$emails'";
  $re = mysqli_query($db, $sel);
  $rows = mysqli_fetch_array($re);
  $fullName = $rows['firstname'] . ' ' . $rows['lastname'];

  ?>
  <div class="navbar-nav-wrap">
    <!-- Logo -->
    <a class="navbar-brand" href="./index" aria-label="Front">
      <img class="navbar-brand-logo" src="./assets/img/logo.png" alt="Logo" data-hs-theme-appearance="default">

    </a>
    <!-- End Logo -->

    <div class="navbar-nav-wrap-content-start">
      <!-- Navbar Vertical Toggle -->
      <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler">
        <i class="bi-arrow-bar-left navbar-toggler-short-align" data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>' data-bs-toggle="tooltip" data-bs-placement="right" title="Collapse"></i>
        <i class="bi-arrow-bar-right navbar-toggler-full-align" data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>' data-bs-toggle="tooltip" data-bs-placement="right" title="Expand"></i>
      </button>

      <!-- End Navbar Vertical Toggle -->

      <!-- Search Form -->
      <div class="dropdown ms-2">
        <!-- Input Group -->
        <div class="d-none d-lg-block">
          <div class="input-group input-group-merge input-group-borderless input-group-hover-light navbar-input-group">
            <div class="input-group-prepend input-group-text">
              <i class="bi-search"></i>
            </div>

            <input type="search" class="js-form-search form-control" placeholder="Search in front" aria-label="Search in front" data-hs-form-search-options='{
                       "clearIcon": "#clearSearchResultsIcon",
                       "dropMenuElement": "#searchDropdownMenu",
                       "dropMenuOffset": 20,
                       "toggleIconOnFocus": true,
                       "activeClass": "focus"
                     }'>
            <a class="input-group-append input-group-text" href="javascript:;">
              <i id="clearSearchResultsIcon" class="bi-x-lg" style="display: none;"></i>
            </a>
          </div>
        </div>

        <button class="js-form-search js-form-search-mobile-toggle btn btn-ghost-secondary btn-icon rounded-circle d-lg-none" type="button" data-hs-form-search-options='{
                       "clearIcon": "#clearSearchResultsIcon",
                       "dropMenuElement": "#searchDropdownMenu",
                       "dropMenuOffset": 20,
                       "toggleIconOnFocus": true,
                       "activeClass": "focus"
                     }'>
          <i class="bi-search"></i>
        </button>
        <!-- End Input Group -->

        <!-- Card Search Content -->
        <div id="searchDropdownMenu" class="hs-form-search-menu-content dropdown-menu dropdown-menu-form-search navbar-dropdown-menu-borderless">
          <div class="card">
            <!-- Body -->
            <div class="card-body-height">
              <div class="d-lg-none">
                <div class="input-group input-group-merge navbar-input-group mb-5">
                  <div class="input-group-prepend input-group-text">
                    <i class="bi-search"></i>
                  </div>

                  <input type="search" class="form-control" placeholder="Search in front" aria-label="Search in front">
                  <a class="input-group-append input-group-text" href="javascript:;">
                    <i class="bi-x-lg"></i>
                  </a>
                </div>
              </div>

              <span class="dropdown-header">Recent searches</span>

              <div class="dropdown-item bg-transparent text-wrap">
                <a class="btn btn-soft-dark btn-xs rounded-pill" href="./index">
                  Gulp <i class="bi-search ms-1"></i>
                </a>
                <a class="btn btn-soft-dark btn-xs rounded-pill" href="./index">
                  Notification panel <i class="bi-search ms-1"></i>
                </a>
              </div>

              <div class="dropdown-divider"></div>

              <span class="dropdown-header">Tutorials</span>

              <a class="dropdown-item" href="./index">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <span class="icon icon-soft-dark icon-xs icon-circle">
                      <i class="bi-sliders"></i>
                    </span>
                  </div>

                  <div class="flex-grow-1 text-truncate ms-2">
                    <span>How to set up Gulp?</span>
                  </div>
                </div>
              </a>

              <a class="dropdown-item" href="./index">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <span class="icon icon-soft-dark icon-xs icon-circle">
                      <i class="bi-paint-bucket"></i>
                    </span>
                  </div>

                  <div class="flex-grow-1 text-truncate ms-2">
                    <span>How to change theme color?</span>
                  </div>
                </div>
              </a>

              <div class="dropdown-divider"></div>

              <span class="dropdown-header">Members</span>

              <a class="dropdown-item" href="./index">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <img class="avatar avatar-xs avatar-circle" src="./assets/img/160x160/img10.jpg" alt="Image Description">
                  </div>
                  <div class="flex-grow-1 text-truncate ms-2">
                    <span>Amanda Harvey <i class="tio-verified text-primary" data-toggle="tooltip" data-placement="top" title="Top endorsed"></i></span>
                  </div>
                </div>
              </a>

              <a class="dropdown-item" href="./index">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <img class="avatar avatar-xs avatar-circle" src="./assets/img/160x160/img3.jpg" alt="Image Description">
                  </div>
                  <div class="flex-grow-1 text-truncate ms-2">
                    <span>David Harrison</span>
                  </div>
                </div>
              </a>

              <a class="dropdown-item" href="./index">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <div class="avatar avatar-xs avatar-soft-info avatar-circle">
                      <span class="avatar-initials">A</span>
                    </div>
                  </div>
                  <div class="flex-grow-1 text-truncate ms-2">
                    <span>Anne Richard</span>
                  </div>
                </div>
              </a>
            </div>
            <!-- End Body -->

            <!-- Footer -->
            <a class="card-footer text-center" href="./index">
              See all results <i class="bi-chevron-right small"></i>
            </a>
            <!-- End Footer -->
          </div>
        </div>
        <!-- End Card Search Content -->

      </div>

      <!-- End Search Form -->
    </div>

    <div class="navbar-nav-wrap-content-end">
      <!-- Navbar -->
      <ul class="navbar-nav">


        <li class="nav-item d-none d-sm-inline-block">
          <!-- Activity -->
          <button class="btn btn-ghost-secondary btn-icon rounded-circle" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasActivityStream" aria-controls="offcanvasActivityStream">
            <i class="bi-x-diamond"></i>
          </button>
          <!-- Activity -->
        </li>

        <li class="nav-item">
          <!-- Account -->
          <div class="dropdown">
            <a class="navbar-dropdown-account-wrapper" href="javascript:;" id="accountNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" data-bs-dropdown-animation>
              <div class="avatar avatar-sm avatar-circle">
                <img class="avatar-img" src="./assets/img/160x160/img1.jpg" alt="Image Description">
                <span class="avatar-status avatar-sm-status avatar-status-success"></span>
              </div>
            </a>

            <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-account" aria-labelledby="accountNavbarDropdown" style="width: 16rem;">
              <div class="dropdown-item-text">
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-sm avatar-circle">
                    <img class="avatar-img" src="./assets/img/160x160/img1.jpg" alt="Image Description">
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h5 class="mb-0"><?= $fullName ?></h5>
                    <p class="card-text text-body"><?= $email ?></p>
                  </div>
                </div>
              </div>

              <div class="dropdown-divider"></div>



              <a class="dropdown-item" href="user">Add User</a>
              <a class="dropdown-item" href="change_password">Change Password</a>
              <a class="dropdown-item" href="logout">Logout</a>
            </div>
          </div>
          <!-- End Account -->
        </li>
      </ul>
      <!-- End Navbar -->
    </div>
  </div>
</header>