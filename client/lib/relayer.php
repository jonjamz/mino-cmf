<?php

/*************

  INSERT YOUR API KEY
  
*************/

$key = 'f8738182a260225d63b8671a0659a75d';

/*************

  PRECAUTIONS:
  
  With this implementation, you probably should
  not use @import for local CSS and LESS files. 
  This is because we grab all the contents of 
  your files anyway and pack them into one file. 
  We are working on replicating file structure 
  at the moment, so it is a temporary issue.
  
  The best way to manage inclusions and their
  order is by adding a numeric prefix to your
  filenames. Of course, this does not matter
  if you're including remote files like Google
  Fonts. That still works fine. Thanks!

**************

  DIRECTIONS:

  1. Place this file in the base directory for
  your JS, CSS, etc.
  
  2. Add numbers to the beginnings of your file
  names to get them processed in the correct
  order. For example, when using jQuery:
  
    0.jquery.js
    1.custom.js
  
  3. Add your key to $key above if it isn't 
  already there.
  
  4. Drop these as necessary into your HTML file:
  
    CSS:
      
                  <link rel="stylesheet" href="path/to/this/file/relayer.php?type=css">
      
    LESS:
      
                  <link rel="stylesheet" href="path/to/this/file/relayer.php?type=less">
          
    JS:
    
                  <script src="/path/to/this/file/relayer.php?type=js"></script>    
      
    COFFEESCRIPT:
    
                  <script src="/path/to/this/file/relayer.php?type=coffee"></script>
    
*************/


/* get type */
$type = $_GET["type"];
$folder = null;

/* apply the appropriate header */
if($type == "css" || $type == "less") {
  header("Content-type: text/css");
  $folder = "css";
} elseif($type == "js" || $type == "coffee") {
  header("Content-type: text/javascript");
  $folder = "js";
}

/* string of file contents */
$code = null;

/* grab all the files */
foreach(glob(dirname(__FILE__)."/$folder/*.$type") as $file) {

  $code .= file_get_contents($file) . "
  
";

}

$url = 'http://relayer.co/server/api/1.0.php';
$body = 'code=' . $code . '&type=' . $type . '&key=' . $key;
$c = curl_init ($url);
curl_setopt ($c, CURLOPT_POST, true);
curl_setopt ($c, CURLOPT_POSTFIELDS, $body);
curl_setopt ($c, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec ($c);
curl_close ($c);

/* return code! */
echo $page;

?>