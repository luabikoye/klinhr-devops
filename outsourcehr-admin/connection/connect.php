  <?php
  // error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING);
  ini_set('display_errors',0);
  // ini_set('display_errors', 0);

  ob_start();

  date_default_timezone_set('Africa/Lagos');
  // date_default_timezone_set('Europe/London');

  //local
  if($_SERVER['HTTP_HOST'] == 'localhost:8062')
  {
        $db = mysqli_connect('db', 'ecardnai_Klinhr', 'Certification231!', 'ecardnai_Klinhr') or die('Cannot connect to database');
  }
  else{
        $db = mysqli_connect('klinhr.cjqkoqw2iogt.us-west-2.rds.amazonaws.com', 'ecardnai_Klinhr', 'Certification231!', 'ecardnai_Klinhr') or die('Cannot connect to database');

  }