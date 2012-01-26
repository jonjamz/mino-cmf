<?php


      /*

          MINO FRAMEWORK LAMP EDITION

            v1.0

      */


// Check if Mino is installed, and if not, prompt to install.

// Remove this if you have a working install and you know what you're doing. This is really the only inline PHP

require __DIR__.'/server/db/db.class.php';
$m = new db('users',true);
$t = $m->r("*", "type = 'super'");

if($t) {


      header('Content-Type:text/html; charset=UTF-8');
      session_start();

      // Path to Mino root from server root ex. /mino
      $pathToRoot = "/mino";

?>

<!DOCTYPE HTML>

<html>
<head>

<title>Mino Framework LAMP Edition</title>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="description" content="Mino Framework LAMP Edition, Model-View-Strong-Router">
<meta name="author" content="Jonathan James">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php echo $pathToRoot; ?>/client/library/images/favicon.png">
<link rel="apple-touch-icon" href="<?php echo $pathToRoot; ?>/client/library/images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $pathToRoot; ?>/client/library/images/apple-touch-icon-72x72-precomposed.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $pathToRoot; ?>/client/library/images/apple-touch-icon-114x114-precomposed.png">
<link rel="stylesheet" href="<?php echo $pathToRoot; ?>/compilers/css-compiler.php">
<script type="text/javascript">
var url = '<?php
  if(empty($_GET["url"])) { echo "emptyVar"; } else { echo $_GET["url"]; }
?>';
var rootPath = '<?php
  echo $pathToRoot;
?>';
</script>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="<?php echo $pathToRoot; ?>/compilers/js-compiler.php"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.3/jquery-ui.min.js"></script>

</head>

<body>

<div class="container">

<?php	if(isset($_SESSION['id'])) { // Header when logged in ?>

<div class="header">

  <a href="" class="loadView logo" data-view="dashboard">Home</a>

  <nav>
    <a href="" class="loadView" data-view="profile">Profile</a>
    <a href="" class="loadView" data-view="settings">Settings</a>
    <a href="" class="onClick" data-model="login" data-method="logout">Log Out</a>
  </nav>

</div>

<?php } elseif(!isset($_SESSION['id'])) { // Header when logged out ?>

<?php } ?>

<div id="view-load">

  <!-- You can add a loading message or animation here. Keep the noscript, though. -->

  <noscript><em>This site requires javascript. Please enable it and/or upgrade your browser!</em></noscript>

</div>

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

<script type="text/javascript">

$(document).ready(function() {

<?php
      // Controller
      require "controller.js";
      // require "controller.min.js";
?>

});

</script>

</body>
</html>

<?php

// If Mino is not installed, prompt for Db information and install

} else { ?>

<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="install.css">
</head>
<body>
<h1>Install Mino Framework LAMP Edition</h1>
<p>
<em><b>&copy; 2011 Jon James (github.com/jonjamz)</b></em><br><br>
This edition of Mino Framework is dependent upon the following free software:<br><br>

  <span style="color:#ff8844">Linux with Apache 2, PHP 5.3+ w/PEAR Mail, MySQL 5, and YUI compressor installed.</span>
<br><br>
We recommend viewing the <a href="read-first.html">Read-First</a> file for specific instructions on getting a Linux server going from scratch.
<br><br>
<b>Before moving forward, please make sure to assign 777 permissions to the settings folder and compilers/cache folder.</b>
</p>
<h3>All the below fields are required.</h3>
<form method="post" action="install.php">
<h2>Admin (Your) Details</h2>
<p>
<label>Admin Username</label><br>
<input type="text" name="adun" required><br>
<label>Admin Email</label><br>
<input type="email" name="adem" required><br>
<label>Admin Password</label><br>
<input type="password" name="adpw" required><br>
</p>
<h2>Company/Site Details</h2>
<p>
<label>Company Name or Site Title</label><br>
<input type="text" name="company" required><br>
<label>Domain Name (yourdomain.com, without http://www.)</label><br>
<input type="text" name="domain" required><br>
<label>Support Email (Usually support@yourdomain.com)</label><br>
<input type="email" name="support" required><br>
</p>
<h2>Database Details</h2>
<p>
<label>Database Host</label><br>
<input type="text" name="host" value="localhost" required><br>
<label>Database Username (Can use root)</label><br>
<input type="text" name="user" required><br>
<label>Database Password</label><br>
<input type="password" name="pass" required>
</p>
<h3>Final Notes</h3>
<p>
By default, Mino Framework installs into its own database, named <i>mino_[unique code]</i>.<br>
To do this, the username you entered above requires the appropriate permissions.<br><br>
After install, you will find the file settings.json in the /settings folder.<br>
You can update information about your site there, should you change the above information later.<br><br>
If you <i>already</i> have created a new database for Mino Framework, please enter its name below.<br>
Otherwise, leave it blank.
</p>
<p>
<label>Database Name (Usually left blank)</label><br>
<input type="text" name="name"><br>
<input type="submit" value="Install &rarr;">
</p>
</form>
</body>
</html>

<?php } ?>
