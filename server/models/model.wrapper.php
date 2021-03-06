<?php

// Make sure nonce is sent, otherwise abort
// If it's the public API, don't require a nonce

session_start();

if(!isset($api)) {
  
  if(!isset($_POST['nnc']) || (isset($_POST['nnc']) && $_POST['nnc'] != $_SESSION['nonce'])) {
    die("Fail.");
  }
  
}

require_once __DIR__.'/../db.php';
require_once __DIR__."/utility/responses.php";
require_once __DIR__."/utility/notifications.php";
require_once __DIR__."/utility/security.php";

		$$type = new $type($type);

if(isset($_POST['type']) && isset($_POST['method'])) {

    if($_POST['type'] == 'default') {
      $method = $_POST['method'];
      if(isset($_POST['args']) && strpos($_POST['args'],',') != false) {
        $args = explode(',', $_POST['args']);
        echo call_user_func_array(array($$type, $method), $args);
      } elseif(isset($_POST['args']) && strpos($_POST['args'],',') === false) {
        $arg = $_POST['args'];
        echo $$type->$method($arg);
      } else {
        echo $$type->$method();
      }
    }

} else { echo responses::postModelError(); }

?>
