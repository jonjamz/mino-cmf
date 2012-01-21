<?php

/*

    Mino Automated CSS Compiler and Cache

*/

require __DIR__.'/autoload.php';

use Assetic\Asset\AssetCollection;
use Assetic\Asset\GlobAsset;
use Assetic\Filter\Sass\SassFilter;
use Assetic\Filter\Sass\ScssFilter;
use Assetic\Filter\StylusFilter;
use Assetic\Filter\LessFilter;
use Assetic\Filter\Yui\CssCompressorFilter as YuiCss;


$toMainDir = __DIR__.'/../';

$globDirs = array(

   //'Sass'   => $toMainDir.'client/library/other/sass/*.sass',
   //'Scss'   => $toMainDir.'client/library/other/sass/*.scss',
   'Stylus' => $toMainDir.'client/library/other/stylus/*.styl',
   'Less'   => $toMainDir.'client/library/other/less/*.less',
   'css'    => $toMainDir.'client/library/css/*.css'

);

// Calculate file hash for cache comparison
foreach($globDirs as $key => $value) {

  $thisGlob  = glob($value);

  $fileHash = '';

  if(count($thisGlob) != 0) {

    foreach($thisGlob as $key => $value) {

      $fileBase = basename($value);
      $fileHash .= hash_file('md5', $value);

    }

  }

}

// Check local folder for existing cache file
$localGlob = glob(__DIR__."/cache/*.css");
$count = count($localGlob);

// If multiple, throw error
if($count > 1) {

  echo "Error. Please remove all files from 'compilers/cache' folder. If you put files there, manually, move them to 'client/library' instead.";

// If a file exists, compare name with hash
} elseif($count === 1 && "$fileHash.css" == basename($localGlob[0])) {

  header('Content-Type: text/css');
  include __DIR__."/cache/$fileHash.css";

// If no file, or mismatched hashes, write a new file to cache
} elseif($count === 0 || "$fileHash.css" != basename($localGlob[0])) {

  // Clean old file
	foreach ($localGlob as $key => $value) { unlink($value); }

  // Create array for processing
  $toFilter = array();

  foreach($globDirs as $key => $value) {

    if($key != 'css' && count(glob($value)) != 0) {

      //if($key == 'Sass') { $toFilter[] = new GlobAsset($value, array(new SassFilter())); }
      //elseif($key == "Scss") { $toFilter[] = new GlobAsset($value, array(new ScssFilter())); }
      if($key == "Stylus") { $toFilter[] = new GlobAsset($value, array(new StylusFilter())); }
      elseif($key == "Less") { $toFilter[] = new GlobAsset($value, array(new LessFilter())); }

    } elseif($key == 'css' && count(glob($value)) != 0) {

      $toFilter[] = new GlobAsset($value);

    }

  }

  // Process and output into a new file, then call that file
  $css = new AssetCollection($toFilter, array(

    new YuiCss('/usr/share/yui-compressor/yui-compressor.jar'),

  ));

  $content  = $css->dump();
	$name		  = $fileHash.".css";

	$in			= __DIR__."/cache/".$name;
	$make		= fopen($in, 'x') or die("Can't open file!");
	$inject	= $content;
	fwrite($make, $inject);
	fclose($make);

	header('Content-Type: text/css');
	include $in;

}

?>
