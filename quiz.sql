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
    (1, "What is the capital of Mexico?", 1 ),
    (2, "What is the capital of Lebanon?", 1),
    (3, "What is the capital of Egypt?", 1),
    (4, "What is the capital of Colombia?", 1),
    (5, "What is the capital of Guatemala?", 1),
    (6, "What is the capital of the Dominican Republic?", 1),
    (7, "What is the capital of France?", 1),
    (8, "What is the capital of Jamaica?", 1),
    (9, "What is the capital of the Maldives?", 1),
    (10, "What is the capital of Spain?",1);
