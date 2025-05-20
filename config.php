<?php
// DB constants
const DB_SERVER = 'localhost';
const DB_USERNAME = 'root';
const DB_PASSWORD = '';
const DB_NAME = 'quiz';

const MAX_QUESTIONS = 10; // max questions for quizzes, this variable can be changed for ease of use

function getDB() {
    // Return DB connection
    try {
        $db = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        die("Error: Could not connect. {$e->getMessage()}");
    }
}
