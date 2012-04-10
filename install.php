<?php error_reporting(E_ALL);

require __DIR__."/server/models/utility/security.php";

class install {

  private static $mysqli;
  private static $security;

  // Admin properties  
  private static $un;
  private static $em;
  private static $pw;
  
  // Company/Site properties
  private static $company;
  private static $domain;
  private static $support;
  
  // Database properties
  private static $host;
  private static $user;
  private static $pass;
  private static $name;


  function __construct($un,$em,$pw,$company,$domain,$support,$host,$user,$pass,$name='') {
    
    // Assign args to properties (except $name)
    self::$un       = $un;
    self::$em       = $em;
    self::$pw       = $pw;
    self::$company  = $company;
    self::$domain   = $domain;
    self::$support  = $support;
    self::$host     = $host;
    self::$user     = $user;
    self::$pass     = $pass;
    
    // Instantiate security class for password hashing
    self::$security = new security();
    
    // Process $name unless it already exists
    if($name == '') { 
      
      // Create a unique db name, add to property
      self::$name = 'mino_'.md5(time().mt_rand());
    
    } else {
    
      self::$name = $name;
      
    }
    
    
    //-------------------> Check for settings file
    
    
    $dir = __DIR__.'/settings/settings.json';
    
    if (file_exists($dir)) { 
    
      die("Settings file already exists! Please remove it before re-installing."); 
    
    }
    
    
    //-------------------> Check for permissions of the settings folder and create empty settings.json file
    
    
    $in			= __DIR__.'/settings/settings.json';
	  $make		= fopen($in, 'x') or die("<b>Error! Are settings folder permissions 777?</b><br>");
	  fclose($make);
    
      
    //-------------------> Create a database for this install
    
      
    // Recollect db name property
    $name = self::$name;
    
    // Create the database if it's not already up...
    $con = mysql_connect("$host","$user","$pass");
    
    if (!$con) {
      
      die('Could not connect: ' . mysql_error());
    
    }

    if (mysql_query("CREATE DATABASE IF NOT EXISTS `$name`;",$con)) {
      
      echo "Database $name created!<br>";
    
    } else {
    
      echo "Error creating database: " . mysql_error();
    
    }
    
    mysql_close($con);

 
    //-------------------> Connect to the database we just created

 
    // Connect to db
    self::$mysqli = new mysqli($host,$user,$pass,$name) or die ("Db connection problem.");

  }


  /*
      Write to settings.json file
  */

  function settingsFile() {
    
    // Assign properties to variables
    $company  = self::$company;
    $domain   = self::$domain;
    $support  = self::$support;
    $host     = self::$host;
    $name     = self::$name;
    $user     = self::$user;
    $pass     = self::$pass;
    
    
    // Write the settings.json file
    $in			= __DIR__.'/settings/settings.json';
	  $make		= fopen($in, 'w') or die("<b>Error creating settings file! Are settings folder permissions 777?</b><br>");
	  $inject	= "
	          
      {

        \"company-name\"    : \"$company\",
        \"domain-name\"     : \"$domain\",
        \"support-email\"   : \"$support\",

        \"db-host\" : \"$host\",
        \"db-name\" : \"$name\",
        \"db-user\" : \"$user\",
        \"db-pass\" : \"$pass\"
                          
      }
	          
      ";
	
	  fwrite($make, $inject);
	  fclose($make);
	  
	  return true;
  
  }


  /*
      Where the install happens
  */
  
  function build() {
    
    // Grab properties
    $name   = self::$name;
    $un     = self::$un;
    $em     = self::$em;
    $pw     = self::$pw;
    $cpw    = self::$security->bCrypt($pw);
    
    
    // Create settings file
    $setf = $this->settingsFile();
    if($setf) { echo "Settings.json file created!<br>"; }
    
    // Create users table
    $table = self::$mysqli->query("
      
      CREATE TABLE IF NOT EXISTS `users` (
        `id` bigint(20) NOT NULL AUTO_INCREMENT,
        `username` varchar(100),
        `email` varchar(100) NOT NULL,
        `password` varchar(100) NOT NULL,
        `activateCode` varchar(255),
        `activated` enum('0','1') NOT NULL DEFAULT '0',
        `passCode` varchar(255),
        `type` varchar(25),
        `archived` enum('0','1'),
        PRIMARY KEY (`id`),
        UNIQUE KEY `email` (`email`)
      ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;
      
      ");
    
    $user = self::$mysqli->query("
    
      INSERT INTO `users` VALUES('0','$un','$em','$cpw','','1','','super','0');
      
    ");
    
    if($table && $user) { return true; } else { return false; }
    
  }

}

$i  = new install(
                    $_POST['adun'],
                    $_POST['adem'],
                    $_POST['adpw'],
                    $_POST['company'],
                    $_POST['domain'],
                    $_POST['support'],
                    $_POST['host'],
                    $_POST['user'],
                    $_POST['pass'],
                    $_POST['name']
                 );

$go = $i->build();

if($go) { echo 'Install successful! <a href="index.php">Log in</a>'; }
else { echo 'There was an error.'; }

?>
