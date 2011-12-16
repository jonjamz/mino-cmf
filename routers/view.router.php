<?php
  
  session_start();
  
  /*      
  
      View Router
      
        This is where you control the security and naming of views  
        
        Don't put the same view in more than one array!
 
  */
  
  // Doesn't require __DIR__ because the locations go to js for referencing
  
  $viewDir = "client/views/";
  
  
  // Universally accessible
  
  $uViews = array(

    "about"       => "--DEFAULT/footer/about.php",
    "help"        => "--DEFAULT/footer/help.php",
    "terms"       => "--DEFAULT/footer/terms.php",
    "contact"     => "--DEFAULT/footer/contact.php"
    
  );
  
  
  // Only when logged out
  
  $oViews = array(

    "activate"    => "--DEFAULT/activate.php",
    "change-pass" => "--DEFAULT/forgot.php",
    "landing"     => "--DEFAULT/landing.php",
    "login"       => "--DEFAULT/login.php"
  
  );
  
  
  // Only when logged in
  
  $iViews = array(

    "dashboard"   => "--DEFAULT/dashboard.php",
    "settings"    => "--DEFAULT/settings.php",
    "profile"     => "--DEFAULT/profile.php",
    
    "nonprofits"  => "nonprofits.php"
  
  );
  

  if(isset($_GET['view'])) {
    
    $view = $_GET['view'];
    
    if(isset($uViews[$view])) {
    
      echo $viewDir.$uViews[$view];
    
    } elseif(isset($oViews[$view])) {
    
      if(isset($_SESSION['id'])) {
      
        echo $viewDir.$iViews['dashboard'];
      
      } else {
      
        echo $viewDir.$oViews[$view];
      
      }
    
    } elseif(isset($iViews[$view])) {
    
      if(isset($_SESSION['id'])) {
      
        echo $viewDir.$iViews[$view];
      
      } else {
      
        echo $viewDir.$oViews['login'];
      
      }
    
    } else { 
      
      /*
          Here you can do a fallback where if the page doesn't exist, check if there's a matching username
          and load in the person's profile. Or a 404!
      */
      
      if(isset($_SESSION['id'])) {
      
        echo $viewDir.$iViews['dashboard'];
      
      } else {
      
        echo $viewDir.$oViews['landing'];
      
      }
    
    }

  }

?>
