<?php require_once __DIR__.'/email/email.php';

class notifications {
  
  private static $company;
  private static $domain;
  private static $support;
  
  
  function __construct() {
  
    $getSettings = file_get_contents(__DIR__.'/../../../../settings.json');
		
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
		http://'.self::$domain.'/?activate='.$activateCode.'
		
		Thanks, and we hope you enjoy '.self::$company.'!
		
		Please contact '.self::$support.' with any questions or concerns.
		';
		
		$html = '<html><body bgcolor="#FFFFFF">
		Hi!
		<br /><br />
		Please click here to activate your account &gt;&gt;
		<a style="background: #FFC; padding: 3px 6px;" href="http://'.self::$domain.'/?activate='.$activateCode.'">
		Confirm</a>
		<br /><br /> 
		Thanks, and we hope you enjoy '.self::$company.'!
		<br /><br />
		<i>Please contact '.self::$support.' with any questions or concerns.</i>
		</body></html>';
  
    if(email::sendMail($email,$subject,$text,$html)) { return true; } else { return false; }
  
  }

} ?>
