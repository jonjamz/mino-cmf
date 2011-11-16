<?php $type = basename(__FILE__, '.php'); require_once __DIR__.'/../view.wrapper.php'; ?>

<form class="dbForm" data-model="login" data-method="login">
  <p>
  Email: <br><input name="email" type="email" required="required">
  </p><p>
  Password: <br><input name="pass" type="password" required="required">
  </p>
  <input type="submit" value="login">
</form>
<div id="show"></div>
