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


    // Default
    
    "about"       => "--DEFAULT/about.php",
    "help"        => "--DEFAULT/help.php",
    "terms"       => "--DEFAULT/terms.php",
    "contact"     => "--DEFAULT/contact.php"
    
    
    // Project
    
  );
  
  
  // Only when logged out
  
  $oViews = array(


    // Default
    
    "landing"     => "--DEFAULT/landing.php",
    "activate"    => "--DEFAULT/authorization/activate.php",
    "change-pass" => "--DEFAULT/authorization/forgot.php",    
    "login"       => "--DEFAULT/authorization/login.php",
    "register"    => "--DEFAULT/authorization/register.php"
    
    
    // Project
    
  );
  
  
  // Only when logged in
  
  $iViews = array(


    // Default
    
    "dashboard"   => "--DEFAULT/user/dashboard.php",
    "settings"    => "--DEFAULT/user/settings.php",
    "profile"     => "--DEFAULT/user/profile.php",
    
    
    // Project
    
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
      
        echo '!logout';
      
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
