<?php // sql queries to actually grab questions and make the quiz
session_start();
if(!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]) {
    header("location:index.php");
    exit;
}

require_once "config.php";
$db = getDB();

function getQuestions($numQuestions, $selected_quiz_type, $database) {
    $questions_assoc_array = array();
    $sql = "SELECT id, text FROM questions WHERE quiz_id = :selected_quiz_type";
    try {
        if ($stmt = $database->prepare($sql)) {
            $stmt->bindParam(":selected_quiz_type", $_POST['quiz_id']);
            if ($stmt->execute()) {
                $questions_assoc_array = $stmt->fetch_all(PDO::FETCH_ASSOC);
            } else {
                throw new PDOException("Database execute error");
            }
        } else {
            throw new PDOException("SQL preparation error");
        }
    } catch (PDOException $e) {
        die("Database error. ".$e->getMessage());
    }
    return $questions_assoc_array;
}

$questions = getQuestions(MAX_QUESTIONS, 1, $db);


?>
<!doctype html>
<html lang="en">
<head>
    <title>Quiz</title>
</head>
<body>
    <h1>Quiz</h1>
    <?= print_r($questions); ?>
</body>
</html>
