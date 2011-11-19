<?php
  
  session_start();
  
  /*      
  
      View Router
      
        This is where you control the security and naming of views  
        
        Don't put the same view in more than one array!
 
  */
  
  
  // Universally accessible
  
  $uViews = array(

    "about"       => "views/--DEFAULT/footer/about.php",
    "help"        => "views/--DEFAULT/footer/help.php",
    "terms"       => "views/--DEFAULT/footer/terms.php",
    "contact"     => "views/--DEFAULT/footer/contact.php"
    
  );
  
  
  // Only when logged out
  
  $oViews = array(

    "activate"    => "views/--DEFAULT/activate.php",
    "change-pass" => "views/--DEFAULT/forgot.php",
    "landing"     => "views/--DEFAULT/landing.php",
    "login"       => "views/--DEFAULT/login.php"
  
  );
  
  
  // Only when logged in
  
  $iViews = array(

    "dashboard"   => "views/--DEFAULT/dashboard.php",
    "settings"    => "views/--DEFAULT/settings.php",
    
    "businesses"  => "views/businesses.php",
    "campaigns"   => "views/campaigns.php",
    "events"      => "views/events.php",
    "history"     => "views/history.php",
    "messages"    => "views/messages.php",
    "nonprofits"  => "views/nonprofits.php",
    "people"      => "views/people.php",
    "perks"       => "views/perks.php",
    "profile"     => "views/profile.php",
    "projects"    => "views/projects.php",
    "teams"       => "views/teams.php"
  
  );
  

  if(isset($_GET['view'])) {
    
    $view = $_GET['view'];
    
    if(isset($uViews[$view])) {
    
      echo $uViews[$view];
    
    } elseif(isset($oViews[$view])) {
    
      if(isset($_SESSION['id'])) {
      
        echo $iViews['dashboard'];
      
      } else {
      
        echo $oViews[$view];
      
      }
    
    } elseif(isset($iViews[$view])) {
    
      if(isset($_SESSION['id'])) {
      
        echo $iViews[$view];
      
      } else {
      
        echo $oViews['login'];
      
      }
    
    } else { 
    
      if(isset($_SESSION['id'])) {
      
        echo $iViews['dashboard'];
      
      } else {
      
        echo $oViews['landing'];
      
      }
    
    }

  }

?>
