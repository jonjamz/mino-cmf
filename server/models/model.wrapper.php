<?php 

require_once __DIR__.'/../db/db.class.php';
require_once __DIR__."/--DEFAULT/utility/responses.php";
require_once __DIR__."/--DEFAULT/utility/notifications.php";
require_once __DIR__."/--DEFAULT/security/security.php";

		$$type = new $type($type);

if(isset($_POST['type']) && isset($_POST['method'])) {

    if($_POST['type'] == 'default') {
      $method = $_POST['method'];
      if(isset($_POST['args'])) {
        $args = $_POST['args'];
        echo $$type->$method($args);
      } else {
        echo $$type->$method();
      }
    }

} else { echo responses::postModelError(); }

?>
