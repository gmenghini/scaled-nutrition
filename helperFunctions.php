<?php
	function databaseConnect($test = false){
		// connects to the appropriate database
		// return value: PDO object
		$HTTP_HOST = $_SERVER['HTTP_HOST'];
		$credentials = parse_ini_file("../config.ini");
		$host = $credentials['host'];
		$dbname = $credentials['dbname'];
		try {
			if ($HTTP_HOST == "localhost") { // connect to the XAMMP database
				$user = $credentials['testUsername'];
				$password = $credentials['testPassword'];
			}
			else {	// connect to the Host Gator database
				$user = $credentials['user'];
				$password = $credentials['password'];
			}
			// regardless of which database: tell PDO that we want to throw exceptions for every error
			$db = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8mb4', $user, $password);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $db;
		} catch(PDOException $e){
			die('Could not connect to the database:<br/>' . $e);
		}
	}	

	function printTableHeaders($stmt, $hide) {
		// $stmt: PDOStatement object
		// $hide: an array of the header titles to hide
		// action: print the HTML table headers using the field names of $stmt
		for ($i = 0; $i <$stmt->columnCount(); $i++) {
			$col = $stmt->getColumnMeta($i);
			if (in_array($col['name'], $hide)){
				print "<th style='display:none;'>".$col['name']."</th>";
			}
			else {
				print "<th>".$col['name']."</th>";
			}
		}
	}

	function audioFile(){
		if ($value != null) {
			print "<audio id='audio_play'>";
			print "<source src='audio/".$value."' type='audio/mpeg'/>";
			print "</audio>";
			print <<<HERE
			<img src = 'img/volume_icon.png' height = '25' width = '25' alt = 'volume_icon.png' onClick='javascript:document.getElementById("audio_play").play(); return false;'/>
HERE;
		}
		else {
			print "";
		}
	}

	function printIngredientSelectBox($db, $foreignKey, $quantityPK){
		// $query: string of intended SQL query
		// $db: connection to the database
		// $foreignKey: the foreign key column of quantity table, referencing a primary key of the ingredient table
		// $quantityPK: 
		// action: print the select box in the 'ingredient' field of every meal quantity entry
		// need to know the class and/or ID of the select box
		// need to know what the selected index is
		$selectedIngredientFound = false;

		$sqlIngredientQuery = "SELECT ingredient_id, name FROM ingredient";
		$stmt = $db->query($sqlIngredientQuery);
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		print "<form id = 'quantity".$quantityPK."Form' method = 'post' action = 'changeMealIngredient.php'>";
		print "<select id =".$quantityPK." onchange = 'makePostRequest()'>";

		foreach($results as $row){
			foreach($row as $rowKey => $value) {
				if ($rowKey == 'ingredient_id' and $value == $foreignKey) {
				// this is our believe ingredient for the current row. make it the selected option
					$selectedIngredientFound = true;
				}
				if ($rowKey == 'name') {
					if ($selectedIngredientFound == true) {
						print "<option selected value=".$row['ingredient_id'].">".$value."</option>";
						$selectedIngredientFound = false;
					}
					else {
						print "<option value=".$row['ingredient_id'].">".$value."</option>";
					}
				}
			}
		}
		print "</select>";
		print "</form>";
	}

?>