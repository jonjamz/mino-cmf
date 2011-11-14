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
    
    var type = "<?php echo $type; ?>";
    var modelDir = "<?php echo __DIR__.'/../server/models/'.$type.'.php' ?>";
		<?php require_once __DIR__.'/../controllers/controller.loader.php'; ?>

});
</script>
