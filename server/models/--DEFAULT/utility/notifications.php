<?php require_once __DIR__.'/email/email.php';

class notifications {

  public static function activation($to) {
  
    $subject = 'Activate your account';

		$text = 'Hi!
		
		Please copy this link into your browser to confirm your email with us:
		http://cartwithaheart.org/workingmemory/activation.php?id=
		
		Your account information is as follows: 
		
		E-mail Address:
		Password: 
		
		Thanks, and we hope you enjoy Working Memory!';
		
		$html = '<html><body bgcolor="#FFFFFF">
		Hi!
		<br /><br />
		Please click here to confirm your email &gt;&gt;
		<a style="background: #FFC; padding: 3px 6px;" href="http://cartwithaheart.org/workingmemory/activation.php?id=' . $theid . '">
		Confirm</a>
		<br /><br />
		Your account information is as follows: 
		<br /><br />
		E-mail Address:  <br />
		Password: 
		<br /><br /> 
		Thanks, and we hope you enjoy Working Memory!
		</body></html>';
  
    if(email::sendMail($to,$subject,$text,$html)) { return true; } else { return false; }
  
  }

} ?>
