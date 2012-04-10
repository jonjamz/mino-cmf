<?php 

$type = "searches"; 
require_once __DIR__."/model.wrapper.php"; 

class searches {

  // Properties
	private static $db;

	// Methods
	function __construct() {

		self::$db				= new db('users');

	}
	
	function search($value) {
	
	  $results = self::$db->s('username, email','email',$value);
	  if($results) {
	    $send = '';
	
	    $send .= '<ul>';
	    foreach($results as $row) {
	      $send .= '<li>Username: '.$row['username'].' / Email: '.$row['email'].'</li>';
	    }
	    $send .= '<ul>';
	    
	    echo $send;
	  } else { echo "No results."; }
	}

} ?>