<?

	// example database table records
	//
	// tips:
	// - make sure each row you use exists in schema.php
	// - no fields are required, you can leave any or all blank for any record if needed
	// - don't bother defining the id column, those are auto-generated
	//
	$db_data = array(

		// posts table
		"posts" => array(
			0 => array(
				// each
				"title" => "Test post 1",
				"date" => "2011-04-01 12:34:56",
				"url" => "http://www.example.com/test-1/",
				"text" => "This is a test post",
				"comments" => "3",
			),
			1 => array(
				"date" => "2011-04-02 18:32:55",
				"title" => "Test post 2",
				"url" => "http://www.example.com/test-2/",
				"text" => "This is another test post",
				// "comments" => "2",  --- no fields are required, you can leave any blank if needed
				"title" => "Test post 2",
			),
		),
		
		// photos table
		"photos" => array(
			0 => array(
				"src" => "http://example.com/images/test-1.jpg",
				"width" => 500,
				"height" => 350,
				"alt" => "test image"
			),		
		),
	);


?>