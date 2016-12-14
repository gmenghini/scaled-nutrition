<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/xml; charset=utf-8">
		<title>Testing Database Connection</title>
		<link rel = "stylesheet" type = "text/css" href = "style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script type = "text/javascript" src = "index.js"> </script>
	</head>

	<body>
		<div id = "container">
			<?php

			include 'helperFunctions.php';
			$db = databaseConnect();

			//$mealNameArray = ["Breakfast", "Lunch", "Dinner", "Snacks"];	// the index of the array corresponds to the integer index of POST request
			$mealIndex = $_POST['meal_id'];
			$hiddenHeaders = ['ingredient_fk', 'ingredient_id', 'quantity_id'];

			// outline the SQL statements that will be needed to populate the table appropriately
			$sqlTemplate = "SELECT 		quantity.quantity_id,
										quantity.ingredient_fk, 
										ingredient.ingredient_id, 
										ingredient.name AS 'Ingredient',
										quantity.weight AS 'Weight (g)',
										ROUND((quantity.weight/ingredient.serving_size), 2) AS 'Servings', 
										ROUND((ingredient.calories*quantity.weight/ingredient.serving_size), 0) AS 'Calories', 
										ROUND((ingredient.fat*quantity.weight/ingredient.serving_size), 0) AS 'Fat (g)', 
										ROUND((ingredient.carbohydrates*quantity.weight/ingredient.serving_size), 0) AS 'Carbohydrates (g)', 
										ROUND((ingredient.protein*quantity.weight/ingredient.serving_size), 0) AS 'Protein (g)', 
										quantity.audio_file_url AS 'Audio'
										FROM quantity, ingredient 
										WHERE meal_id = '%meal_id%' AND quantity.ingredient_fk = ingredient.ingredient_id";

			$sqlPopulated = str_replace("%meal_id%", $mealIndex, $sqlTemplate);

			// execute the 'query' method of the $db PDO object (results a PDOStatement object)
			$stmt = $db->query($sqlPopulated);

			// execute the 'fetchAll' method of the returned PDOStatment objects
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			print "<table>";
			print "<tr>";
			printTableHeaders($stmt, $hiddenHeaders);
			
			foreach($results as $row){	// loop over each row from the quantity query
				print "<tr id=row".$row['quantity_id'].">";
				foreach($row as $key => $value){	// loop over each field in the current row
					if (in_array($key, $hiddenHeaders)){
						//print "<td style='display:none;'>".$value."</th>";
						continue;
					}
					else {
						print "<td>";
						if ($key == 'Ingredient'){
							// this is where the name of the ingredient should show up. Evaluate the ingredient query results to populate the select box
							printIngredientSelectBox($db, $row['ingredient_id'], $row['quantity_id']);
						}
						else {
							print $value;
						}
						print "</td>";
					}
				}
				print "</tr>";
			}
			print "</table>";
			print "<br><a href = index.php>Back</a>";
			?>
		</div>
	</body>
</html>