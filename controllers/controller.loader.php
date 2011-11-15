function get(model,method,args,affect) {  
  
  $.ajax({ 
    type: "POST", 
    url: "server/router.php", 
    data: 'type=default&method=' + method + '&args=' + args + '&model=' + model,
    success: function(data) {
      $('.' + affect).html(data);
    }
  });
};

// Special .onLoad class  
$('.onLoad').each(function(){
  var rndm = 'random-' + Math.floor(Math.random()*1000000);
  $(this).addClass(rndm);
  var model   = $(this).attr('data-model');
  var method  = $(this).attr('data-method');
  var args    = $(this).attr('data-send');
  get(model,method,args,rndm);
});

// Special .dbForm class
$('.dbForm').submit(function(){
  var rndm = 'random-' + Math.floor(Math.random()*1000000);
  $(this).addClass(rndm);
  var model   = $(this).attr('data-model');
  var method  = $(this).attr('data-method');
  var args    = $(this).serialize();
  get(model,method,args,rndm);
});

	<?php 
	      // This is really just for effects and non-ajax js
	      require_once __DIR__.'/'.$type.'.js'; 
	?>
