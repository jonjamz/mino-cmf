// For async content loading inside an async loaded view

function models2(model,method,args,affect) {  
  $.ajax({ 
    type: "POST", 
    url: "server/router.php", 
    data: 'type=default&method=' + method + '&args=' + args + '&model=' + model,
    success: function(data) {
      if(data.indexOf("!redirect") > -1) {
        var dest = data;
        dest = dest.replace(/!redirect\s*/,'');
        window.location.href = dest;
      }
      else {
        $('.' + affect).html(data);
      }
    }
  });
}

$('.onLoad').each(function() {
  var rndm = 'random-' + Math.floor(Math.random()*1000000);
  $(this).addClass(rndm);
  var model   = $(this).attr('data-model');
  var method  = $(this).attr('data-method');
  var args    = $(this).attr('data-send');
  models2(model,method,args,rndm);
});

	<?php 
	      // This is really just for effects and non-ajax js
	      require_once __DIR__.'/'.$type.'.js'; 
	?>

