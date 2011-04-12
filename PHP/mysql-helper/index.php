<?

	// MySQL Helper
	//
	// A set of simple scripts to allow database creation and schema definition through PHP
	//
	// Built to work with MAMP default settings, should work on any server with proper configuration
	//
	// Running this script will cycle between creating a database and populating then showing it,
	// or deleting it if it already exists. Not particularly useful, but it's only meant to demonstrate
	// how the various functions work.
	


	// database server configuration
	include ("includes/db/config.php");
	// database schema
	include ("includes/db/schema.php");
	// some example data
	include ("includes/db/data.php");
	// common functions
	include ("includes/db/functions.php");


	// show information about the server environment
	include("includes/diagnostics/environment.php");

	// strict error reporting while debugging
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');



	// connect to db server	
	$connection = @mysql_connect ($config["host"]["name"], $config["host"]["user"], $config["host"]["password"]) or die ('Couldn\'t connect: ' . mysql_error());


		
		// create a new database
		if (createDB($connection, $config["db"]["name"]) == "") {

			// select this database
			if (mysql_select_db($config["db"]["name"])) {

				// get some information about the database environment
				include ("includes/diagnostics/databases.php");


				// create tables
				foreach ($db_schema as $table => $keys) {
					$tableResult = addTable($connection, $table, $keys);
					// if there's an error, show it
					if ($tableResult) echo $tableResult;
				}


				// populate tables
				foreach ($db_data as $table => $items) {
					$tableResult = populateTable($connection, $table, $items);
					// if there's an error, show it
					if ($tableResult) echo $tableResult;
				}


				// display the tables on screen so we can see they were created
				if ($tables = getTableList($connection, $config["db"]["name"])) {
					foreach ($tables as $id => $table) {
						printTable($connection, $table);
					}
				}


				// remove the tables we just created
				foreach ($db_schema as $table => $keys) {
					$tableResult = deleteTable($connection, $table);
					// if there's an error, show it
					if ($tableResult) echo $tableResult;
				}


			} else {
				echo "Error selecting database: " . mysql_error();
			}


		} else {

			// drop the database
			deleteDB($connection, $config["db"]["name"]);

		}


	// disconnect from db server	
	mysql_close($connection);

 

 
?>