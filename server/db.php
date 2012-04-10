<?php


/* This class substitutes mysqli as far as we use it and returns everything as false */

class emptyc {

  function query($x) {
    return false;
  }
  
  function real_escape_string($x) {
    return '';
  }

}

/* This is the mysqli-based db class */

class db {

	public  $table;
	private $mysqli;
	// Table obscuring *nameTbl is checked in constructor
	private	$usersTbl		  			=	'';
	
	
	/* Highest-level methods */
  
  // Create
	public function c($x) {
	  $args = func_get_args();
	  $go   = call_user_func_array(array($this, "create"), $args);
	  return $go;
	}
	
	// Read
	public function r($x) {
	  $args = func_get_args();
	  $go   = call_user_func_array(array($this, "read"), $args);
	  return $go;
	}
	
	// Update
	public function u($x) {
	  $args = func_get_args();
	  $go   = call_user_func_array(array($this, "update"), $args);
	  return $go;
	}
	
	// Delete
	public function d($x) {
	  $args = func_get_args();
	  $go   = call_user_func_array(array($this, "delete"), $args);
	  return $go;
	}
	
	// Archive
	public function a($x) {
	  $args = func_get_args();
	  $go   = call_user_func_array(array($this, "archive"), $args);
	  return $go;
	}
	
	// Search
	public function s($x) {
	  $args = func_get_args();
	  $go   = call_user_func_array(array($this, "search"), $args);
	  return $go;
	}
	
	// Wild Match
	public function wm($x) {
	  $args = func_get_args();
	  $go   = call_user_func_array(array($this, "wildMatch"), $args);
	  return $go;
	}
	
	// Content Match User ID
	public function cmu($x) {
	  $args = func_get_args();
	  $go   = call_user_func_array(array($this, "contentMatchUser"), $args);
	  return $go;
	}
	
	// User ID Match Content
	public function umc($x) {
	  $args = func_get_args();
	  $go   = call_user_func_array(array($this, "userMatchContent"), $args);
	  return $go;
	}
	

	/* Foundation */
	
	private function query($query) {
		$go = $this->mysqli;
		$result = $go->query($query);
		if($result) { return $result; } 
		else { return false; }
	}
	
	function escape($string) {
	
	  $go = $this->mysqli;
	  $result = $go->real_escape_string($string);
	  return $result;
	
	}

	function __construct($type,$install = false) {
		// Match model with table according to the variables below if they have been configured
		$totable = $type.'Tbl';
		if($this->$totable != '') { $this->table = $this->$totable; } else { $this->table = $type; }
    // Location of settings file
    $setLoc = __DIR__.'/../settings/settings.json';
    // Check existence of settings file, and if it's not install mode, echo error and instantiate emptyc
    if(file_exists($setLoc)) {
      // Get db info from settings.json
      $getSettings = file_get_contents($setLoc);
      // If it's not empty, instantiate mysqli, otherwise instantiate emptyc
      if(!empty($getSettings)) {
        // Decode settings.json into a PHP array
        $settings = json_decode($getSettings, true);
		    // Instantiate object-oriented mysqli into a local property
		    $this->mysqli = new mysqli(
		                                 $settings['db-host'], 
		                                 $settings['db-user'], 
		                                 $settings['db-pass'], 
		                                 $settings['db-name']
		                              )
		                                 or die ("Db connection problem.");
      } 
      else { $this->mysqli = new emptyc(); }
    } 
    else { 
      if($install == false) { 
        echo "Error! Can't find settings file, settings.json.";
        $this->mysqli = new emptyc();
      } 
      else { $this->mysqli = new emptyc(); } 
    }
	}


  /* Create databases and tables */

  // Make a new database
	function createDb($name) {
		$set = $this->query("CREATE DATABASE IF NOT EXISTS `$name`");
		if($set) { echo "Db '$name' created."; } 
		else { echo "Problem creating Db '$name'."; }
	}
	
	// Make a table
	function createTable($name) {
		$set = $this->query("CREATE TABLE IF NOT EXISTS `$name` (`id` bigint(20) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`))");
		if($set) { echo "Table '$name' created."; } 
		else { echo "Problem creating table '$name'."; }
	}

	// Add a column safely (in case they build multiple times)
	function createColumn($table,$column,$type) {
		$set = $this->query("SELECT $column FROM $table");
		if(!$set) {
			$go = $this->query("ALTER TABLE `$table` ADD COLUMN `$column` $type");
			if($go) { echo "Column '$column' created in table '$table'!"; } 
			else { echo "There was an error creating column '$column' in table '$table'."; }
		} 
		else { echo "Column '$column' exists! Check table '$table' and try again."; }
	}


	/* Basic CRUD */

	// Process query variables
	function makeTable($table) { 
		$table = strtolower($table);
		if(empty($table) || $table == 'this') { return $this->table; } 
		elseif($table == 'user') { return 'users'; } 
		else { return $table; } 
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
		if($set) { return true; } 
		else { return false; }
	}

	// Read, general associative
	function read($what,$condition = '',$and = '',$order = '',$table = '',$etc = '') {
		$table				= $this->makeTable($table);
		$condition		= $this->makeCondition($condition);
		$and					= $this->makeAnd($and);
		$order				= $this->makeOrder($order);
	  $get = $this->query("SELECT $what FROM $table $condition $and $order $etc");
	  if ($get) {
	    if ($get->num_rows === 1) { return $get->fetch_assoc(); } 
	    else {
		    while($row = $get->fetch_assoc()) { $all[] = $row; }
        return $all;
      }
    } 
    else { return false; }
	}
	
	    // Return entire row
	    function readAll($condition = '',$and = '',$order = '',$table = '') {
	      $what = '*';
	      return $this->read($what,$condition,$and,$order,$table);
	    }
	    
	    // Return number of results for a query
	    function readNum($what,$condition = '',$and = '',$order = '',$table = '') {
		    $this->read($what,$condition,$and,$order,$table);
		    $go = $this->mysqli;
		    return $go->affected_rows;
	    }
	    
	    // Return number of results for a query
	    function readNumAll($condition = '',$and = '',$order = '',$table = '') {
		    $this->readAll($condition,$and,$order,$table);
		    $go = $this->mysqli;
		    return $go->affected_rows;
	    }

	// Update
	function update($what,$condition,$and = '',$table = '') {
		$table				= $this->makeTable($table);
		$condition		= $this->makeCondition($condition);
		$and					= $this->makeAnd($and);
		$set = $this->query("UPDATE $table SET $what $condition $and");
		if($set) { return true; } 
		else { return false; }

	}

			// Safe delete with update
			function archive($condition,$and = '',$table = '') {
				$what = 'archived = 1';
				$set = $this->update($what,$condition,$and,$table);
				if($set) { return true; } 
				else { return false; }
			}
			
			// Restore
			function unarchive($condition,$and = '',$table = '') {
				$what = 'archived = 0';
				$set = $this->update($what,$condition,$and,$table);
				if($set) { return true; } 
				else { return false; }
			}
	
	// Delete for real
	function delete($what,$condition = '',$and = '',$table = '') {
		$table				= $this->makeTable($table);
		$condition		= $this->makeCondition($condition);
		$and					= $this->makeAnd($and);
		$set = $query = $this->query("DELETE $what FROM $table $condition $and");
		if($set) { return true; } 
		else { return false; }
	}


	/* Joins and Matches -- I believe this section still needs some work */


	function contentMatchUser($uid,$item,$location) {
		$get = $this->query("SELECT $location.$item FROM $location, users WHERE $location.uid = users.id AND users.id = $uid");
		if($get) {
	    if($get->num_rows === 1) { 
	      return $get->fetch_assoc();
	    } 
	    else {
		    while($row = $get->fetch_assoc()) { $all[] = $row; }
        return $all;
      }
    } 
    else { return false; }
	}

	function userMatchContent($uid,$item,$location) {
		$get = $this->query("SELECT users.$item FROM users, $location WHERE $location.uid = users.id AND users.id = $uid");
		if($get) {
	    if($get->num_rows === 1) { 
	      return $get->fetch_assoc();
	    } 
	    else {
		    while($row = $get->fetch_assoc()) { $all[] = $row; }
        return $all;
      }
    } 
    else { return false; }
	}

	function wildMatch($what,$table,$condition,$cols,$what2,$table2,$order = 'id ASC',$arrange = '') {
		$table				= $this->makeTable($table);
		$order				= $this->makeOrder($order);
		$all = array();
		// Grab single column of elements to search by
		$gets = $this->read($what, $condition, false, false, $table);
		// Perform a search for each element and add results to array
		foreach($gets as $get) {
			$results = $this->search($cols,$what2,$get[$what],$order,$table2);
			foreach($results as $result) {
				array_push($all, $result);
			}
		}
		// Remove duplicate array entries
		$all = array_unique($all, SORT_REGULAR);
		// Arrange array for looping with random option
		if(empty($arrange) || strtolower($arrange) != 'random') {	return $all; } 
		elseif(strtolower($arrange) == 'random') { return shift($all); }
	}

	function search($cols,$what,$like,$etc = '',$table = '') {
		$table = $this->makeTable($table);	
		$get = $this->query("SELECT $cols FROM $table WHERE $what LIKE '%$like%' $etc");
    if($get) {
	    if($get->num_rows === 1) { 
	      $all[] = $get->fetch_assoc();
	      return $all;
	    } 
	    else {
		    while($row = $get->fetch_assoc()) { $all[] = $row; }
        return $all;
      }
    } 
    else { return false; }
	}

} ?>
