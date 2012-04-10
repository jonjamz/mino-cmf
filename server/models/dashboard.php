<?php 

$type = "dashboard"; 
require_once __DIR__."/model.wrapper.php"; 

class dashboard { 

  function gridViews() {
    
    foreach (glob(__DIR__."/../../../client/views/*.html") as $nav) { 
																		
    	$view = basename($nav, '.html');
    	if($view != "view.wrapper") {
      	$name = ucfirst($view);

      	echo "<a href=\"\" class=\"loadView\" data-view=\"$view\">
      	<div class=\"dashGrid\">icon</div><br>$name
      	</a> \n";
    	}

    }
      	  
  }

} ?>
