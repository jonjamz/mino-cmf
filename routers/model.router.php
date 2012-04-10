<?php

  $modelDir = __DIR__."/../server/models/";

  // Add paths to models here
  $models = array(
    "activate"    => "auth/activate.php",
    "login"       => "auth/login.php",
    "register"    => "auth/register.php",
    "forgot"      => "auth/forgot.php",
    "settings"    => "settings.php",
    "dashboard"   => "dashboard.php",
    "searches"    => "searches.php"
  );

  if(isset($_POST['model'])) {
    $model = $_POST['model'];
    $destination = $modelDir.$models[$model];
    require $destination;
  }

?>
