<?php

  session_start();

  /*******************************************************************

      View Router

      This is where you control the security and naming of views

      Also where the URL is parsed

      Don't put the same view in more than one array!

  *******************************************************************/


  /* OPTIONS
   * ========================== */


  // Doesn't require __DIR__ because the locations go to js for referencing
  $viewDir = "client/views/";


  // Turn on 404 page? Answers "yes" or "no"
  $is404 = "yes";


  // Turn on automatic titles? Answers "yes" or "no"
  $isTitles = "no";


  /* ROUTES
   * ========================== */


  // Universally accessible
  $uViews = array(

    "company"     => array("title" => "Company", "location" => "--DEFAULT/company.html", "parent" => ""),
      "company/about"       => array("title" => "About Us", "location" => "--DEFAULT/about.html", "parent" => "company"),
      "company/help"        => array("title" => "Help", "location" => "--DEFAULT/help.html", "parent" => "company"),
      "company/terms"       => array("title" => "Terms", "location" => "--DEFAULT/terms.html", "parent" => "company"),
      "company/contact"     => array("title" => "Contact Us", "location" => "--DEFAULT/contact.html", "parent" => "company"),
    "uploads"     => array("title" => "Uploads", "location" => "--DEFAULT/uploads.html", "parent" => ""),
    "404"         => array("title" => "404 Error -- File Not Found", "location" => "--DEFAULT/404.html", "parent" => "")

  );


  // Only when logged out
  $oViews = array(

    "home"        => array("title" => "Welcome Home", "location" => "--DEFAULT/home.html", "parent" => ""),
      "register"    => array("title" => "Registration Page", "location" => "--DEFAULT/authorization/register.html", "parent" => "home"),
    "activate"    => array("title" => "Activate Your Account", "location" => "--DEFAULT/authorization/activate.html", "parent" => ""),
    "change-pass" => array("title" => "Change Your Password", "location" => "--DEFAULT/authorization/forgot.html", "parent" => ""),
    "login"       => array("title" => "Login Page", "location" => "--DEFAULT/authorization/login.html", "parent" => "")

  );


  // Only when logged in
  $iViews = array(

    "dashboard"   => array("title" => "Dashboard", "location" => "--DEFAULT/user/dashboard.html", "parent" => ""),
    "settings"    => array("title" => "Account Settings", "location" => "--DEFAULT/user/settings.html", "parent" => "dashboard"),
    "profile"     => array("title" => "Profile", "location" => "--DEFAULT/user/profile.html", "parent" => "dashboard"),
    "mypage"      => array("title" => "My Page", "location" => "mypage.html", "parent" => "dashboard")

  );


  /*
      Parse URL...

      ************

      Flags:

        0 - normal
        1 - init state
        2 - init state with a bad URL, must hard redirect to avoid file path issues
  */


  // Prepare vars (URL me, baby!)
  $urlMe    = $_GET["url"];
  $urlArgs  = array();
  $flag     = 0;
  $parent   = "";
  $title    = "";

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

          $view = 'home';

        }

  // For every other case...
  } else {

    // First check for URL arguments
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

    }
  }


  /*
      Now that we have split up view and variables, we process for the right view.
      The above should have created $view.
  */

  function createViewInfo($view, $flag, $viewDir, $uViews, $iViews, $oViews, $is404, $isTitles) {

    if(isset($uViews[$view])) {

      // Location
      $viewLoc = $viewDir.$uViews[$view]['location'];

      // Parent
      $parent = $uViews[$view]['parent'];

      // Title
      $title = $uViews[$view]['title'];

    } elseif(isset($oViews[$view]['location'])) {

        if(isset($_SESSION['id'])) {

          // Redirect out/in
          $flag = 2;
          $viewLoc = "!log";

        } else {

          $viewLoc = $viewDir.$oViews[$view]['location'];
          $parent = $oViews[$view]['parent'];
          $title = $oViews[$view]['title'];

        }

    } elseif(isset($iViews[$view])) {

        if(isset($_SESSION['id'])) {

          $viewLoc = $viewDir.$iViews[$view]['location'];
          $parent = $iViews[$view]['parent'];
          $title = $iViews[$view]['title'];

        } else {

          // Redirect out/in
          $viewLoc = '!log';

        }

    } else {


      /*
          When $view doesn't match any existing views...404
      */


      // Modify init flag to perform a full redirect in the controller. If 404 mode is enabled, go to 404
      if($flag === 1) {

        // These are handled differently by the controller, so they send a different type of response
        $flag = 2;
        if($is404 == "yes") { $viewLoc = "/404"; } elseif($is404 == "no") { $viewLoc = "/"; }

      } elseif($flag === 0) {

          if(isset($_SESSION['id'])) {

              if($is404 == "yes") {

                $view = '404';
                $viewLoc = $viewDir.$uViews['404']['location'];
                $title = $viewDir.$uViews['404']['title'];

              } else {

                $view = 'dashboard';
                $viewLoc = $viewDir.$iViews['dashboard']['location'];
                $title = $viewDir.$iViews['dashboard']['title'];

              }

          } else {

              if($is404 == "yes") {

                $view = '404';
                $viewLoc = $viewDir.$uViews['404']['location'];
                $title = $viewDir.$uViews['404']['title'];

              } else {

                $view = 'home';
                $viewLoc = $viewDir.$oViews['home']['location'];
                $title = $viewDir.$oViews['home']['title'];

              }
          }
      }
    }


    /*
        Now we have the view name, the view file location, and the url variables.
        We just have to put these into usable JSON format to return.
    */

    if($isTitles == "yes") {


        if(isset($view)) {

          $title = preg_replace('/^.*(\\/)/', '', $view);
          $title = ucfirst($title);

        } else {

          // This is when flag is 2, doesn't matter but I guess we should return something
          $title = ' ';

        }

    } else {

        if($flag === 2) {

          $title = ' ';

        }
    }


    // Put in an array
    return  array(
                      "view"    => $viewLoc,
                      "title"   => $title,
                      "address" => $view,
                      "flag"    => $flag,
                      "parent"  => $parent
    );

  }


  // Create view info
  $firstView = createViewInfo($view, $flag, $viewDir, $uViews, $iViews, $oViews, $is404, $isTitles);

  // Deal with parents
  if($firstView['parent'] != "") {

    // Have to run this through the above function again
    $firstParent = createViewInfo($firstView['parent'], $flag, $viewDir, $uViews, $iViews, $oViews, $is404, $isTitles);

    // Create array for encoding
    $final = array(

                      "parent"  => $firstParent,
                      "view"    => $firstView,
                      "vars"    => $urlArgs

                  );

  } else {

    $final = array(

                      "view"    => $firstView,
                      "vars"    => $urlArgs

                  );

  }


  // JSON-encode the array and return it
  echo json_encode($final);

?>
