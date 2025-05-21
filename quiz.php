<?php // sql queries to actually grab questions and make the quiz


require_once "config.php";
$db = getDB();

function getQuestions($numQuestions, $selected_quiz_type) {
    $questions_assoc_array = array();
    $sql = "SELECT id, text FROM questions WHERE quiz_id = :selected_quiz_type";
}

$questions = getQuestions(MAX_QUESTIONS);
?>
<!doctype html>
<html lang="en">
<head>
    <title>Quiz</title>
</head>
<body>

</body>
</html>
