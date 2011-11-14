/*
    This is included in every view via the view wrapper, and connects it with the right model/controller.
    It has JavaScript written below, because it's referenced within script tags.
*/


	// Below is a general "get" function. It attaches a method's response to its designated div in the view.


	function idGet(method) {

		$.post(modelDir, 
		{type: "direct", method: method, uid: "<?php echo $SESSION["id"]; ?>"}, 
		function(data) { 
		  if(data != '') { $('div[data-model=' + method + ']').html(data); }
		});
	
	};

	
	// The controllers exist primarily to connect with complicated get and set model methods.
	
	<?php require_once __DIR__.'/'.$type.'.js'; ?>
