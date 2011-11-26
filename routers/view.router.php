<?php
  
  session_start();
  
  /*      
  
      View Router
      
        This is where you control the security and naming of views  
        
        Don't put the same view in more than one array!
 
  */
  
  
  // Universally accessible
  
  $uViews = array(

    "about"       => "client/views/--DEFAULT/footer/about.php",
    "help"        => "client/views/--DEFAULT/footer/help.php",
    "terms"       => "client/views/--DEFAULT/footer/terms.php",
    "contact"     => "client/views/--DEFAULT/footer/contact.php"
    
  );
  
  
  // Only when logged out
  
  $oViews = array(

    "activate"    => "client/views/--DEFAULT/activate.php",
    "change-pass" => "client/views/--DEFAULT/forgot.php",
    "landing"     => "client/views/--DEFAULT/landing.php",
    "login"       => "client/views/--DEFAULT/login.php"
  
  );
  
  
  // Only when logged in
  
  $iViews = array(

    "dashboard"   => "client/views/--DEFAULT/dashboard.php",
    "settings"    => "client/views/--DEFAULT/settings.php",
    "profile"     => "client/views/--DEFAULT/profile.php",
    
    "nonprofits"  => "client/views/nonprofits.php"
  
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
      
      /*
          Here you can do a fallback where if the page doesn't exist, check if there's a matching username
          and load in the person's profile
      */
      
      if(isset($_SESSION['id'])) {
      
        echo $iViews['dashboard'];
      
      } else {
      
        echo $oViews['landing'];
      
      }
    
    }

  }

?>
