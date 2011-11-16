<?php $type = basename(__FILE__, '.php'); require_once __DIR__.'/../view.wrapper.php'; ?>
<nav>

<?php 

foreach (glob("views/*.php") as $nav) { 
																		
	$view = basename($nav, '.php');
	if($view != "view.wrapper") {
	  $name = ucfirst($view);
  	echo "<a href=\"\" class=\"loadView\" data-view=\"$view\">$name</a><br>"; 	
  }
}

?>

</nav>
