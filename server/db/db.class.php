<?php 

class db {

	public $table;
	private $mysqli;
	
	
#	function testing($stuff) { $this->query($stuff); }
	
	
	private function query($query) {

		$go = $this->mysqli;
		$result = $go->query($query);
		return $result;

	}

	function __construct($type) {

		// Match model with table according to the variables below if they have been configured
		$totable = $type.'Tbl';
		if($this->$totable != '') { $this->table = $this->$totable; } else { $this->table = $type; }

		// Connect to db
		$this->mysqli = new mysqli('localhost', 'root', 'Azztast1c!', 'jon') or die("Db connection problem.");

	}

	
	/*

			If you obscure your db table names...do it manually and add them in here
			For generating, probably going to have to inject these Tbl variables based on what tables end up being created
			(Which means you can have some automatic obscuring like no vowels or limit to 4 letters as a build option)

	*/	


	// Users (email, pass, type, and if they're activated)
	private	$usersTbl		  			=	'';
	
	// Classes of users (specialized user info)
	private $peopleTbl          = '';
	private	$businessesTbl			=	'';
	private	$nonprofitsTbl			=	''; 

	// Other
	private	$campaignsTbl				=	'';
	private	$commentsTbl				=	'';
	private	$eventsTbl					=	'';	
	private	$historyTbl					=	'';
	private	$notificationsTbl		=	'';
	private	$messagesTbl				=	'';
	private	$perksTbl						=	'';
	private	$pointsTbl					=	'';
	private	$profileTbl					=	'';
	private	$projectsTbl				=	'';
	private	$settingsTbl				=	'';
	private	$teamsTbl						=	'';


	/*
	
			Basic CRUD
			
	*/

	
	// Process query variables
	function makeTable($table) { 

		$table = strtolower($table);
		if(empty($table) || $table == 'this') { return $this->table; } elseif($table == 'user') { return 'users'; } else { return $table; } 

	}

	function makeAnd($and) { if(!empty($and)) { return 'AND '.$and; } else { return; } }
	function makeCondition($condition) { if(!empty($condition)) { return 'WHERE '.$condition; } else { return; } }
	function makeOrder($order) { if(!empty($order)) { return 'ORDER BY '.$order; } else { return; } }

	// Create
	function create($what,$condition = '',$and = '',$table = '') {
	
		$table				= $this->makeTable($table);
		$condition		= $this->makeCondition($condition);
		$and					= $this->makeAnd($and);
	
		$set = $this->query("INSERT INTO $table SET $what $condition $and");
		if($set) { return true; } else { return false; }
	
	}

	// Read
	function read($what,$condition = '',$and = '',$order = '',$table = '') {

		$table				= $this->makeTable($table);
		$condition		= $this->makeCondition($condition);
		$and					= $this->makeAnd($and);
		$order				= $this->makeOrder($order);
	
		$get = $this->query("SELECT $what FROM $table $condition $and $order");
		return $get->fetch_assoc();

	}
	
	
	    // Return entire row
	    function readAll($condition = '',$and = '',$order = '',$table = '') {
	      
	      $what = '*';
	      return $this->read($what,$condition,$and,$order,$table);
	    
	    }
	    
	    // Return number of results for a query
	    function readNum($what,$condition = '',$and = '',$order = '',$table = '') {
	
		    $this->read($what,$condition,$and,$order,$table);
		    $mysqli = $this->mysqli;
		    return $mysqli->affected_rows;

	    }
	    
	    // Return number of results for a query
	    function readNumAll($condition = '',$and = '',$order = '',$table = '') {
	
		    $this->readAll($condition,$and,$order,$table);
		    $mysqli = $this->mysqli;
		    return $mysqli->affected_rows;

	    }


	// Update
	function update($what,$condition,$and = '',$table = '') {

		$table				= $this->makeTable($table);
		$condition		= $this->makeCondition($condition);
		$and					= $this->makeAnd($and);
	
		$set = $this->query("UPDATE $table SET $what $condition $and");
		if($set) { return true; } else { return false; }

	}


			// Safe delete with update
			function archive($condition,$and = '',$table = '') {

				$what = 'archived = 1';
				$set = $this->update($what,$condition,$and,$table);
				if($set) { return true; } else { return false; }

			}
			
			// Restore
			function unarchive($condition,$and = '',$table = '') {

				$what = 'archived = 0';
				$set = $this->update($what,$condition,$and,$table);
				if($set) { return true; } else { return false; }

			}

	
	// Delete for real
	function delete($what,$condition = '',$and = '',$table = '') {

		$table				= $this->makeTable($table);
		$condition		= $this->makeCondition($condition);
		$and					= $this->makeAnd($and);

		$set = $query = $this->query("DELETE $what FROM $table $condition $and");
		if($set) { return true; } else { return false; }

	}


	/*
	
			Joins and Matches
			
			Mino uses 'uid' in every table consistently to represent the author
			
	*/


	function contentMatchUser($uid,$item,$location) {
	
		$get = $this->query("SELECT $location.$item FROM $location, users WHERE $location.uid = users.id AND users.id = $uid");
		return $get;
	
	}

	function userMatchContent($uid,$item,$location) {

		$get = $this->query("SELECT users.$item FROM users, $location WHERE $location.uid = users.id AND users.id = $uid");
		return $get;

	}

	function wildMatch($what,$table,$condition,$what2,$table2,$order = 'id ASC',$arrange = '') {

		$table				= $this->makeTable($table);
		$order				= $this->makeOrder($order);

		$all = array();

		// Grab elements to search by
		$gets = $this->read($what, $condition, false, false, $table);

		// Perform a search for each element and add results to array
		foreach($gets as $key => $value) {

			$results = $this->search($what2,$value,$order,$table2);

			foreach($results as $result) {

				array_push($all, $result);

			}

		}

		// Remove duplicate array entries
		$all = array_unique($all, SORT_REGULAR);

		// Arrange array for looping with random option
		if(empty($arrange) || strtolower($arrange) != 'random') {	return $all; } elseif(strtolower($arrange) == 'random') { return shift($all); }

	}

	function search($what,$like,$etc,$table = '') {

		$table				= $this->makeTable($table);	

		$get = $this->query("SELECT * FROM $table WHERE $what LIKE '%$like%' $etc");
    return $get->fetch_assoc();
    
	}


	/*
			
			Special fixes for Db vs. JavaScript
			
	*/
	
	
	// Convert time from HH:MM to HH:MM:SS
	function timeFix ($hhmm) {

		if(preg_match('/^\d\d:\d\d$/',$hhmm)) { $hhmmss = $hhmm.':00'; return $hhmmss; } else { return false; }

	}

} ?>
