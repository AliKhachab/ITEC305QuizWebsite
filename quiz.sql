/* CREATE DATABASE */
DROP DATABASE IF EXISTS quiz;
CREATE DATABASE quiz;
USE quiz;

/* CREATE TABLES */
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(32) DEFAULT NULL,
    password VARCHAR(60) DEFAULT NULL
);

DROP TABLE IF EXISTS quizzes;
CREATE TABLE quizzes (
    id INT UNSIGNED NOT NULL PRIMARY KEY,
    name VARCHAR(32) NOT NULL
);

DROP TABLE IF EXISTS questions;
CREATE TABLE questions (
    id INT UNSIGNED NOT NULL PRIMARY KEY,
    text VARCHAR(64) NOT NULL,
    quiz_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id)
);

DROP TABLE IF EXISTS answers;
CREATE TABLE answers (
    id INT UNSIGNED NOT NULL PRIMARY KEY,
    text VARCHAR(64) NOT NULL,
    question_id INT UNSIGNED NOT NULL,
    is_correct INT NOT NULL,
    FOREIGN KEY (question_id) REFERENCES questions(id)
);

DROP TABLE IF EXISTS scores;
CREATE TABLE scores (
    user_id INT UNSIGNED NOT NULL,
    quiz_id INT UNSIGNED NOT NULL,
    score INT UNSIGNED NOT NULL,
    PRIMARY KEY(user_id, quiz_id)
);

/* CREATE QUIZZES */

INSERT INTO quizzes
VALUES
    (1, 'Capitals of the World'),
    (2, 'Pokemon Trivia');

/* CREATE SAMPLE QUESTIONS*/

INSERT INTO questions
VALUES
    (1, 'What is the capital of Mexico?', 1 ),
    (2, 'What is the capital of Lebanon?', 1),
    (3, 'What is the capital of Egypt?', 1),
    (4, 'What is the capital of Colombia?', 1),
    (5, 'What is the capital of Guatemala?', 1),
    (6, 'What is the capital of the Dominican Republic?', 1),
    (7, 'What is the capital of France?', 1),
    (8, 'What is the capital of Jamaica?', 1),
    (9, 'What is the capital of the Maldives?', 1),
    (10, 'What is the capital of Spain?',1),
    (11, 'What is the capital of the United States?', 1),
    (12, 'What is the capital of Italy?', 1),
    (13, 'What is the capital of Turkey?', 1),
    (14, 'What is the capital of South Korea?', 1),
    (15, 'What is the capital of Canada?', 1),

    (16, 'What trainer owns Garchomp?',2),
    (17, 'What region is the Pokemon Rayquaza from?',2),
    (18, 'What was the first Pokemon Video Game to be featured on the Nintendo DS?', 2),
    (19,'What is the Pokemon that had no weaknesses in the Pokemon Black and White Series?',2),
    (20, 'What regions does the game Pokemon Stadium 2 Feature?', 2),
    (21, 'What was the first Pokemon to be designed?', 2),
    (22, 'What company owns the Pokemon franchise?', 2),
    (23, 'What was the first Pokemon TCG set released?',2),
    (24, 'What Pokemon is the ace of Lance in Pokemon HeartGold/SoulSilver?',2),
    (25, 'What typing was introduced in Generation 6 (X/Y) ?', 2),
    (26, 'What typing does Sceptile earn when Mega Evolving', 2),
    (27,'What typing does Ampharaos earn when Mega Evolving', 2),
    (28, 'What TM can be earned by trading in a RageCandyBar?', 2),
    (29, 'What move can be learned in the Illex Forest', 2),
    (30, 'Which Pokemon is the paradox version of Salamance?', 2);

INSERT INTO answers
VALUES
    (1, 'Mexico City', 1, 1),
    (2, 'Guadalajara', 1, 0),
    (3,'Tijuana', 1, 0),

    (4, 'Beirut', 2, 1),
    (5, 'Tripoli', 2, 0),
    (6, 'Sidon', 2, 0),

    (7, 'Cairo', 3, 1),
    (8, 'Alexandria', 3, 0),
    (9, 'Giza', 3, 0),

    (10, 'Bogota', 4, 1),
    (11, 'Medellin', 4, 0),
    (12, 'Cali', 4, 0),

    (13, 'Guatemala City', 5, 1),
    (14, 'Quetzaltenango', 5, 0),
    (15, 'Escuintla', 5, 0),

    (16, 'Santo Domingo', 6, 1),
    (17, 'Punta Cana', 6, 0),
    (18, 'La Romana', 6, 0),

    (19, 'Paris', 7, 1),
    (20, 'Lyon', 7, 0),
    (21, 'Nice', 7, 0),

    (22, 'Kingston', 8, 1),
    (23, 'Montego Bay', 8, 0),
    (24, 'Spanish Town', 8, 0),

    (25, 'Malé', 9, 1),
    (26, 'Addu City', 9, 0),
    (27, 'Fuvahmulah', 9, 0),

    (28, 'Madrid', 10, 1),
    (29, 'Barcelona', 10, 0),
    (30, 'Seville', 10, 0),

    (31, 'Washington, D.C.', 11, 1),
    (32, 'New York City', 11, 0),
    (33, 'Virginia', 11, 0),

    (34, 'Rome', 12, 1),
    (35, 'Milan', 12, 0),
    (36, 'Sicilly', 12, 0),

    (37, 'Antalya', 13, 1),
    (38, 'Istanbul', 13, 0),
    (39, 'Izmir', 13, 0),

    (40, 'Seoul', 14, 1),
    (41, 'Busan', 14, 0),
    (42, 'Incheon', 14, 0),

    (43, 'Ottawa', 15, 1),
    (44, 'Toronto', 15, 0),
    (45, 'Montreal', 15, 0),

    (46, 'Cynthia', 16,1),
    (47, 'Blue', 16, 0),
    (48, 'Falkner', 16,0),

    (49, 'Hoenn', 17, 1),
    (50, 'Johto', 17, 0),
    (51, 'Sinnoh', 17, 0),

    (52,'Pokemon Diamond and Pearl', 18, 1),
    (53,'Pokemon Crystal', 18, 0),
    (54, 'Pokemon Black and White 2', 18, 0),

    (55,'Eelektross', 19, 1),
    (56,'Reshriam', 19, 0),
    (57, 'Kyurem', 19, 0),

    (58, 'Kanto/Johto', 20, 1),
    (59, 'Kanto/Hoenn', 20, 0),
    (60, 'Johto/Hoenn', 20, 0),

    (61, 'Rhydon', 21, 1),
    (62, 'Pikachu', 21, 0),
    (63, 'Mewtwo', 21, 0),

    (64, 'Nintendo', 22, 1),
    (65, 'Square Enix', 22, 0),
    (66, 'Sega', 22,0),

    (67, 'Base Set', 23, 1),
    (68, 'Jungle', 23, 0),
    (69, 'Fossil', 23, 0),

    (70, 'Dragonite', 24, 1),
    (71, 'Charizard', 24, 0),
    (72, 'Salamance', 24, 0),

    (73, 'Fairy', 25, 1),
    (74, 'Air', 25,0),
    (75, 'Dark', 25, 0),

    (76, 'Dragon', 26, 1),
    (77, 'Ground', 26, 0),
    (78, 'Fire', 26, 0),

    (79, 'Dragon', 27,1),
    (80, 'Fire', 27, 0),
    (81, 'Dark', 27,0),

    (82, 'TM64 Explosion', 28, 1),
    (83, 'TM12 Taunt', 28, 0),
    (84, 'TM36 Sludge Bomb', 28, 0),

    (85,'Headbutt', 29, 1),
    (86, 'Hydro Pump', 29,0),
    (87,'Future Sight', 29, 0),

    (88, 'Roaring Moon', 30, 1),
    (89, 'Iron Valiant', 30, 0),
    (90, 'Flutter Mane', 30, 0)

