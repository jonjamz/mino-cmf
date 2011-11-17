<?php $type = basename(__FILE__, '.php'); require_once __DIR__.'/../view.wrapper.php'; ?>

<form class="dbForm" data-model="forgot" data-method="forgot">
<input type="hidden" name="passCode" value="<?php echo $passCode; ?>">
<p>
Enter new password:<br>
<input type="password" name="newPass1" required="required">
</p><p>
Re-enter new password:<br>
<input type="password" name="newPass2" required="required">
</p><p>
<input type="submit" value="change password">
</p>
</form>
