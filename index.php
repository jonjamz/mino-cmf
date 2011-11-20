<?php 
      
      
      /*
      
          MINO FRAMEWORK
          
            v1.0
      
      */
      
      
      header('Content-Type:text/html; charset=UTF-8');
      session_start(); 
      
      
      // Basic router pre-processing
      
      if(empty($_GET['url'])) {
        
        if(isset($_SESSION['id'])) {
      
          $view = 'dashboard';
      
        } else {
      
          $view = 'landing';
          
         }
      
      } else {
        
        if(preg_match('/~/', $_GET['url']) != 0) {
        
          $url = explode('~', $_GET['url']);
          $view = $url[0];
          
          if($view == 'activate') { 
       
            $urlArg = substr($url[1],5);
            
          } elseif($view == 'change-pass') {
          
            $urlArg = substr($url[1],5);
          
          } 
          
        } else {
       
          $view = $_GET['url'];
          
          if($view == 'logout') {
            
            $view = 'landing';
            $showLogOut = 'yes';
            
          }
      
        }
        
      }

?>

<!DOCTYPE HTML>

<html>
<head>

<title>Charitable - Charity, Simplifed.</title>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="description" content="Charity, Simplified.">
<meta name="author" content="Dove.io">
<meta name="viewport" content="width=device-width,initial-scale=1">

<?php
			// Generate js sources
			foreach (glob("library/js/dev.autoload/*.js") as $autoload) { echo "<script src=\"$autoload\"></script> \n"; }
?>

<?php if(1==0) { // Get contents of settings.json file and check if mobile redirect is enabled... ?>

<script type="text/javascript" src="library/js/redirection_mobile.min.js"></script>
<script type="text/javascript">SA.redirection_mobile ({param:"isDefault", mobile_prefix : "m", cookie_hours : "1" });
</script>

<?php } ?>

<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="library/images/favicon.png">
<link rel="apple-touch-icon" href="library/images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="library/images/apple-touch-icon-72x72-precomposed.png">
<link rel="apple-touch-icon" sizes="114x114" href="library/images/apple-touch-icon-114x114-precomposed.png">
<link rel="stylesheet" href="library/css/screen.css" media="screen">
<link href="http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic" rel="stylesheet" type="text/css">

</head>


<body>


            <!-- say -->


<div class="container">

<?php 
      // Display logout message
      if(isset($showLogOut) && $showLogOut == 'yes') { 
        echo "<div class=\"onLoadFade\" style=\"position:absolute;width:770px;text-align:center;\">
        You have successfully logged out.
        </div>"; 
      } 
?>


            <!-- hi -->


<div class="header">	

<?php	if(isset($_SESSION['id'])) { // Header when logged in ?>

  <a href="" class="loadView logo" data-view="dashboard"></a>
   
  <nav>
    <a href="" class="loadView" data-view="profile">Profile</a>
    <a href="" class="loadView" data-view="settings">Settings</a>
    <a href="" class="onClick" data-model="login" data-method="logout">Log Out</a>
  </nav>

<?php } elseif(!isset($_SESSION['id'])) { // Header when logged out ?>

<?php } ?>

</div>


            <!-- to -->


<div id="view-load">

  <!-- You can add a loading message or animation here. Keep the noscript, though. -->

  <noscript><em>This site requires javascript. Please enable it and/or upgrade your browser!</em></noscript>

</div>


            <!-- the -->


<div class="footer">
  	
<?php	if(isset($_SESSION['id'])) { // Footer when logged in ?>

  <nav>	
    <a href="" class="loadView" data-view="about">About</a>
    <a href="" class="loadView" data-view="help">Help</a>
    <a href="" class="loadView" data-view="terms">Terms</a>
  </nav>

<?php } elseif(!isset($_SESSION['id'])) { // Footer when logged out ?>

<?php } ?>

</div>

</div>


            <!-- mino -->


<script type="text/javascript">

$(document).ready(function() {


<?php 
      // Controller
      require "controllers/--DEFAULT/controller.js";
?>


});

</script>


            <!-- framework (awesome) created by jon james, github.com/jonjamz -->


</body>
</html>
