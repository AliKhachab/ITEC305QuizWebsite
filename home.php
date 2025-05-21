<?php
session_start();
if(!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]) {
    header("location:index.php");
    exit;
}
require_once "config.php";
$db = getDB();

try {
    $sql = "SELECT id, name FROM quizzes";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("No quizzes exist " . $e->getMessage());
}



// maybe we route to quiz select? maybe this is quiz select? it depends...
// if we are doing one quiz, style it different, but for two quizzes we need a form to pick. also potentially check if the user has a score and display their highest score?
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Home</title>
</head>
<body>
<div class="btn-toolbar" role="toolbar">
    <div class="btn-group me-2" role="group" aria-label="First group">
        <a class="btn btn-danger" role="button" href="logout.php">Log out</a>
    </div>
    <div class="btn-group me-2" role="group" aria-label="Second group">
        <?php foreach($quizzes as $quiz): ?>
            <a class="btn btn-info" role="button" href="quiz.php?id=<?= $quiz['id'] ?>">
                <?= $quiz['name'] ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>