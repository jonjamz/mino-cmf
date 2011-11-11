<?php 

	function createDb($name) { // Guessing right now that I will never use this but it's there...

		$set = $this->query("CREATE DATABASE IF NOT EXISTS `$name`");
		if(empty($set)) { return false; } else { return true; }

	}

	function createTable($name) {

		$set = $this->query("CREATE TABLE IF NOT EXISTS `$name` (`id` bigint(20) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`))");
		if(empty($set)) { return false; } else { return true; }

	}

	function addColumn($table,$column,$type) {

		$set = $this->query("SHOW COLUMNS FROM `$table` LIKE '%$column%'");
		if(empty($set)) {
		
			$set = $this->query("ALTER TABLE `$table` ADD COLUMN `$column` $type");
			if(empty($set)) { return false; } else { return true; }

		}

	}

?>
