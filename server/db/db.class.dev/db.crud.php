<?php 

	// Basic CRUD


	// Process query variables
	function makeTable($table) { 

		$table = strtolower($table);
		if(empty($table) || $table == 'this') { return $this->table; } elseif($table == 'user') { return 'users'; } else { return $table; } 

	}

	function makeAnd($and) { if(!empty($and)) { return 'AND '.$and; } else { return; } }
	function makeWhere($condition) { if(!empty($condition)) { return 'WHERE '.$condition; } else { return; } }
	function makeOrder($order) { if(!empty($order)) { return 'ORDER BY '.$order; } else { return; } }

	// Create
	function create($what,$table,$condition,$and) {
	
		$table				= $this->makeTable;
		$condition		= $this->makeCondition($condition);
		$and					= $this->makeAnd($and);
	
		$set = $this->query("INSERT INTO $table SET $what $condition $and");
		if($set) { return true; } else { return false; }
	
	}

	// Read
	function read($what,$table,$condition,$and,$order) {

		$table				= $this->makeTable;
		$condition		= $this->makeCondition($condition);
		$and					= $this->makeAnd($and);
		$order				= $this->makeOrder($order);
	
		$get = $this->query("SELECT $what FROM $table $condition $and $order");
		return $get;

	}

	// Update
	function update($what,$table,$condition,$and) {

		$table				= $this->makeTable;
		$condition		= $this->makeCondition($condition);
		$and					= $this->makeAnd($and);
	
		$set = $this->query("UPDATE $table SET $what $condition $and");
		if($set) { return true; } else { return false; }

	}


			// Safe delete with update
			function archive($table,$condition,$and) {

				$what = 'archived = 1';
				$set = $this->update($what,$table,$condition,$and);
				if($set) { return true; } else { return false; }

			}
			
			// Restore
			function unarchive($table,$condition,$and) {

				$what = 'archived = 0';
				$set = $this->update($what,$table,$condition,$and);
				if($set) { return true; } else { return false; }

			}

	
	// Delete for real
	function delete($what,$table,$condition,$and) {

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
		$gets = $this->query("SELECT $what FROM $table WHERE $condition");
	
		// Perform a search for each element and add results to array
		foreach($gets as $get) {
	
			$results = $this->search($table2,$what2,$get,$order);
		
			foreach($results as $result) {

				array_push($all, $result);

			}

		}

		// Remove duplicate array entries
		$all = array_unique($all, SORT_REGULAR);

		// Arrange array for looping with random option
		if(empty($arrange) || strtolower($arrange) != 'random') {	return $all; } elseif(strtolower($arrange) == 'random') { return shift($all); }

	}

	function search($table,$what,$like,$etc) {

		$table				= $this->makeTable($table);	
	
		return $this->query("SELECT * FROM $table WHERE $what LIKE '%$like%' $etc");

	}

?>