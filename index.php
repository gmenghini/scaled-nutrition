<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/xml; charset:utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Scaled Nutrition</title>
		<link rel = "stylesheet" type = "text/css" href = "index-style.css">
	</head>

	<body>
		<header class = "header">
			<h1 class = "headerFont">Scaled Nutrition</h1>
		</header>

		<main class = "container">
			<section class = "leftContainer">
				<section class = "calendar">
					<img class = "image calendarImage" src = "img/calendar.png" alt = "Calendar to select data display range"/>
				</section>

				<section class = "lineGraph">
					<img class = "image lineGraphImage" src = "img/line-graph.png" alt = "Line graph displaying macros over selected range"/>
				</section>
			</section>

			<section class = "rightContainer">
				<section class = "barGraph">
					<img class = " barGraphImage" src = "img/bar-chart.png" alt = "Bar chart displaying macros over selected range vs. average"/>
					<select class = "barGraphSelect" >
						<option selected>Calories</option>
						<option>Macronutrients</option>
						<option>Micronutrients</option>
					</select>
				</section>

				<section class = "pieChart">
					<img class = "pieChartImage" src = "img/pie-chart.png" alt = "Pie chart displaying nutritional breakdown per meal."/>
					<select class = "pieChartSelect" >
						<option selected>Calories</option>
						<option>Fat (g)</option>
						<option>Carbs (g)</option>
						<option>Protein (g)</option>
					</select>
				</section>

				<section class = "tableSection">

				<?php

				include 'helperFunctions.php';
				
				$db = databaseConnect();

				$mealNameArray = ["Breakfast", "Lunch", "Dinner"];	// the index of the array corresponds to the integer index of POST request
				$totalCalories = 0;
				$totalFat = 0;
				$totalCarbohydrates = 0;
				$totalProtein = 0;

				$queryTemplate = "SELECT quantity.meal_id, SUM(quantity.weight/ingredient.serving_size*ingredient.calories) AS 'Calories', SUM(quantity.weight/ingredient.serving_size*ingredient.fat) AS 'Fat (g)', SUM(quantity.weight/ingredient.serving_size*ingredient.carbohydrates) AS 'Carbohydrates (g)', SUM(quantity.weight/ingredient.serving_size*ingredient.protein) AS 'Protein (g)' FROM quantity, ingredient WHERE quantity.meal_id = %meal_id% AND quantity.ingredient_fk = ingredient.ingredient_id";

				print <<<HERE
					<table class = "tableDisplay">
						<tr>
							<th>Meal</th>
							<th>Calories</th>
							<th>Fat (g)</th>
							<th>Carbs (g)</th>
							<th>Protein (g)</th>
						</tr>
HERE;

				for($i = 0; $i < count($mealNameArray); $i++) {
					$queryPopulated = str_replace("%meal_id%", $i, $queryTemplate);
					$stmt = $db->query($queryPopulated);
					$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

					foreach($results as $row) {
						print "<tr>";
						foreach($row as $key => $value){
							print "<td>";
							if ($key == 'meal_id') {
								//print $mealNameArray[$row[$key]];
								print "<form method='post' action='showrecipe.php'>";
								print "<button type='submit' name='meal_id' value=".$row[$key]." class='link-button'>";
								print $mealNameArray[$row[$key]];
								print "</button>";
								print "</form>";
							}
							else {
								print round($row[$key], 0);
							}
							if ($key == 'Calories') {
								$totalCalories += $row[$key];
							}
							if ($key == 'Fat (g)') {
								$totalFat += $row[$key];
							}
							if ($key == 'Carbohydrates (g)') {
								$totalCarbohydrates += $row[$key];
							}
							if ($key == 'Protein (g)') {
								$totalProtein += $row[$key];
							}							
							print "</td>";
						}
						print "</tr>";
					}
				}
				print "<tr>";
				print "<td></td>";
				print "<td><strong>".round($totalCalories, 0)."</strong></td>";
				print "<td><strong>".round($totalFat, 0)."</strong></td>";
				print "<td><strong>".round($totalCarbohydrates, 0)."</strong></td>";
				print "<td><strong>".round($totalProtein, 0)."</strong></td>";
				print "</tr>";
				print "</table>";
				?>
				</section>
			</section>
		</main>

		<footer class = "footer">
			(C) Scaled Nutrition 2016
		</footer>
	</body>
</html>