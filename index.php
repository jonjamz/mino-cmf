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

<title>Mino Framework</title>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="description" content="Mino Framework, Model-View-Strong-Router">
<meta name="author" content="Dove.io">
<meta name="viewport" content="width=device-width,initial-scale=1">

<script src="compilers/js-compiler.php"></script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.3/jquery-ui.min.js"></script>

<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="client/library/images/favicon.png">
<link rel="apple-touch-icon" href="client/library/images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="client/library/images/apple-touch-icon-72x72-precomposed.png">
<link rel="apple-touch-icon" sizes="114x114" href="client/library/images/apple-touch-icon-114x114-precomposed.png">

<link rel="stylesheet" href="compilers/css-compiler.php">

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


<?php	if(isset($_SESSION['id'])) { // Header when logged in ?>

<div class="header">	

  <a href="" class="loadView logo" data-view="dashboard"></a>
   
  <nav>
    <a href="" class="loadView" data-view="profile">Profile</a>
    <a href="" class="loadView" data-view="settings">Settings</a>
    <a href="" class="onClick" data-model="login" data-method="logout">Log Out</a>
  </nav>

</div>

<?php } elseif(!isset($_SESSION['id'])) { // Header when logged out ?>

<?php } ?>


            <!-- to -->


<div id="view-load">

  <!-- You can add a loading message or animation here. Keep the noscript, though. -->

  <noscript><em>This site requires javascript. Please enable it and/or upgrade your browser!</em></noscript>

</div>


            <!-- the -->

  	
<?php	if(isset($_SESSION['id'])) { // Footer when logged in ?>

<div class="footer">

  <nav>	
    <a href="" class="loadView" data-view="about">About</a>
    <a href="" class="loadView" data-view="help">Help</a>
    <a href="" class="loadView" data-view="terms">Terms</a>
  </nav>

</div>

<?php } elseif(!isset($_SESSION['id'])) { // Footer when logged out ?>

<?php } ?>


</div>


            <!-- mino -->


<script type="text/javascript">

$(document).ready(function() {


<?php 
      // Controller
      require "controller.js";
?>


});

</script>


            <!-- framework, created by jon james (github.com/jonjamz) -->


</body>
</html>
