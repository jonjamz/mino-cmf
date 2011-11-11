<?php

require_once __DIR__."/db.class.php";

echo "<b>!!! COMPILER TESTING GROUND !!!</b><br><br>";

$db = new db('people');

echo $db->table;

?>
