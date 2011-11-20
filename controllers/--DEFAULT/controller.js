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
    url: "server/model.router.php", 
    data: 'type=default&method=' + method + '&args=' + args + '&model=' + model,
    success: function(data) {
      if(data.indexOf("!redirect") > -1) {
        var dest = data;
        dest = dest.replace(/!redirect\s*/,'');
        window.location.href = dest;
      }
      else if(data.indexOf("!push") > -1) {
        var dest = data;
        dest = dest.replace(/!push\s*/,'');
        History.pushState({state: dest}, dest, dest);
      }
      else if(data.indexOf("!append") > -1) {
        var resp = data;
        resp = resp.replace(/!append\s*/,'');
        if($(affect + ' .response').is('*')) {
          $(affect + ' .response').html(resp);
        }
        else {
          $(affect).append('<div class="response">' + resp + '</div>');
        }
      }
      else {
        $(affect).html(data);
      }
    }
  });
}


//------------------> SPECIAL MINO CLASSES


// .onLoad wrapped in a function, with initial call
function onLoads() {
  $('.onLoad').each(function() {
    var rndm = 'random-' + Math.floor(Math.random()*100000);
    $(this).addClass(rndm);
    var affect  = '.' + rndm;
    var model   = $(this).attr('data-model');
    var method  = $(this).attr('data-method');
    var args    = $(this).attr('data-send');
    models(model,method,args,affect);
    $(this).removeClass('.onLoad');
  });
}


function onLoadFades() {
  $('.onLoadFade').each(function(){
    $(this).delay(2000).fadeOut(1000);
  });
}


// .dbForm
$('#view-load').on("submit", "form.dbForm", function(){
  var rndm = 'random-' + Math.floor(Math.random()*100000);
  $(this).addClass(rndm);
  var affect  = '.' + rndm;
  var model   = $(this).attr('data-model');
  var method  = $(this).attr('data-method');
  var args1   = $(this).serializeJSON();
  var args2   = implode(',', args1);
  models(model,method,args2,affect);
  return false;
});


// .onClick
$('body').on("click", ".onClick", function(){
  var model   = $(this).attr('data-model');
  var method  = $(this).attr('data-method');
  var args    = $(this).attr('data-send');
  var affect  = $(this).attr('data-to');
  if(affect == 'this' || affect == '') {
    affect = 'random-' + Math.floor(Math.random()*100000);
    $(this).addClass(rndm);
  }
  models(model,method,args,affect);
  return false;
});


//------------------> ROUTING AND PUSHSTATE


// Stop from double-loading pages
var dbl = 0;


// .loadView with call to onLoads() to handle any new .onLoad elements
$('body').on("click", ".loadView", function() {
	var view 			= $(this).attr('data-view');
	var viewDir		= '';
  $.get("view.router.php", { view: view }, function(data){
    var viewDir = data;
    $('#view-load').load(viewDir, function() {
      onLoads();
      onLoadFades();
    });
  });
  dbl = 1;
  History.pushState({state: view}, view, view);
  dbl = 0;
	$('.selected').removeClass('selected');
	$(this).addClass('selected');
	return false;
});


// .loadSubView with call to onLoads() to handle any new .onLoad elements
$('body').on("click", ".loadSubView", function() {
	var view 			= $(this).attr('data-view');
	var affect    = $(this).attr('data-to');
	var viewDir		= '';
  $.get("view.router.php", { view: view }, function(data){
    var viewDir = data;
    $(affect).load(viewDir, function() {
      onLoads();
      onLoadFades();
    });
  });
  dbl = 1;
  History.pushState({state: view}, view, view);
  dbl = 0;
	$('.selected').removeClass('selected');
	$(this).addClass('selected');
	return false;
});


// Page load router
function routeUrl() {
  var view  = '<?php echo $view; ?>';
  $.get("view.router.php", { view: view }, function(data){
    var viewDir = data;
    $('#view-load').load(viewDir, function() {
      // Inject any URL variables
      $('[value="urlArg"]').attr('value', '<?php echo $viewArg; ?>');
      $('[data-send="urlArg"]').attr('data-send', '<?php echo $viewArg; ?>');
      onLoads();
      onLoadFades();
    });
  });
  dbl = 1;
  History.pushState({state: view}, view, view);
  dbl = 0;
}
routeUrl();


// State router
function routeState(state) {
  $.get("view.router.php", { view: state }, function(data){
    var viewDir = data;
    $('#view-load').load(viewDir, function() {
      onLoads();
      onLoadFades();
    });
  });
}

var goState = function() {
  if(dbl === 0) {
  var State = History.getState();
	  routeState(State.title);
	}
}


// State logger
History.Adapter.bind(window,'statechange',goState);
