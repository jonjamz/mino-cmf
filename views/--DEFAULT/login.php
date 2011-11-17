<?php $type = basename(__FILE__, '.php'); require_once __DIR__.'/../view.wrapper.php'; ?>

<form class="dbForm" data-model="login" data-method="login">
  <p>
  Email: <br><input name="email" type="email" required="required">
  </p><p>
  Password: <br><input name="pass" type="password" required="required">
  <br>
  <a href="#" data-reveal-id="forgot">Forgot password?</a>
  </p><p>
  <input type="submit" value="login">
  </p>
</form>

<div id="forgot" class="reveal-modal">
<form class="dbForm" data-model="login" data-method="forgot">
    <h1>Forgot Password</h1>
    <p>
    Enter the email associated with your account:<br>
    <input type="email" name="email" required="required">
    </p><p>
    <input type="submit" value="submit">
    </p>
    <a class="close-reveal-modal">&#215;</a>
</form>
</div>
