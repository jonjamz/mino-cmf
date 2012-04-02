<?php require_once "Mail.php"; require_once "Mail/mime.php";


class email {
     
  public static function sendMail($to,$subject,$text,$html) {    
    	
        $crlf = "\n";
        $headers = array(
                      		'From' => 'No Reply <passthru@relayer.co>',
                     		  'To' =>  $to,
                      		'Subject' => $subject
                    		);

        // Create mime message
        
        $mime = new Mail_mime($crlf);

        // Set email body
        
        $mime->setTXTBody($text);
        $mime->setHTMLBody($html);

        $body = $mime->get();
        $headers = $mime->headers($headers);

        // Send email
        
        $smtp = Mail::factory('smtp',array(
                                            'host' => 'ssl://smtp.googlemail.com',
                                            'port' => '465',
                                            'auth' => true,
                                            'username' => 'passthru@relayer.co',   // Gmail user name
                                            'password' => ''  //  Gmail password
                                          ));
                                          
 		$mail = $smtp->send($to, $headers, $body);
 		
		if (PEAR::isError($mail)) {
		
    	return false;
    	
    } else {
		
		  return true;
		
    }
  
  }

}

?>
