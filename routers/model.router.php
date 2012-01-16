<?php
  
  $modelDir = __DIR__."/../server/models/";
  
  $models = array(

    "activate"    => "--DEFAULT/authorization/activate.php",
    "login"       => "--DEFAULT/authorization/login.php",
    "register"    => "--DEFAULT/authorization/register.php",
    "forgot"      => "--DEFAULT/authorization/forgot.php",
    "settings"    => "--DEFAULT/settings.php",
    "dashboard"   => "--DEFAULT/dashboard.php",
    
    "searches"  => "--DEFAULT/searches.php",
  
  );
  
  if(isset($_POST['model'])) {
    
    $model = $_POST['model'];
    $destination = $modelDir.$models[$model];
    require $destination;
  
  }
  
?>
