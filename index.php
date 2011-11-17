<?php 
      header('Content-Type:text/html; charset=UTF-8');
      session_start(); 
      
      if(isset($_GET['activate'])) { 
        $pageType      = 'activate';
        $activateCode  = $_GET['activate'];
      }
      elseif(isset($_GET['loggedout']) && $_GET['loggedout'] = 'yes') { $pageType = 'loggedOut'; }
?>

<!DOCTYPE HTML>

<html>
<head>
<script type="text/javascript" src="library/js/redirection_mobile.min.js"></script>
<script type="text/javascript">SA.redirection_mobile ({param:"isDefault", mobile_prefix : "m", cookie_hours : "1" });
</script>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="description" content="Charity, Simplified.">
<meta name="author" content="Dove.io">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta property="fb:page_id" content="173299469418115">

<?php
			// Generate js sources
			foreach (glob("library/js/dev.autoload/*.js") as $autoload) { echo "<script src=\"$autoload\"></script> \n"; }
?>

			<title>Charitable - Charity, Simplifed.</title>

<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="library/images/favicon.png">
<link rel="apple-touch-icon" href="library/images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="library/images/apple-touch-icon-72x72-precomposed.png">
<link rel="apple-touch-icon" sizes="114x114" href="library/images/apple-touch-icon-114x114-precomposed.png">
<link rel="stylesheet" href="library/css/screen.css" media="screen">
<link href="http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic" rel="stylesheet" type="text/css">

</head>

<body>
<div id="fb-root"></div>
<div class="container">

<?php if($pageType == 'loggedOut') { echo "<div class=\"onLoadFade notifications\" style=\"position:absolute;width:770px;text-align:center;\">You have successfully logged out.</div>"; } ?>

<?php	if(!empty($_SESSION['id'])) { // Header shows only when logged in ?>

<div class="header">
					
			<a href="" class="loadView logo" data-view="--DEFAULT/dashboard"></a>
					
			<nav>
						<a href="" class="loadView" data-view="profile">Profile</a>
						<a href="" class="loadView" data-view="--DEFAULT/settings">Settings</a>
						<a href="" class="onClick" data-model="login" data-method="logout">Log Out</a>
						
			</nav>
</div>

<?php } ?>

<div id="view-load">

<?php
			// Logged in? Check page type, or Dashboard becomes your home
			if(isset($pageType) && $pageType == 'activate') { require "views/--DEFAULT/activate.php"; }
			elseif(empty($_SESSION['id'])) { require 'views/--DEFAULT/landing.php'; }
			else { require 'views/--DEFAULT/dashboard.php'; }
?>

</div>

<?php	if(!empty($_SESSION['id'])) { // Footer shows only when logged in ?>

<div class="footer">
		  <nav>
					
						<a href="" class="loadView" data-view="--DEFAULT/footer/about">About</a>
						<a href="" class="loadView" data-view="--DEFAULT/footer/help">Help</a>
						<a href="" class="loadView" data-view="--DEFAULT/footer/terms">Terms</a>
						
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
