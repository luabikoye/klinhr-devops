<nav class="navbar navbar-expand-md sticky-top navbar-light" id="navbar" style="background: #FFF;">
    <div class="container">
        <a class="navbar-brand" href="./"><img src="./dist/images/logo.png" style="width: 150px;" class="img-fluid"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                    <a class="nav-link" href="create-account"><button class="primary-btn" style="
        background-color: transparent;
    border: 2px solid #006BFF;
    border-radius: 19px;
    outline: none;
    color: #006BFF;
    padding: 4px 20px;">Sign Up</button></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login"><button class="sec-btn" style="background-color: #006BFF;
    color: #FFF;
    border: none;
    outline: none;
    border-radius: 19px;
    font-size: 16px;
    padding: 5px 20px">Login</button></a>
                </li>
                <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard"><button class="sec-btn" id="reqdem" style="background-color: #006BFF;
    color: #FFF;
    border: none;
    outline: none;
    border-radius: 19px;
    font-size: 16px;
    padding: 5px 20px;
    margin-left: 20px;">My Dashboard</button></a>
                </li>

                <?php } ?>
            </ul>
        </div>
    </div>
</nav>