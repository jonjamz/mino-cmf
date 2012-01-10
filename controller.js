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
    $.get("routers/view.router.php", { url: view }, function(data){
    var viewDir   = data.view;
    var vars      = data.vars;
    var varslist  = implode(',', vars);
    if(viewDir.indexOf("!logout") > -1) {
      window.location.href = 'index.php';
    } else {
      viewLoad(viewDir, vars, varslist, affect);
    }

  }, "json");
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

function viewLoad(viewDir, vars, varslist, affect) {
  $(affect).load(viewDir, function() {
    $.each(vars, function(k, v) {
      $('[value="^' + k + '"]').attr('value', v);
      $('[data-send="^' + k + '"]').attr('data-send', v);
    });
    $('[value="urlArgs"]').attr('value', varslist);
    $('[data-send="urlArgs"]').attr('data-send', varslist);
    onLoads();
    onLoadFades();
    loadIncludes();
    loadInputs();
  });
}

// .loadView with call to onLoads() to handle any new .onLoad elements
$('body').on("click", ".loadView", function() {
	var view 			= $(this).attr('data-view');
  $.get("routers/view.router.php", { url: view }, function(data){
    var viewDir   = data.view;
    var title     = data.title;
    var address   = data.address;
    var vars      = data.vars;
    var varslist  = implode(',', vars);
    var affect    = '#view-load';
    if(viewDir.indexOf("!logout") > -1) {
      window.location.href = 'index.php';
    } else {
      viewLoad(viewDir, vars, varslist, affect);
    }
    dbl = 1;
    History.pushState({state: view}, title, address);
    dbl = 0;
  }, "json");
	$('.selected').removeClass('selected');
	$(this).addClass('selected');
	return false;
});


// .loadSubView with call to onLoads() to handle any new .onLoad elements
$('body').on("click", ".loadSubView", function() {
	var view 			= $(this).attr('data-view');
	var affect    = $(this).attr('data-to');
  $.get("routers/view.router.php", { url: view }, function(data){
    var viewDir   = data.view;
    var title     = data.title;
    var address   = data.address;
    var vars      = data.vars;
    var varslist  = implode(',', vars);
    if(viewDir.indexOf("!logout") > -1) {
      window.location.href = 'index.php';
    } else {
      viewLoad(viewDir, vars, varslist, affect);
    }
    dbl = 1;
    History.pushState({state: view}, title, address);
    dbl = 0;
  }, "json");
	$('.selected').removeClass('selected');
	$(this).addClass('selected');
	return false;
});


// Page load & URL variable router
function routeUrl() {
  
  var url  = '<?php 
  
  // Because we're sending this off using REST we should provide a value if var is empty
  if(empty($_GET["url"])) { echo 'emptyVar'; } else { echo $_GET["url"]; }
  
  ?>';
  
  // Send to view router, which returns json with view location, page title, and vars
  $.get("routers/view.router.php", { url: url }, function(data){
    
    var viewDir   = data.view;
    var title     = data.title;
    var address   = data.address;
    var vars      = data.vars;
    var varslist  = implode(',', vars);
    var affect    = '#view-load';
    
    // Load view into #view-load
    viewLoad(viewDir, vars, varslist, affect);
    
    // Push the state with History.js
    dbl = 1;
    History.pushState({state: url}, title, address);
    dbl = 0;
  }, "json");

}
routeUrl();


// State router
function routeState(state) {
  $.get("routers/view.router.php", { url: state }, function(data){
    var viewDir   = data.view;
    var title     = data.title;
    var vars      = data.vars;
    var varslist  = implode(',', vars);
    var affect    = '#view-load';
    viewLoad(viewDir, vars, varslist, affect);
  }, "json");
}

var goState = function() {
  if(dbl === 0) {
  var State = History.getState();
	  routeState(State.data.state);
	}
}


// State bind
History.Adapter.bind(window,'statechange',goState);
