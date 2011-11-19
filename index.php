<?php 
      
      header('Content-Type:text/html; charset=UTF-8');
      session_start(); 

      if(empty($_GET['url'])) {
        
        if(isset($_SESSION['id'])) {
      
          $view = 'dashboard';
      
        } else {
      
          $view = 'landing';
          
         }
      
      } else {
      
        $url = explode('/', $_GET['url']);
        $view = $url[0];
        
        if($view == 'activate') { 
          
          // Trim -->code=
          $activateCode  = substr($url[1],8);
          
        } elseif($view == 'logout') {
          
          $view = 'landing';
          $showLogOut = 'yes';
          
        } elseif($view == 'change-pass') {
        
          // Trim -->code=
          $passCode = substr($url[1],8);
        
        } 
        
      }

?>

<!DOCTYPE HTML>

<html>
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="description" content="Charity, Simplified.">
<meta name="author" content="Dove.io">
<meta name="viewport" content="width=device-width,initial-scale=1">

<?php
			// Generate js sources
			foreach (glob("library/js/dev.autoload/*.js") as $autoload) { echo "<script src=\"$autoload\"></script> \n"; }
?>

<title>Charitable - Charity, Simplifed.</title>

<script type="text/javascript">


</script>

<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="library/images/favicon.png">
<link rel="apple-touch-icon" href="library/images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="library/images/apple-touch-icon-72x72-precomposed.png">
<link rel="apple-touch-icon" sizes="114x114" href="library/images/apple-touch-icon-114x114-precomposed.png">
<link rel="stylesheet" href="library/css/screen.css" media="screen">
<link href="http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic" rel="stylesheet" type="text/css">

</head>

<body>

<?php //echo $view; ?>

<div class="container">

<?php if(isset($showLogOut) && $showLogOut == 'yes') { echo "<div class=\"onLoadFade\" style=\"position:absolute;width:770px;text-align:center;\">You have successfully logged out.</div>"; } ?>

<?php	if(!empty($_SESSION['id'])) { // Header shows only when logged in ?>

<div class="header">	
	<a href="" class="loadView logo" data-view="dashboard"></a>
	<nav>
		<a href="" class="loadView" data-view="profile">Profile</a>
		<a href="" class="loadView" data-view="settings">Settings</a>
		<a href="" class="onClick" data-model="login" data-method="logout">Log Out</a>
	</nav>
</div>

<?php } ?>


<div id="view-load">

<!-- You can add a loading message or animation here. Keep the noscript, though. -->

<noscript><em>This site requires javascript. Please enable it and/or upgrade your browser!</em></noscript>

</div>


<?php	if(!empty($_SESSION['id'])) { // Footer shows only when logged in ?>

<div class="footer">
  <nav>			
		<a href="" class="loadView" data-view="about">About</a>
		<a href="" class="loadView" data-view="help">Help</a>
		<a href="" class="loadView" data-view="terms">Terms</a>
  </nav>
</div>

<?php } ?>

</div>


<script type="text/javascript">

$(document).ready(function() {

<?php 
      // Default Controller
      require "controllers/--DEFAULT/controller.js";
?>

});

</script>


</body>
</html>
