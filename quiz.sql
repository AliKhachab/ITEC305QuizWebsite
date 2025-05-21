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
    (2, 'Quiz 2 Temp Name');

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
    (15, 'What is the capital of Canada?', 1);

INSERT INTO answers
VALUES
    (1, 'Mexico City', 1, true),
    (2, 'Guadalajara', 1, false),
    (3, 'Monterrey', 1, false),


    (4, 'Beirut', 2, true),
    (5, 'Sidon', 2, false),
    (6, 'Tyre', 2, false),

    (7, 'Cairo', 3, true),
    (8, 'Luxor', 3, false),
    (9, 'Giza', 3, false),

    (10, 'Bogota', 4, true),
    (11, 'Medellin', 4,false),
    (12, 'Cali', 4, false),

    (13,'Guatemala City', 5, true),
    (14, 'Quetzaltenango', 5, false),
    (15, 'Antigua Guatemala', 5, false),

    (16, 'Santo Domingo', 6, true),
    (17, 'Santiago', 6, false),
    (18,'Punta Cana', 6, false),


    (19,'Paris', 7 , true),
    (20, 'Lille', 7, false),
    (21,'Nice', 7, false),

    (22, 'Kingston', 8, true),
    (23, 'Portmeo City', 8, false),
    (24, 'Monetgo Bay', 8, false),

    (25, 'Malé', 9, true),
    (26, 'Maldives City', 9, false),
    (27, 'The Maldives', 9, false),

    (28, 'Madrid', 10, true),
    (29, 'Barcelona', 10, false),
    (30, 'Seville', 10, false),

    (31, 'Washington DC', 11, true),
    (32, 'New York', 11, false),
    (33, 'Virginia', 11, false),

    (34, 'Rome', 12, true),
    (35, 'Sicilly', 12, false),
    (36, 'Vatican City', 12, false),

    (37, 'Istanbul', 13, true),
    (38,'İzmir', 13, false),
    (39,'Antalya', 13, false),

    (40, 'Seoul', 14, true),
    (41, 'Busan', 14, false),
    (42, 'Ulsan', 14, false),

    (43, 'Ottawa', 15, true),
    (44,'Toronto', 15, false),
    (45, 'Montreal', 15, false);
