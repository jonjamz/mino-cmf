//------------------> CONTROLLER FUNCTIONS


// PHP.JS implode function
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


// Models function for interfacing with models
function models(model,method,args,affect) {  
  $.ajax({ 
    type: "POST", 
    url: "routers/model.router.php", 
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


// .onLoad wrapped in a function
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

// .include wrapped in a function
function loadIncludes() {
  $('.include').each(function() {
    var rndm = 'random-' + Math.floor(Math.random()*100000);
    $(this).addClass(rndm);
    
    // Prevent an infinite loop
    $(this).removeClass('include');
    
    var affect  = '.' + rndm;
    var view   = $(this).attr('data-view');
    $.get("routers/view.router.php", { view: view }, function(data){
      var viewDir = data;
      $(affect).load(viewDir, function() {
        onLoads();
        onLoadFades();
        loadIncludes();
        loadInputs();
      });
    });
  });
}

// .onLoadFades, for logout or errors possibly
function onLoadFades() {
  $('.onLoadFade').each(function(){
    $(this).delay(2000).fadeOut(1000);
  });
}


// Assign classes to inputs based on their type
function loadInputs() {
  $('input').each(function() {
    var type = $(this).attr('type');
    
    $(this).addClass(type);
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
  $('input[type=submit]', this).attr('disabled','disabled');
  return false;
});


// .onClick
$('body').on("click", ".onClick", function(){
  var model   = $(this).attr('data-model');
  var method  = $(this).attr('data-method');
  var args    = $(this).attr('data-send');
  var affect  = $(this).attr('data-to');
  if(affect === 'this' || affect === '') {
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
  $.get("routers/view.router.php", { view: view }, function(data){
    if(data.indexOf("!logout") > -1) {
        window.location.href = 'index.php?url=logout';
    } else {
      var viewDir = data;
      $('#view-load').load(viewDir, function() {
        onLoads();
        onLoadFades();
        loadIncludes();
        loadInputs();
      });
    }
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
  $.get("routers/view.router.php", { view: view }, function(data){
    if(data.indexOf("!logout") > -1) {
        window.location.href = 'index.php?url=logout';
    } else {
    var viewDir = data;
      $(affect).load(viewDir, function() {
        onLoads();
        onLoadFades();
        loadIncludes();
        loadInputs();
      });
    }
  });
  dbl = 1;
  History.pushState({state: view}, view, view);
  dbl = 0;
	$('.selected').removeClass('selected');
	$(this).addClass('selected');
	return false;
});


// Page load & URL variable router
function routeUrl() {
  var view  = '<?php echo $view; ?>';
  $.get("routers/view.router.php", { view: view }, function(data){
    var viewDir = data;
    $('#view-load').load(viewDir, function() {
    
      // Inject default URL variables
      
        // For (hidden?) input types
        $('[value="urlArg"]').attr('value', '<?php echo $urlArg; ?>');
        
        // For onLoads or onClicks...
        $('[data-send="urlArg"]').attr('data-send', '<?php echo $urlArg; ?>');
      
      // Inject custom URL variables
      
        // Replace by single variable
        <?php foreach($urlArgs as $key => $val) { ?>
            
            $('[value="^<?php echo $key; ?>"]').attr('value', '<?php echo $val; ?>');
            $('[data-send="^<?php echo $key; ?>"]').attr('data-send', '<?php echo $val; ?>');
            
        <?php } ?>
        
        // List all values in comma delimited list for sending to models
        $('[value="urlArgs"]').attr('value', '<?php echo implode(",", $urlArgs); ?>');
        $('[data-send="urlArgs"]').attr('data-send', '<?php echo implode(",", $urlArgs); ?>');
      
        // List only non-alphabetic keys (reserves associative items for separate use)
        <?php foreach($urlArgs as $key => $val) { if(is_int($key)) { $urlArgsNumeric[] = $val; } } ?>
        
        // List only alphabetic keys (reserves numeric items for separate use)
        <?php foreach($urlArgs as $key => $val) { if(!is_int($key)) { $urlArgsAlpha[] = $val; } } ?>
        
        $('[value="urlArgs"]').attr('value', '<?php echo implode(",", $urlArgs); ?>');
        $('[data-send="urlArgs"]').attr('data-send', '<?php echo implode(",", $urlArgs); ?>');
        $('[value="urlArgsN"]').attr('value', '<?php echo implode(",", $urlArgsNumeric); ?>');
        $('[data-send="urlArgsN"]').attr('data-send', '<?php echo implode(",", $urlArgsNumeric); ?>');
        $('[value="urlArgsA"]').attr('value', '<?php echo implode(",", $urlArgsAlpha); ?>');
        $('[data-send="urlArgsA"]').attr('data-send', '<?php echo implode(",", $urlArgsAlpha); ?>');
        
      onLoads();
      onLoadFades();
      loadIncludes();
      loadInputs();
    });
  });
  dbl = 1;
  History.pushState({state: view}, view, view);
  dbl = 0;
}
routeUrl();


// State router
function routeState(state) {
  $.get("routers/view.router.php", { view: state }, function(data){
    var viewDir = data;
    $('#view-load').load(viewDir, function() {
      onLoads();
      onLoadFades();
      loadIncludes();
      loadInputs();
    });
  });
}

var goState = function() {
  if(dbl === 0) {
  var State = History.getState();
	  routeState(State.title);
	}
}


// State bind
History.Adapter.bind(window,'statechange',goState);
