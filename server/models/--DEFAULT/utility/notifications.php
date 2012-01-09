<?php require_once __DIR__.'/email/email.php';

class notifications {
  
  private static $company;
  private static $domain;
  private static $support;
  
  
  function __construct() {
  
    // Get general info from settings.json
  
    $getSettings = file_get_contents(__DIR__.'/../../../../settings/settings.json');
		
		if(empty($getSettings)) { echo "Error! Can't find settings file, settings.json."; }
		
		$decodeSettings = json_decode($getSettings, true);
		
		self::$company = $decodeSettings['company-name'];
		
		$domain = $decodeSettings['domain-name'];
		$parseDomain = parse_url($domain, PHP_URL_HOST);
		if($parseDomain == NULL) { self::$domain = $domain; } else { self::$domain = $parseDomain; }
		
		self::$support = $decodeSettings['support-email'];
  
  }
  
  function activation($email,$activateCode) {
    
    $subject = 'Activate your account';

		$text = 'Hi!
		
		Thank you for registering with us.
		
		Please copy this link into your browser to activate your account:
		http://'.self::$domain.'/activate~code='.$activateCode.'
		
		Thanks, and we hope you enjoy '.self::$company.'!
		
		Please contact '.self::$support.' with any questions or concerns.
		';
		
		$html = '<html><body bgcolor="#FFFFFF">
		Hi!
		<br /><br />
		Please click here to activate your account &gt;&gt;
		<a style="background: #FFC; padding: 3px 6px;" href="http://'.self::$domain.'/activate~code='.$activateCode.'">
		Confirm</a>
		<br /><br /> 
		Thanks, and we hope you enjoy '.self::$company.'!
		<br /><br />
		<i>Please contact '.self::$support.' with any questions or concerns.</i>
		</body></html>';
  
    if(email::sendMail($email,$subject,$text,$html)) { return true; } else { return false; }
  
  }
  
  function forgotPass($email,$passCode) {
    
    $subject = 'Change your password';

		$text = 'Hi!
		
		You are getting this email because you clicked "forgot password."
		
		If you didn\'t do that, please ignore this email.
		
		Please copy this link into your browser to change your password:
		http://'.self::$domain.'/change-pass~code='.$passCode.'
		
		Thanks!
		
		Please contact '.self::$support.' with any questions or concerns.
		';
		
		$html = '<html><body bgcolor="#FFFFFF">
		Hi!<br /><br />
		You are getting this email because you clicked "forgot password."
		<br /><br />
		Please click here to change your password &gt;&gt;
		<a style="background: #FFC; padding: 3px 6px;" href="http://'.self::$domain.'/change-pass~code='.$passCode.'">
		Change Password</a>
		<br /><br />
		Thanks!
		<br /><br />
		<i>Please contact '.self::$support.' with any questions or concerns.</i>
		</body></html>';
  
    if(email::sendMail($email,$subject,$text,$html)) { return true; } else { return false; }
  
  }

} ?>
