<?php

spl_autoload_register(
    function($className)
    {
        $fileName = str_replace("\\", "/", $className);
        require __DIR__."/$fileName.php";
    }
);

?>
