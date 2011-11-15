<?php 

require_once __DIR__.'/../db/db.class.php';
require_once __DIR__."/--DEFAULT/utility/responses.php";
require_once __DIR__."/--DEFAULT/utility/notifications.php";
require_once __DIR__."/--DEFAULT/security/security.php";

		$$type = new $type($type);

if(isset($_POST['type']) && isset($_POST['method']) && isset($_POST['args'])) {

    if($_POST['type'] == 'default') {
      $method = $_POST['method'];
      $args = $_POST['args'];
      echo $$type->$method($args);
    }

} else { echo responses::postModelError(); }

?>
