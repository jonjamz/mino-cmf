/*!

     .
       .
   . ;.
    .;
     ;;.
   ;.;;
   ;;;;.
   ;;;;;
   ;;;;;
   ;;;;;
   ;;;;;
   ;;;;;
 ..;;;;;..
  ':::::'
    ':`


--------- Receives from index

*/


// Decode constants, place as new constants
ENERGIZE('B1',base64_decode(MINOC('LOC')));
ENERGIZE('B2',base64_decode(MINOC('RTP')));
ENERGIZE('B3',base64_decode(MINOC('AXC')));
ENERGIZE('B4',base64_decode(MINOC('RIT')));
ENERGIZE('B5',base64_decode(MINOC('EST')));
ENERGIZE('B6',base64_decode(MINOC('ESM')));
ENERGIZE('B7',base64_decode(MINOC('NNC')));
ENERGIZE('B8',base64_decode(MINOC('PTM')));
ENERGIZE('B9',base64_decode(MINOC('PTV')));


// Optionally disable AJAX caching
if(MINOC('B3') === 'off') { $.ajaxSetup ({ cache: false }); }


//------------------> USER ACTIVITY STATE


// Init
var currentUserState = 'active';


// Has not moved mouse or clicked in x seconds
function setUserInactive() {
  currentUserState = 'recently-inactive';
}


// In long durations of inactivity, this will launch a modal
function setEnergySaver() {
  if(MINOC('B6') === 'on') {
    currentUserState = 'energy-saver';
    $('#energySaver').fadeIn(1000);
  }
}


// Main stuffs
var inactiveTimer = setTimeout(setUserInactive, MINOC('B4'));
var energySaverTimer = setTimeout(setEnergySaver, MINOC('B5'));
$('body').bind('mousedown keydown', function(event) {
  clearTimeout(inactiveTimer);
  clearTimeout(energySaverTimer);
  $('#energySaver').hide();
  currentUserState = 'active';
  inactiveTimer = setTimeout(setUserInactive, MINOC('B4'));
  energySaverTimer = setTimeout(setEnergySaver, MINOC('B5'));
});


//------------------> CONTROLLER FUNCTIONS

// Models function for interfacing with models
function models(model,method,args,affect) {
  $.ajax({
    type: "POST",
    url: MINOC('B2') + MINOC('B8'),
    data: 'type=default&method=' + method + '&args=' + args + '&model=' + model + '&nnc=' + MINOC('B7'),
    success: function(data) {

      //---> RETURNS

      // Initiates a JS redirect with page load
      if(data.indexOf("!redirect") > -1) {
        var dest = data;
        dest = dest.replace(/!redirect\s*/,'');
        window.location.href = MINOC('B2') + "/" + dest;
      }
      // A floating response that then redirects a user via page load after 3 seconds (for deletions)
      else if(data.indexOf("!resredir") > -1) {
        var resp = data;
        var url = resp.replace(/.*\[/,'');
        url = url.replace(/\].*/,'');
        var message = resp.replace(/.*\]/,'');
        $('body').append('<div class="flresp">' + message + '</div>');
        $('.flresp').fadeIn().delay(3000).queue(function(){
          window.location.href = MINOC('B2') + "/" + url;
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
    $.get(MINOC('B2') + MINOC('B9'), { url: view }, function(data){
    var viewDir   = data.view;
    var vars      = data.vars;
    var varslist  = implode(',', vars);
    if(viewDir.indexOf("!logout") > -1) {
      window.location.href = MINOC('B2') + '/';
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
      // If the user has been active within the last x seconds...
      if(currentUserState === 'active') {
        // Call database normally
        models(model,method,args,affect);
        setTimeout(poll,time);
      } else if(currentUserState === 'recently-inactive') {
        // Call database less often
        var newtime = time * 2;
        models(model,method,args,affect);
        setTimeout(poll,newtime);
      } else if(currentUserState === 'energy-saver') {
        // Don't call database at all
        setTimeout(poll,1000);
      }
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
  });
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


// Main loading function for everything, delegates URL vars
function viewLoad(viewDir, vars, varslist, affect) {

  // Prepend the root path to avoid breaking view filepaths with / URLs
  var viewDir = MINOC('B2') + "/" + viewDir;

  $(affect).fadeOut(100,function(){
    $(this).load(viewDir, function() {
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
    }).fadeIn(100);
  });
}


// .loadView
$('body').on("click", ".loadView", function() {
	var view 			= $(this).attr('data-view');
  $.get(MINOC('B2') + MINOC('B9'), { url: view }, function(data){
    var viewDir   = data.view;
    var title     = data.title;
    var address   = data.address;
    var vars      = data.vars;
    var varslist  = implode(',', vars);
    if($(this).attr('data-to')) {
      var affect  = $(this).attr('data-to');
    } else {
      var affect    = '#view-load';
    }
    if(viewDir.indexOf("!logout") > -1) {
      window.location.href = MINOC('B2') + '/';
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
  $.get(MINOC('B2') + MINOC('B9'), { url: initFlag + MINOC('B1') }, function(data){

    var viewDir   = data.view;
    var title     = data.title;
    var address   = data.address;
    var vars      = data.vars;
    var flag      = data.flag;
    var varslist  = implode(',', vars);
    var affect    = '#view-load';

    if(flag === 2) { window.location.href = MINOC('B2') + '/'; }
    else if(flag === 1) {

      // Load view into #view-load
      viewLoad(viewDir, vars, varslist, affect);

      // Force title change
      document.title = title;

      dbl = 1;
      History.pushState({state: MINOC('B1')}, title);
      dbl = 0;

    }
    else {

      // Load view into #view-load
      viewLoad(viewDir, vars, varslist, affect);

      dbl = 1;
      History.pushState({state: MINOC('B1')}, title, address);
      dbl = 0;


    }

  }, "json");

}
routeUrl();


// State router
function routeState(state) {
  $.get(MINOC('B2') + MINOC('B9'), { url: state }, function(data){
    var viewDir   = data.view;
    var title     = data.title;
    var vars      = data.vars;
    var varslist  = implode(',', vars);
    var affect    = '#view-load';
    if(viewDir.indexOf("!logout") > -1) {
      window.location.href = MINOC('B2') + '/';
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
