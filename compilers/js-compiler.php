<?php

/*

    Mino Automated JavaScript Compiler and Cache

*/

require __DIR__.'/autoload.php';

use Assetic\Asset\AssetCollection;
use Assetic\Asset\GlobAsset;
use Assetic\Filter\CoffeeScriptFilter;
use Assetic\Filter\Yui\JsCompressorFilter as YuiJs;


$toMainDir = __DIR__.'/../';

$globDirs = array(

   'CoffeeScript' => $toMainDir.'client/lib/other/coffee/*.coffee',
   'js'           => $toMainDir.'client/lib/js/*.js',

);

// Calculate file hash for cache comparison
foreach($globDirs as $key => $value) {

  $thisGlob  = glob($value);

  $fileHash = '';

  if(count($thisGlob) != 0) {

    foreach($thisGlob as $key => $value) {

      $fileHash .= hash_file('md5', $value);

    }
    
    $fileHash = md5($fileHash);

  }

}

// Check local folder for existing cache file
$localGlob = glob(__DIR__."/cache/*.js");
$count = count($localGlob);

// If multiple, throw error
if($count > 1) {

  echo "Error. Please remove all files from 'compilers/cache' folder. If you put files there, manually, move them to 'client/lib' instead.";

// If a file exists, compare name with hash
} elseif($count === 1 && "$fileHash.js" == basename($localGlob[0])) {

  header('Content-Type: application/js');
  include __DIR__."/cache/$fileHash.js";

// If no file, or mismatched hashes, write a new file to cache
} elseif($count === 0 || "$fileHash.js" != basename($localGlob[0])) {

  // Clean old file
	foreach ($localGlob as $key => $value) { unlink($value); }

  // Create array for processing
  $toFilter = array();

  foreach($globDirs as $key => $value) {

    if($key != 'js' && count(glob($value)) != 0) {

      $toFilter[] = new GlobAsset($value, array(new CoffeeScriptFilter()));

    } elseif($key == 'js' && count(glob($value)) != 0) {

      $toFilter[] = new GlobAsset($value);

    }

  }

  // Process and output into a new file, then call that file
  $js = new AssetCollection($toFilter, array(

    new YuiJs('/usr/share/yui-compressor/yui-compressor.jar'),

  ));

  $content  = $js->dump();
	$name		  = $fileHash.".js";

	$in			= __DIR__."/cache/".$name;
	$make		= fopen($in, 'x') or die("Can't open file!");
	$inject	= $content;
	fwrite($make, $inject);
	fclose($make);

	header('Content-Type: application/js');
	include $in;

}

?>
