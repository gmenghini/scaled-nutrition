<?php

	include 'helperFunctions.php';

	$db = databaseConnect($test = false);

	$quantityID = $_POST['quantity_id'];
	$newIngredientFK = $_POST['newingredient_fk'];

	$sqlChangeRecord = "UPDATE quantity SET ingredient_fk=".$newIngredientFK." WHERE quantity_id=".$quantityID;
	$query = $db->prepare($sqlChangeRecord);	// this handles escaping and some other security features. Use for best security practices
	
	if ($query->execute() === TRUE) {
		// now we query the database and print the HTML necessary to update the web page
		$hiddenHeaders = ['ingredient_fk', 'ingredient_id', 'quantity_id'];
		$sqlGetNewRecord = "SELECT 	quantity.quantity_id,
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
									WHERE quantity.quantity_id = %quantityID% AND ingredient.ingredient_id = %newIngredientFK%";
		$sqlGetNewRecord = str_replace(['%quantityID%', '%newIngredientFK%'], [$quantityID, $newIngredientFK], $sqlGetNewRecord);
		$stmt = $db->query($sqlGetNewRecord);
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($results AS $row){
			// there should only be one of these
			foreach($row as $key => $value){	// loop over each field in the current row
				if (in_array($key, $hiddenHeaders)){
					continue;
				}
				else {
					print "<td>";
					if ($key == 'Ingredient'){
						// this is where the name of the ingredient should show up. Evaluate the ingredient query results to populate the select box
						printIngredientSelectBox($db, $newIngredientFK, $quantityID);
					}
					else {
						print $value;
					}
					print "</td>";
				}
			}
		}
	} else {
   		echo "Error: " . $sql . "<br>" . $query->error;
	}
?>