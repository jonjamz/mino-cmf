/*
    This is included in every view via the view wrapper, and connects it with the right model/controller.
    It has JavaScript written below, because it's referenced within script tags.
*/


/* 
    Below is a general "get" function. It attaches a method's response to its designated div in the view.
    The "args" variable must be passed as a simple comma-delimited list according to the desired method.
*/


	function get(modelFile,method,args) {
    
    $.ajax({ 
      type: "POST", 
      url: modelFile, 
      data: 'type=default&method=' + method + '&args=' + args,
	    success: function(data) {
	
	      $('div[data-model=' + method + ']').html(data);
	
	    }
	  });
	
	};
	
	<?php require_once __DIR__.'/'.$type.'.js'; ?>
