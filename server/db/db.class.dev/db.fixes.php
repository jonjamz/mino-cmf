<?php

	// Database-specific requirements

	function timeFix ($hhmm) {
	
		if(preg_match('/^\d\d:\d\d$/',$hhmm)) {
		
			$hhmm = $hhmm.':00';
			return $hhmm;
		
		} else { return false; }
	
	}

?>
