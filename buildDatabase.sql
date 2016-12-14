
DROP TABLE IF EXISTS meal;
DROP TABLE IF EXISTS quantity;
DROP TABLE IF EXISTS ingredient;

CREATE TABLE meal (
	meal_id INT PRIMARY KEY,
	meal_date DATE,
	meal_time TIME,
	user_id INT
) ENGINE=INNODB;

CREATE TABLE quantity (
	quantity_id INT NOT NULL AUTO_INCREMENT,
	meal_id INT,
	ingredient_fk INT NOT NULL REFERENCES ingredient(ingredient_id),
	weight DECIMAL(5,2),
	audio_file_url VARCHAR(50),
	PRIMARY KEY (quantity_id)
) ENGINE=INNODB;
ALTER TABLE quantity AUTO_INCREMENT=10;


CREATE TABLE ingredient (
	ingredient_id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(25),
	serving_size DECIMAL(5, 2),
	calories DECIMAL(5, 2),
	fat DECIMAL(5, 2),
	carbohydrates DECIMAL(5, 2),
	protein DECIMAL(5, 2),
	PRIMARY KEY (ingredient_id)
) ENGINE=INNODB;
ALTER TABLE ingredient AUTO_INCREMENT=101;

INSERT INTO meal (meal_id, meal_date, meal_time, user_id) VALUES 
	(0, '2016-11-10', '08:31', 1), (1, '2016-11-10', '12:45', 1), (2, '2016-11-10', '17:50', 1), (3, '2016-11-10', null, 1);

-- breakfast ingredients
INSERT INTO ingredient (name, serving_size, calories, fat, carbohydrates, protein) VALUES ('egg', 28.0, 43, 3, 0, 4);
SELECT @last := LAST_INSERT_ID();
INSERT INTO quantity (meal_id, ingredient_fk, weight, audio_file_url) VALUES (0, @last, 200, null);

INSERT INTO ingredient (name, serving_size, calories, fat, carbohydrates, protein) VALUES ('sweet onion', 100.0, 32, 0, 8, 1);
SELECT @last := LAST_INSERT_ID();
INSERT INTO quantity (meal_id, ingredient_fk, weight, audio_file_url) VALUES (0, @last, 100, null);

INSERT INTO ingredient (name, serving_size, calories, fat, carbohydrates, protein) VALUES ('sweet potatoes', 200, 180, 0, 41, 4);
SELECT @last := LAST_INSERT_ID();
INSERT INTO quantity (meal_id, ingredient_fk, weight, audio_file_url) VALUES (0, @last, 150, null);

INSERT INTO ingredient (name, serving_size, calories, fat, carbohydrates, protein) VALUES ('avocado', 100, 167, 15, 8, 2);
SELECT @last := LAST_INSERT_ID();
INSERT INTO quantity (meal_id, ingredient_fk, weight, audio_file_url) VALUES (0, @last, 150, null);


-- lunch ingredients
INSERT INTO ingredient (name, serving_size, calories, fat, carbohydrates, protein) VALUES ('coconut milk', 226, 45, 4, 1, 0);
SELECT @last := LAST_INSERT_ID();
INSERT INTO quantity (meal_id, ingredient_fk, weight, audio_file_url) VALUES (1, @last, 150, null);

INSERT INTO ingredient (name, serving_size, calories, fat, carbohydrates, protein) VALUES ('peanut butter', 32, 190, 16, 8, 7);
SELECT @last := LAST_INSERT_ID();
INSERT INTO quantity (meal_id, ingredient_fk, weight, audio_file_url) VALUES (1, @last, 75, null);

INSERT INTO ingredient (name, serving_size, calories, fat, carbohydrates, protein) VALUES ('kale', 130, 36, 1, 7, 2);
SELECT @last := LAST_INSERT_ID();
INSERT INTO quantity (meal_id, ingredient_fk, weight, audio_file_url) VALUES (1, @last, 50, null);

INSERT INTO ingredient (name, serving_size, calories, fat, carbohydrates, protein) VALUES ('banana', 225, 200, 1, 51, 2);
SELECT @last := LAST_INSERT_ID();
INSERT INTO quantity (meal_id, ingredient_fk, weight, audio_file_url) VALUES (1, @last, 100, null);


-- dinner ingredients
INSERT INTO ingredient (name, serving_size, calories, fat, carbohydrates, protein) VALUES ('broccoli', 100, 35, 0, 7, 2);
SELECT @last := LAST_INSERT_ID();
INSERT INTO quantity (meal_id, ingredient_fk, weight, audio_file_url) VALUES (2, @last, 50, null);

INSERT INTO ingredient (name, serving_size, calories, fat, carbohydrates, protein) VALUES ('quinoa', 42, 160, 2.5, 30, 6);
SELECT @last := LAST_INSERT_ID();
INSERT INTO quantity (meal_id, ingredient_fk, weight, audio_file_url) VALUES (2, @last, 150, null);

INSERT INTO ingredient (name, serving_size, calories, fat, carbohydrates, protein) VALUES ('red pepper', 100, 28, 0, 7, 1);
SELECT @last := LAST_INSERT_ID();
INSERT INTO quantity (meal_id, ingredient_fk, weight, audio_file_url) VALUES (2, @last, 50, null);

INSERT INTO ingredient (name, serving_size, calories, fat, carbohydrates, protein) VALUES ('yellow squash', 180, 36, 1, 8, 2);
SELECT @last := LAST_INSERT_ID();
INSERT INTO quantity (meal_id, ingredient_fk, weight, audio_file_url) VALUES (2, @last, 50, null);

/*
Meals
* breakfast
    * 200g eggs
    * 100g sweet onions
    * 150g sweet potatoes
    * 150g avocado
* lunch
    * 150g coconut milk
    * 75g peanut butter
    * 50g kale
    * 100g banana
    * 50g avocado	-- STILL NEED TO MANAGE REPEAT INGREDIENTS
* dinner
    * 50g brocoli
    * 150g quinoa
    * 50g red pepper
    * 50g sweet onions	-- STILL NEED TO MANAGE REPEAT INGREDIENTS
    * 50g yellow squash 
*/
