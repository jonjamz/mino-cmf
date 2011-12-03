<?php

/*

    Mino Automated JavaScript Compiler 

*/

require __DIR__.'/autoload.php';

use Assetic\Asset\AssetCollection;
use Assetic\Asset\GlobAsset;

use Assetic\Filter\CoffeeScriptFilter;
use Assetic\Filter\Yui\JsCompressorFilter as YuiJs;


$toMainDir = __DIR__.'/../';

$globDirs = array(

   'CoffeeScript' => $toMainDir.'/client/library/other/coffee/*.coffee',
   'js'           => $toMainDir.'client/library/js/*.js',
    
);

foreach($globDirs as $key => $value) {

  if($key != 'js' && count(glob($value)) != 0) {
    
    $func = $key.'Filter';
    
    $toFilter[] = new GlobAsset($value, array(new $func()));
  
  } elseif($key == 'js' && count(glob($value)) != 0) {
  
    $toFilter[] = new GlobAsset($value);
  
  }

}

$js = new AssetCollection($toFilter, array(
    new YuiJs('/usr/share/yui-compressor/yui-compressor.jar'),
));

header('Content-Type: application/js');
echo $js->dump();

?>
