<?php 
      header('Content-Type:text/html; charset=UTF-8');
      session_start(); 
      
      // Check if there's a ?dest= in the URL, add to variable 
      if(isset($_GET['activate'])) { 
        $pageType      = 'activate';
        $activateCode  = $_GET['activate'];
      }
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

<?php	if(!empty($_SESSION['id'])) { // Header shows only when logged in ?>
<div class="header">
					
			<a href="index.php" class="logo">Home</a>
					
			<nav>
						<a href="" onclick="return false" data-view="dashboard">Dashboard</a>
						<a href="logout.php">Log Out</a>
						<a href="" onclick="return false" data-view="projects">Projects</a>
			</nav>
</div>
<?php } ?>

<div id="view-load">

<?php
			// Logged in? Check page type, or Dashboard becomes your home
			if(isset($pageType) && pageType = 'activate') { include "views/--DEFAULT/activate.php" }
			elseif(empty($_SESSION['id'])) { include 'views/--DEFAULT/landing.php'; }
			else { include 'views/--DEFAULT/dashboard.php'; }
?>

</div>

<?php	if(!empty($_SESSION['id'])) { // Footer shows only when logged in ?>
<div class="footer">
					<nav>
					
<?php 
			// Generate Nav
			foreach (glob("views/--DEFAULT/footer/*.php") as $nav) { 
																		
						$view = basename($nav, '.php');
						$name = ucfirst($view);
						echo "										<a href=\"\" onclick=\"return false\" data-view=\"$view\">$name</a> \n";
			}
?>
															
					</nav>
</div>
<?php } ?>

<script type="text/javascript">
$(document).ready(function(){
			$('nav a').click(function() {
						var view 			= $(this).attr('data-view');
						var viewDir		= 'views/' + view + '.php';
						var contDir		= 'controllers/' + view + '.php';
							$.get(viewDir, function(data) {
								$('#view-load').html(data);
								//other action could go here
							});
						$('nav a').removeClass('selected');
						$(this).addClass('selected');
			})
});
</script>

</div>
</body>
