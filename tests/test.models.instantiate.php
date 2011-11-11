<?php

/*
    Test all models and output results...later I'll have to start making file references based on an outside file
    Or, include all the files on one page in case people move them around, because I want them to have access
    to the tests
*/

$path = realpath(__DIR__."/../server/models");

$Directory = new RecursiveDirectoryIterator($path);
$Iterator = new RecursiveIteratorIterator($Directory);
$Regex = new RegexIterator($Iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

foreach($Regex as $name => $object){
   
    $base = basename($name, '.php');
    
    if($base != 'email' && $base != 'notifications' && $base != 'responses' && $base != 'model.wrapper') {
      require_once "$name";
      $$base = new $base($base);
      echo "$base instantiated.<br>";
          
    }
}

?>
