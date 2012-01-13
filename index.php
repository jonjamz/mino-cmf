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
<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="client/library/images/favicon.png">
<link rel="apple-touch-icon" href="client/library/images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="client/library/images/apple-touch-icon-72x72-precomposed.png">
<link rel="apple-touch-icon" sizes="114x114" href="client/library/images/apple-touch-icon-114x114-precomposed.png">
<link rel="stylesheet" href="compilers/css-compiler.php">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="compilers/js-compiler.php"></script>
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
<style type="text/css">
  body {font-family: arial,verdana,sans-serif;}
  input {border-radius:6px;border:1px solid #2299ff;padding:6px;color:#bbb;font-size:1.2em;font-style:italic}
  input:hover {background:#dff3ff;border-radius:9px;}
  input:focus {box-shadow:0 0 4px #6699ff, inset 0 0 14px #fff;background:#dff3ff;outline:none;border-radius:9px;}
  input[type=submit] {box-shadow:inset 0 -3px 14px #aaa;background:#fff;border:4px solid #2299ff;color:#000;margin-top:30px;font-size:1.4em;font-style:normal}
  input[type=submit]:hover {box-shadow:inset 0 3px 14px #aaa}
  p, ul, ol {margin: 1.5em;padding-left:12px; border-left:8px #eee solid}
  h1, h2, h3, h4, h5, h6 {letter-spacing: -1px;font-family: arial,verdana,sans-serif;margin: 1.2em 0 .3em;color:#000;border-bottom: 1px solid #eee;padding-bottom: .1em}
  h1 {font-size: 196%;margin-top:.6em}
  h2 {font-size: 136%}
  h3 {font-size: 126%}
  h4 {font-size: 116%}
  h5 {font-size: 106%}
  h6 {font-size: 96%}
</style>
</head>
<body>
<h1>Install Mino Framework LAMP Edition</h1>
<p>
<em><b>&copy; 2011 Jon James (github.com/jonjamz)</b></em><br><br>
This edition of Mino Framework is dependent upon the following free software:<br><br>

  <span style="color:#ff8844">Linux with Apache 2, PHP 5.3+ w/PEAR Mail, MySQL 5, and YUI compressor installed.

</p>
<h2>Preparing Your Server (Optional)</h2>
<p>
We use Ubuntu Linux 32-bit for our server.<br><br>
Here are simple terminal commands to get a new Ubuntu 32-bit server ready for Mino.<br><br>
<b>Newbs:</b> Copy in <i>one line at a time</i> and press enter after each line.
</p>
<div style="font-family: Courier, monospace">
<p>
cd ~<br>
sudo apt-get install tasksel<br>
sudo tasksel install lamp-server<br>
sudo apt-get install phpmyadmin<br>
sudo apt-get install php-pear<br>
sudo pear install mail<br>
sudo pear install Net_SMTP<br>
sudo pear install Auth_SASL<br>
sudo pear install mail_mime<br>
sudo apt-get install yui-compressor<br>
</p>
</div>
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
