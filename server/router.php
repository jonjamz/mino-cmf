<?php

  $models = array(

    "activate"    => __DIR__."/models/--DEFAULT/activate.php",
    "login"       => __DIR__."/models/--DEFAULT/login.php",
    "register"    => __DIR__."/models/--DEFAULT/register.php",
    "settings"    => __DIR__."/models/--DEFAULT/settings.php",
    "dashboard"   => __DIR__."/models/--DEFAULT/dashboard.php",
    
    "businesses"  => __DIR__."/models/businesses.php",
    "campaigns"   => __DIR__."/models/campaigns.php",
    "events"      => __DIR__."/models/events.php",
    "history"     => __DIR__."/models/history.php",
    "messages"    => __DIR__."/models/messages.php",
    "nonprofits"  => __DIR__."/models/nonprofits.php",
    "people"      => __DIR__."/models/people.php",
    "perks"       => __DIR__."/models/perks.php",
    "profile"     => __DIR__."/models/profile.php",
    "projects"    => __DIR__."/models/projects.php",
    "teams"       => __DIR__."/models/teams.php"
  
  );
  
  if(isset($_POST['model'])) {
    
    $model = $_POST['model'];
    $destination = $models[$model];
    require_once $destination;
  
  }
  
?>
