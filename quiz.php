<?php // sql queries to actually grab questions and make the quiz
session_start();
if(!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]) {
    header("location:index.php");
    exit;
}

require_once "config.php";
$db = getDB();

if (!isset($_POST['quiz_id'])) {
    die("A quiz must be selected please return to the homepage.");
}


$quiz_id = intval($_POST['quiz_id']);


function getQuestions($numQuestions, $selected_quiz_type) {
    $questions_assoc_array = array();


    $sql = "SELECT id, text FROM questions WHERE quiz_id = :selected_quiz_type";



    return $questions_assoc_array;
}

$questions = getQuestions(MAX_QUESTIONS, 1);
?>
<!doctype html>
<html lang="en">
<head>
    <title>Quiz</title>
</head>
<body>

</body>
</html>
