<?php

  session_start();

  /*******************************************************************

      View Router

      This is where you control the security and naming of views

      Also where the URL is parsed

      Don't put the same view in more than one array!

  *******************************************************************/

  // Doesn't require __DIR__ because the locations go to js for referencing
  $viewDir = "client/views/";


  // Universally accessible
  $uViews = array(


    // Default
    "about"       => "--DEFAULT/about.html",
    "help"        => "--DEFAULT/help.html",
    "terms"       => "--DEFAULT/terms.html",
    "contact"     => "--DEFAULT/contact.html",
    "uploads"     => "--DEFAULT/uploads.html"


    // Project

  );


  // Only when logged out
  $oViews = array(


    // Default
    "landing"     => "--DEFAULT/landing.html",
    "activate"    => "--DEFAULT/authorization/activate.html",
    "change-pass" => "--DEFAULT/authorization/forgot.html",
    "login"       => "--DEFAULT/authorization/login.html",
    "register"    => "--DEFAULT/authorization/register.html"


    // Project

  );


  // Only when logged in
  $iViews = array(


    // Default
    "dashboard"   => "--DEFAULT/user/dashboard.html",
    "settings"    => "--DEFAULT/user/settings.html",
    "profile"     => "--DEFAULT/user/profile.html",
    "mypage"      => "mypage.html"

    // Project

  );


  /*
      Parse URL...

      ************

      Flags:

        0 - just to start, should never be passed through
        1 - everything is ok, continue
        2 - init state, do not push a state with History API or Hash
  */


  // Prepare vars (URL me, baby!)
  $urlMe    = $_GET["url"];
  $urlArgs  = array();
  $flag     = 0;

  // Check for initialize flag
  if(substr($urlMe, 0, 5) == '!init') {
    $urlMe = str_replace('!init', '', $urlMe);
    $flag = 1;
  }

  // If there is nothing (it's the index) route to logged in or out home page
  if($urlMe == 'emptyVar') {

    if(isset($_SESSION['id'])) {

      $view = 'dashboard';

    } else {

      $view = 'landing';

     }

  // For every other case...
  } else {

    if(preg_match('/~/', $urlMe) != 0) {

      // Separate URL args from page name and create $view
      $url = explode('~', $urlMe);
      $view = $url[0];

      // Check if there is more than one variable.
      if(preg_match('/,/', $url[1]) != 0) {

        // Split up variables by &
        $args = explode(',', $url[1]);

      } else {

        $args = array($url[1]);

      }

      // Assign args to an array
      foreach($args as $arg) {

        // If there's an equals sign, go associative!
        if(preg_match('/=/', $arg) != 0) {

          $kv = explode('=', $arg);
          $urlArgs[$kv[0]] = $kv[1];

        }

        // If there is no equals sign, go numeric!
        elseif(preg_match('/=/', $arg) === 0) {

          $urlArgs[] = $arg;

        }

      }

    } else {

      $view = $urlMe;

#      if($view == 'logout') {
#
#        $view = 'landing';
#
#      }

    }

  }


  /*
      Now that we have split up view and variables, we process for the right view.
      The above should have created $view.
  */


    if(isset($uViews[$view])) {

      $viewLoc = $viewDir.$uViews[$view];

    } elseif(isset($oViews[$view])) {

      if(isset($_SESSION['id'])) {

        $viewLoc = $viewDir.$iViews['dashboard'];

      } else {

        $viewLoc = $viewDir.$oViews[$view];

      }

    } elseif(isset($iViews[$view])) {

      if(isset($_SESSION['id'])) {

        $viewLoc = $viewDir.$iViews[$view];

      } else {

        // If they're logged out and trying to load a logged in page, this flag will redirect them out
        $viewLoc = '!logout';

      }

    } else {


      /*
          When $view doesn't match any existing views...

          Here you can do a fallback where if the page doesn't exist, check if there's a matching username
          and load in the person's profile. Or a 404!
      */

      // Modify init flag to perform a full redirect in the controller
      if($flag === 1) { $flag = 2; }

      if(isset($_SESSION['id'])) {

        $viewLoc = $viewDir.$iViews['dashboard'];
        $view = 'dashboard';

      } else {

        $viewLoc = $viewDir.$oViews['landing'];
        $view = 'landing';

      }

    }


  /*
      Now we have the view name, the view file location, and the url variables.
      We just have to put these into usable JSON format to return.
  */


  // Create title with capitalized first letter and remove anything up to the last slash
  if($flag === 1) {

    $view = preg_replace('/^.*(\\/)/', '', $view);
    $title = ucfirst($view);

  } else {

    $title = preg_replace('/^.*(\\/)/', '', $view);
    $title = ucfirst($title);

  }

  // Process address
  if(!isset($address)) { $address = $view; }

  // Create array for encoding
  $final = array(

                    "view"    => $viewLoc,
                    "title"   => $title,
                    "address" => $address,
                    "vars"    => $urlArgs,
                    "flag"    => $flag

  );

  // JSON-encode the array and return it
  echo json_encode($final);

?>
