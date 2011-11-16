function get(model,method,args,affect) {  
  
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
};

function implode(glue, pieces) {
  var i = '',
    retVal = '',
    tGlue = '';
  if (arguments.length === 1) {
    pieces = glue;
    glue = '';
  }
  if (typeof(pieces) === 'object') {
    if (Object.prototype.toString.call(pieces) === '[object Array]') {
      return pieces.join(glue);
    } 
    for (i in pieces) {
      retVal += tGlue + pieces[i];
      tGlue = glue;
    }
      return retVal;
  }
  return pieces;
}

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
$('form.dbForm').submit(function(){
  var rndm = 'random-' + Math.floor(Math.random()*1000000);
  $(this).addClass(rndm);
  var model   = $(this).attr('data-model');
  var method  = $(this).attr('data-method');
  var args1   = $(this).serializeJSON();
  var args2   = implode(',', args1);
  get(model,method,args2,rndm);
  return false;
});

	<?php 
	      // This is really just for effects and non-ajax js
	      require_once __DIR__.'/'.$type.'.js'; 
	?>
