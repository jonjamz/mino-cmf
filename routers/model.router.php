<?php

  $models = array(

    "activate"    => __DIR__."/../server/models/--DEFAULT/authorization/activate.php",
    "login"       => __DIR__."/../server/models/--DEFAULT/authorization/login.php",
    "register"    => __DIR__."/../server/models/--DEFAULT/authorization/register.php",
    "forgot"      => __DIR__."/../server/models/--DEFAULT/authorization/forgot.php",
    "settings"    => __DIR__."/../server/models/--DEFAULT/settings.php",
    "dashboard"   => __DIR__."/../server/models/--DEFAULT/dashboard.php",
    
    "nonprofits"  => __DIR__."/../server/models/nonprofits.php",
  
  );
  
  if(isset($_POST['model'])) {
    
    $model = $_POST['model'];
    $destination = $models[$model];
    require $destination;
  
  }
  
?>
