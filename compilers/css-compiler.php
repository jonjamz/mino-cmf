<?php

/*

    Mino Automated CSS Compiler 

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

   'Sass'   => $toMainDir.'client/library/other/sass/*.sass',
   'Scss'   => $toMainDir.'client/library/other/sass/*.scss',
   'Stylus' => $toMainDir.'client/library/other/stylus/*.styl',
   'Less'   => $toMainDir.'client/library/other/less/*.less',
   'css'    => $toMainDir.'client/library/css/*.css'
    
);

foreach($globDirs as $key => $value) {

  if($key != 'css' && count(glob($value)) != 0) {
    
    $func = $key.'Filter';
    
    $toFilter[] = new GlobAsset($value, array(new $func()));
  
  } elseif($key == 'css' && count(glob($value)) != 0) {
  
    $toFilter[] = new GlobAsset($value);
  
  }

}

$css = new AssetCollection($toFilter, array(
    new YuiCss('/usr/share/yui-compressor/yui-compressor.jar'),
));

header('Content-Type: text/css');
echo $css->dump();

?>
