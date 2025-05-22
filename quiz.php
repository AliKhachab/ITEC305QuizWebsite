<?php
session_start();
if(!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]) {
    header("location:index.php");
    exit;
}

require_once "config.php";
$db = getDB();

if (!isset($_POST['quiz_id'])) {
    header("location:home.php");
    exit;
}

$quiz_id = $_POST['quiz_id'];

function getRandomQuestions($quiz_id, $database) {
    $questions_array = array();
    $sql = "SELECT id, text FROM questions WHERE quiz_id = :quiz_id ORDER BY RAND() LIMIT 10";
    try {
        if ($stmt = $database->prepare($sql)) {
            $stmt->bindParam(":quiz_id", $quiz_id);
            if ($stmt->execute()) {
                $questions_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new PDOException("Database execute error");
            }
        } else {
            throw new PDOException("SQL preparation error");
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
    return $questions_array;
}

function getAnswersForQuestion($question_id, $database) {
    $answers_array = array();
    $sql = "SELECT id, text, is_correct FROM answers WHERE question_id = :question_id ORDER BY RAND()";
    try {
        if ($stmt = $database->prepare($sql)) {
            $stmt->bindParam(":question_id", $question_id);
            if ($stmt->execute()) {
                $answers_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new PDOException("Database execute error");
            }
        } else {
            throw new PDOException("SQL preparation error");
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
    return $answers_array;
}

function getQuizName($quiz_id, $database) {
    $sql = "SELECT name FROM quizzes WHERE id = :quiz_id";
    try {
        if ($stmt = $database->prepare($sql)) {
            $stmt->bindParam(":quiz_id", $quiz_id);
            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result['name'];
            } else {
                throw new PDOException("Database execute error");
            }
        } else {
            throw new PDOException("SQL preparation error");
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

// Get the quiz data
$quiz_name = getQuizName($quiz_id, $db);
$questions = getRandomQuestions($quiz_id, $db);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($quiz_name) ?> - Quiz</title>
    <link rel="stylesheet" href="quiz.css">
</head>
<body>
<div class="quiz-container">
    <a href="home.php" class="back-link">&larr; Back to Quiz Selection</a>

    <h1><?= htmlspecialchars($quiz_name) ?></h1>

    <form action="results.php" method="post">
        <?php foreach ($questions as $index => $question): ?>
            <div class="question">
                <h3>Question <?= $index + 1 ?>: <?= htmlspecialchars($question['text']) ?></h3>

                <div class="answers">
                    <?php
                    $answers = getAnswersForQuestion($question['id'], $db);
                    foreach ($answers as $answer):
                        ?>
                        <div class="answer">
                            <label>
                                <input type="radio"
                                       name="question_<?= $question['id'] ?>"
                                       value="<?= $answer['id'] ?>"
                                       required>
                                <?= htmlspecialchars($answer['text']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Hidden fields to pass quiz data to results.php -->
        <input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">
        <input type="hidden" name="quiz_name" value="<?= htmlspecialchars($quiz_name) ?>">

        <div class="submit-container">
            <input type="submit" value="Submit Quiz" class="submit-btn">
        </div>
    </form>
</div>
</body>
</html>