<?

	// create a new database
	// (assumes open connection)
 	function createDB($connection, $db) {
		$sql = "CREATE DATABASE $db";
		if (!mysql_query($sql, $connection)) {
		    return 'Error creating database: ' . mysql_error();
		}
 	}


	// drop existing database 
	// (assumes open connection)
 	function deleteDB($connection, $db) {
 		$sql = "DROP DATABASE $db";
 		if (!mysql_query($sql, $connection)) {
		    return 'Error dropping database: ' . mysql_error();
		}
	}


	// create a table within currently-selected database
	// (assumes open connection and selected db)
	function addTable($connection, $table, $keys) {
		$sql = "CREATE TABLE $table (";

		// create list of keys to add, as well as data types
		foreach ($keys as $key => $type) {
			$sql .= $key . " " . $type;
		}
		
		// add primary key, we're assuming it's id
		$sql .= "PRIMARY KEY (id)";
		$sql .= ") TYPE=innodb";
		
 		if (!mysql_query($sql, $connection)) {
 			return 'Error creating table: ' . mysql_error();
		}
	}


	// remove a table within currently-selected database
	// (assumes open connection and selected db)
	function deleteTable($connection, $table) {
		$sql = "DROP TABLE $table";
 		if (!mysql_query($sql, $connection)) {
 			return 'Error deleting table: ' . mysql_error();
		}
	}


	// get a list of all tables within currently-selected database
	// (assumes open connection and selected db)
	function getTableList($connection, $db) {
		$sql = "SHOW TABLES FROM " . $db;
		$shown = mysql_query($sql);
		if (!$shown) {
		    return null;
		} else {
			$return = array();
			while ($table = mysql_fetch_row($shown)) {
				array_push($return, $table[0]);
			}
			return $return;
		}
		
	}


	// populate a table within currently-selected database
	// (assumes open connection and selected db)
	function populateTable($connection, $table, $items) {
		foreach ($items as $id => $data) {
			
			// generate insert
			$sql = "INSERT INTO $table (";
			foreach ($data as $key => $value) {
				$sql .= $key . ", ";
			}
			$sql = trimTrailingComma($sql) . ") VALUES (";
			foreach ($data as $key => $value) {
				$sql .= "'" . addslashes($value) . "', ";
			}
			$sql = trimTrailingComma($sql) . "); ";

			// run insert
			$result = mysql_query($sql);
			if (!$result) {
				return "Error inserting data: " . mysql_error();
			}
		}
		
	}
	

	// print a table within currently-selected database to screen, mainly useful for diagnostics
	// (assumes open connection and selected db)
	function printTable($connection, $table) {
	    echo "Table: " . $table . "\n";

	    $sql = "SELECT * FROM " . $table;
			$cols = mysql_query($sql);
			if (!$cols) {
			    echo 'Error listing tables: ' . mysql_error();
			} else {
				while($row = mysql_fetch_array($cols, MYSQL_NUM)) {
					print_r($row);
		    }
			}
	}


	// trim trailing comma and remove white space from a string
	// (needed to clean up SQL generated within loops)
	function trimTrailingComma($str) {
		// kill white space
		$str = ltrim(rtrim($str));
		// remove trailing comma
		return (substr($str, 0, strlen($str) - 1));
	}
?>