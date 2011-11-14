function activate(code) {
	$.post(modelDir, 
	{type: "direct", method: method, uid: "<?php echo $SESSION["id"]; ?>"}, 
	function(data) { 
	  if(data != '') { $('div[data-model=' + method + ']').html(data); }
	});
};
activate(<?php echo $activateCode; ?>);
