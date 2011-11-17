//------------------> CONTROLLER FUNCTIONS

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

function models(model,method,args,affect) {  
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

//------------------> SPECIAL MINO CLASSES

$('#view-load').on("submit", "form.dbForm", function(){
  var rndm = 'random-' + Math.floor(Math.random()*1000000);
  $(this).addClass(rndm);
  var model   = $(this).attr('data-model');
  var method  = $(this).attr('data-method');
  var args1   = $(this).serializeJSON();
  var args2   = implode(',', args1);
  models(model,method,args2,rndm);
  return false;
});

$('#view-load').on("click", ".onClick", function(){
  var rndm = 'random-' + Math.floor(Math.random()*1000000);
  $(this).addClass(rndm);
  var model   = $(this).attr('data-model');
  var method  = $(this).attr('data-method');
  var args    = $(this).attr('data-send');
  models(model,method,args,rndm);
  return false;
});

$('body').on("ready", function(){
  $(this).delay(2000).fadeOut(1000);
});

$('nav').on("click", ".loadView", function() {
	var view 			= $(this).attr('data-view');
	var viewDir		= 'views/' + view + '.php';
	$('#view-load').load(viewDir);
	$('nav a').removeClass('selected');
	$(this).addClass('selected');
	return false;
});

$('#view-load').on("click", ".loadView", function() {
	var view 			= $(this).attr('data-view');
	var viewDir		= 'views/' + view + '.php';
	$('#view-load').load(viewDir);
	$('nav a').removeClass('selected');
	$(this).addClass('selected');
	return false;
});
