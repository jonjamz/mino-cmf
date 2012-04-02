<?php

/*

          MINO FRAMEWORK LAMP EDITION

            v1.0

*/



  /* CHECK IF MINO IS INSTALLED AND RUN...
   * ========================== */

require __DIR__.'/server/db/db.class.php';
$m = new db('users',true);
$t = $m->r("*", "type = 'super'");

if($t) {


      header('Content-Type:text/html; charset=UTF-8');
      session_start();

      // Paths
      $pathToRoot         = "/.";
      $pathToModelRouter  = "/routers/model.router.php";
      $pathToViewRouter   = "/routers/view.router.php";

      // Turn site wide Ajax Caching on/off, and set timing for any caching
      $ajaxCache = "off";
      $ajaxTimeout = "600"; // Seconds (600 = 10 mins)

      // User activity state settings
      $recentlyInactiveTime = '180000'; // Milliseconds
      $energySaverTime      = '900000'; // Milliseconds
      $energySaverMode      = 'on';

      // Set random string for nonce
      $secret = md5("secret_1" . session_id() . "secret_2");
	  $_SESSION['nonce'] = $secret;


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
<script src="<?php echo $pathToRoot; ?>/mino.package.js"></script>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script type="text/javascript">

/*

         _  _"              POWERED BY MINO ->
        ( `   )_            this website was built in and deployed from
       (    )    `)         the Mino cloud.
     (_   (_ .  _) _)

                                     _
                                   (  )
    _ .                         ( `  ) . )
  (  _ )_                      (_, _(  ,_)_)
(_  _(_ ,)
                      _
                     ('>
                     /))@@@@@.
                    /@"@@@@@()@
                   .@@()@@()@@@@
                   @@@O@@@@()@@@
                   @()@@\@@@()@@
                    @()@||@@@@@'
                     '@@||@@@'
                 Mino   ||   ...a language, framework, and platform (c) Jonathan James 2012
                 ^^^^^^^^^^^^^^^^^

*/

ENGINE('LOC','<?php if(empty($_GET["url"])) { echo base64_encode("emptyVar"); } else { echo base64_encode($_GET["url"]); } ?>');
ENGINE('RTP','<?php echo base64_encode($pathToRoot); ?>');
ENGINE('AXC','<?php echo base64_encode($ajaxCache); ?>');
ENGINE('RIT','<?php echo base64_encode($recentlyInactiveTime); ?>');
ENGINE('EST','<?php echo base64_encode($energySaverTime); ?>');
ENGINE('ESM','<?php echo base64_encode($energySaverMode); ?>');
ENGINE('NNC','<?php echo base64_encode($secret); ?>');
ENGINE('PTM','<?php echo base64_encode($pathToModelRouter); ?>');
ENGINE('PTV','<?php echo base64_encode($pathToViewRouter); ?>');
ENGINE('AXT','<?php echo base64_encode($ajaxTimeout); ?>');

</script>

</head>


<body>

<div class="container">

<div id="view-load">

  <!-- You can add a loading message or animation here. Keep the noscript, though. -->

  <noscript><h1>This site requires JavaScript!</h1><h6>Please enable it and/or upgrade your browser.</h6></noscript>

</div>

</div>

<div id="energySaver" style="display:none;position:fixed;top:0px;left:0px;width:100%;height:100%;background-color:rgba(0,0,0,0.93);z-index:99999;text-align:center;">
  <h1 style="color:#009900">Saving power.</h1><br>
  <h6>Click or press any key to continue your session.</h6>
</div>

<script type="text/javascript">

ENGINE('B1',base64_decode(MINOC('LOC')));
ENGINE('B2',base64_decode(MINOC('RTP')));
ENGINE('B3',base64_decode(MINOC('AXC')));
ENGINE('B4',base64_decode(MINOC('RIT')));
ENGINE('B5',base64_decode(MINOC('EST')));
ENGINE('B6',base64_decode(MINOC('ESM')));
ENGINE('B7',base64_decode(MINOC('NNC')));
ENGINE('B8',base64_decode(MINOC('PTM')));
ENGINE('B9',base64_decode(MINOC('PTV')));

</script>

<script src="<?php echo $pathToRoot; ?>/compilers/js-compiler.php"></script>

</body>
</html>


<?php



  /* IF MINO IS NOT INSTALLED, DO IT!
   * ========================== */

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
