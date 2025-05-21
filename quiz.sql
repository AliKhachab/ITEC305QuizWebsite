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
    (45, 'Montreal', 15, 0);