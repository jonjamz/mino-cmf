

<?php 

foreach (glob("views/*.php") as $nav) { 
																		
	$view = basename($nav, '.php');
	$name = ucfirst($view);

	echo "<a href=\"\" onclick=\"return false\" data-view=\"$view\">$name</a> \n"; 	

}

?>
