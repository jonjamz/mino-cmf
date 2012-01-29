// Receives url and rootPath variables from index.php
// -----------------

// Optionally disable AJAX caching
if(ajaxCache === 'off') {
  $.ajaxSetup ({
      // Disable caching of AJAX responses for testing
      cache: false
  });
}

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
    url: rootPath + "/routers/model.router.php",
    data: 'type=default&method=' + method + '&args=' + args + '&model=' + model,
    success: function(data) {

      //---> RETURNS

      // Initiates a JS redirect with page load
      if(data.indexOf("!redirect") > -1) {
        var dest = data;
        dest = dest.replace(/!redirect\s*/,'');
        window.location.href = rootPath + "/" + dest;
      }
      // A floating response that then redirects a user via page load after 3 seconds (for deletions)
      else if(data.indexOf("!resredir") > -1) {
        var resp = data;
        var url = resp.replace(/.*\[/,'');
        url = url.replace(/\].*/,'');
        var message = resp.replace(/.*\]/,'');
        $('body').append('<div class="flresp">' + message + '</div>');
        $('.flresp').fadeIn().delay(3000).queue(function(){
          window.location.href = rootPath + "/" + url;
        });
      }
      // Initiates a view change without page load
      else if(data.indexOf("!push") > -1) {
        var dest = data;
        dest = dest.replace(/!push\s*/,'');
        History.pushState({state: dest}, dest, dest);
      }
      // A real-time version of !resredir that loads in a replaces the primary view (capable of passing vars)
      else if(data.indexOf("!respush") > -1) {
        var resp = data;
        var url = resp.replace(/.*\[/,'');
        url = url.replace(/\].*/,'');
        var message = resp.replace(/.*\]/,'');
        $('body').append('<div class="flresp">' + message + '</div>');
        $('.flresp').fadeIn().delay(3000).queue(function(){
          $(this).fadeOut();
          History.pushState({state: url}, url, url);
        });
      }
      // Injects a response div with content, appends one first if it has to
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


// .modal turns a div into a modal
if($(".modal").length > 0) {
  $(".modal").modal();
}

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
    $.get(rootPath + "/routers/view.router.php", { url: view }, function(data){
    var viewDir   = data.view;
    var vars      = data.vars;
    var varslist  = implode(',', vars);
    if(viewDir.indexOf("!logout") > -1) {
      window.location.href = rootPath + '/';
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

// .onLoadPoll, for ajax polling over an interval via setTimeout
function onLoadPolls() {
  $('.onLoadPoll').each(function(){
    var rndm = 'random-' + Math.floor(Math.random()*100000);
    $(this).addClass(rndm);
    var affect  = '.' + rndm;
    var model   = $(this).attr('data-model');
    var method  = $(this).attr('data-method');
    var args    = $(this).attr('data-send');
    var time    = $(this).attr('data-time');
    if(time === '') {
      time = 10000;
    }
    function poll() {
      models(model,method,args,affect);
      setTimeout(poll,time);
    }
    poll();
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
  var rndm    = 'random-' + Math.floor(Math.random()*100000);
  $(this).addClass(rndm);
  var affect  = '.' + rndm;
  var model   = $(this).attr('data-model');
  var method  = $(this).attr('data-method');
  var args1   = $(this).serializeJSON();
  var args2   = implode(',', args1);
  models(model,method,args2,affect);
  $('input[type=submit]', this).attr('disabled','disabled').delay(2000).queue(function() {
    $(this).removeAttr('disabled');
    return false;
  });
});


// .onClick
$('body').on("click", ".onClick", function(){
  var model   = $(this).attr('data-model');
  var method  = $(this).attr('data-method');
  var args    = $(this).attr('data-send');
  var affect  = $(this).attr('data-to');
  if(affect === 'this' || affect === '') {
    affect = 'random-' + Math.floor(Math.random()*100000);
    $(this).addClass(affect);
  }
  models(model,method,args,affect);
  return false;
});


// .search, if search string is greater than 2 chars
$('body').on("keyup", ".search", function(){
  var value     = $(this).val();
  if(value.length > 2) {
    var model   = $(this).attr('data-model');
    var method  = $(this).attr('data-method');
    var args    = value;
    // For search, you must have a specific place for the return value
    var affect  = $(this).attr('data-to');
    models(model,method,args,affect);
  }
});

//------------------> ROUTING AND PUSHSTATE


// Stop from double-loading pages
var dbl = 0;

function viewLoad(viewDir, vars, varslist, affect) {

  // Prepend the root path to avoid breaking view filepaths with / URLs
  var viewDir = rootPath + "/" + viewDir;

  $(affect).load(viewDir, function() {
    $.each(vars, function(k, v) {
      $('[value~="^' + k + '"]').attr('value', v);
      $('[data-send~="^' + k + '"]').attr('data-send', v);
    });
    $('[value~="urlArgs"]').attr('value', varslist);
    $('[data-send~="urlArgs"]').attr('data-send', varslist);
    onLoads();
    onLoadFades();
    onLoadPolls();
    loadIncludes();
    loadInputs();
  });
}

// .loadView with call to onLoads() to handle any new .onLoad elements
$('body').on("click", ".loadView", function() {
	var view 			= $(this).attr('data-view');
  $.get(rootPath + "/routers/view.router.php", { url: view }, function(data){
    var viewDir   = data.view;
    var title     = data.title;
    var address   = data.address;
    var vars      = data.vars;
    var varslist  = implode(',', vars);
    var affect    = '#view-load';
    if(viewDir.indexOf("!logout") > -1) {
      window.location.href = rootPath + '/';
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
  $.get(rootPath + "/routers/view.router.php", { url: view }, function(data){
    var viewDir   = data.view;
    var title     = data.title;
    var address   = data.address;
    var vars      = data.vars;
    var varslist  = implode(',', vars);
    if(viewDir.indexOf("!logout") > -1) {
      window.location.href = rootPath + '/';
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

  var initFlag = '!init';

  // Send to view router, which returns json with view location, page title, and vars
  $.get(rootPath + "/routers/view.router.php", { url: initFlag + url }, function(data){

    var viewDir   = data.view;
    var title     = data.title;
    var address   = data.address;
    var vars      = data.vars;
    var flag      = data.flag;
    var varslist  = implode(',', vars);
    var affect    = '#view-load';

    if(flag === 2) { window.location.href = rootPath + '/'; }
    else if(flag === 1) {

      // Load view into #view-load
      viewLoad(viewDir, vars, varslist, affect);

      // Force title change
      document.title = title;

      dbl = 1;
      History.pushState({state: url}, title);
      dbl = 0;

    }
    else {

      // Load view into #view-load
      viewLoad(viewDir, vars, varslist, affect);

      dbl = 1;
      History.pushState({state: url}, title, address);
      dbl = 0;


    }

  }, "json");

}
routeUrl();


// State router
function routeState(state) {
  $.get(rootPath + "/routers/view.router.php", { url: state }, function(data){
    var viewDir   = data.view;
    var title     = data.title;
    var vars      = data.vars;
    var varslist  = implode(',', vars);
    var affect    = '#view-load';
    if(viewDir.indexOf("!logout") > -1) {
      window.location.href = rootPath + '/';
    } else {
      viewLoad(viewDir, vars, varslist, affect);
    }
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
