<?php 

  /* 
      This file is referenced by every view. It passes a $type variable to the controller loader,
      which contains the name of the view, and the loader connects it with the corresponding
      controller and model.
  */

?>

<!-- Controller -->
<script type="text/javascript">
$(document).ready(function() {
    
		<?php require_once __DIR__.'/../controllers/controller.loader.php'; ?>

});
</script>
