<?php
session_start();
if(!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]) {
    header("location:index.php");
    exit;
}

require_once "config.php";
$db = getDB();

if (!isset($_POST['quiz_id']) || empty($_POST)) {
    header("location:home.php");
    exit;
}

$quiz_id = $_POST['quiz_id'];
$quiz_name = $_POST['quiz_name'];

function getQuestionAndAnswers($question_id, $database) {
    $sql = "SELECT q.text as question_text, a.id as answer_id, a.text as answer_text, a.is_correct 
            FROM questions q 
            JOIN answers a ON q.id = a.question_id 
            WHERE q.id = :question_id";
    try {
        if ($stmt = $database->prepare($sql)) {
            $stmt->bindParam(":question_id", $question_id);
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

// Process the quiz results
$results = array();
$total_questions = 0;
$correct_answers = 0;

// Loop through POST data to find all question answers
foreach ($_POST as $key => $value) {
    if (strpos($key, 'question_') === 0) {
        $question_id = str_replace('question_', '', $key);
        $selected_answer_id = $value;

        // Get question and all its answers from database
        $question_data = getQuestionAndAnswers($question_id, $db);

        if (!empty($question_data)) {
            $question_text = $question_data[0]['question_text'];
            $user_answer = '';
            $correct_answer = '';
            $is_correct = false;

            // Find the user's selected answer and the correct answer
            foreach ($question_data as $answer) {
                if ($answer['answer_id'] == $selected_answer_id) {
                    $user_answer = $answer['answer_text'];
                    $is_correct = ($answer['is_correct'] == 1);
                }
                if ($answer['is_correct'] == 1) {
                    $correct_answer = $answer['answer_text'];
                }
            }

            // Add to results array
            $results[] = array(
                'question' => $question_text,
                'user_answer' => $user_answer,
                'correct_answer' => $correct_answer,
                'is_correct' => $is_correct
            );

            $total_questions++;
            if ($is_correct) {
                $correct_answers++;
            }
        }
    }
}

// Calculate grade (out of 10)
$grade_percentage = ($total_questions > 0) ? round(($correct_answers / $total_questions) * 100, 1) : 0;

function updateBestScore($user_id, $quiz_id, $score, $db) {
    // check if user has a score already. if they do, update it. if they do not, put their score in the db.
    $sql = "SELECT score FROM scores WHERE user_id = :user_id AND quiz_id = :quiz_id";
    try {
        if ($stmt = $db->prepare($sql)) {
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":quiz_id", $quiz_id);
            if ($stmt->execute()) {
                if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // get the row if it exists
                    $update_sql = "UPDATE scores SET score = :score WHERE user_id = :user_id AND quiz_id = :quiz_id";
                    if ($update_stmt = $db->prepare($update_sql)) {
                        $update_stmt->bindParam(":user_id", $user_id);
                        $update_stmt->bindParam(":quiz_id", $quiz_id);
                        $update_stmt->bindParam(":score", $score);
                        if (!$update_stmt->execute()) {
                            throw new PDOException("Error updating your score in the database.");
                        }
                    } else {
                        throw new PDOException("Error preparing to update your score in the leaderboard.");
                    }
                } else { // row doesn't exist, insert into table as it's the user's only high score
                    $insert_score_sql = "INSERT INTO scores (user_id, quiz_id, score) VALUES (:user_id, :quiz_id, :score)";
                    if ($insert_stmt = $db->prepare($insert_score_sql)) {
                        $insert_stmt->bindParam(":user_id", $user_id);
                        $insert_stmt->bindParam(":quiz_id", $quiz_id);
                        $insert_stmt->bindParam(":score", $score);
                        if (!$insert_stmt->execute()) {
                            throw new PDOException("Error inserting your score into the database.");
                        }
                    } else {
                        throw new PDOException("Prepare insertion to scoreboard error.");
                    }
                }
            } else {
                throw new PDOException("Database execution error.");
            }
        } else {
            throw new PDOException("Database preparation error.");
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

updateBestScore($_SESSION['id'], $_POST['quiz_id'], $correct_answers, $db);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results - <?= htmlspecialchars($quiz_name) ?></title>
    <link rel="stylesheet" href="result.css">
</head>
<body>
<div class="results-container">
    <h1>Quiz Results</h1>
    <div class="quiz-title"><?= htmlspecialchars($quiz_name) ?></div>

    <div class="grade-summary">
        <h2>Your Score</h2>
        <div class="grade-score"><?= $correct_answers ?> / <?= $total_questions ?></div>
        <div class="score-breakdown"><?= $grade_percentage ?>% Correct</div>
    </div>

    <div class="results-section">
        <h3>Question Results:</h3>

        <?php foreach ($results as $index => $result): ?>
            <div class="question-result <?= $result['is_correct'] ? 'correct' : 'incorrect' ?>">
                <div class="status-icon <?= $result['is_correct'] ? 'correct' : 'incorrect' ?>">
                </div>

                <div class="question-text">
                    Question <?= $index + 1 ?>: <?= htmlspecialchars($result['question']) ?>
                </div>

                <div class="answer-line user-answer">
                    <strong>You answered:</strong> <?= htmlspecialchars($result['user_answer']) ?>
                </div>

                <?php if (!$result['is_correct']): ?>
                    <div class="answer-line correct-answer">
                        <strong>Correct answer:</strong> <?= htmlspecialchars($result['correct_answer']) ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="navigation">
        <a href="home.php" class="nav-button">Take Another Quiz</a>
        <a href="leaderboard.php" class="nav-button">Leaderboard</a>
    </div>
</div>
</body>
</html>