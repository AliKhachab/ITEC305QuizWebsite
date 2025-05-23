<?php
require_once "config.php";
$db = getDB();

//Query to get top 10 highest scores with usernames and quiz names
$query = "SELECT u.name AS user_name, s.score, q.name AS quiz_name
              FROM scores s
              JOIN users u ON s.user_id = u.id
              JOIN quizzes q ON s.quiz_id = q.id
              ORDER BY s.score DESC
              LIMIT 10";

$rows = $db->query($query);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Top 10 Quiz Scores</title>
    <link href="leaderboard.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container mt-4">
    <h1>Top 10 Quiz Scores</h1>
    <table class="table table-primary table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">User</th>
            <th scope="col">Quiz</th>
            <th scope="col">Score</th>
        </tr>
        </thead>
        <tbody>
        <?php $counter = 1; ?>
        <?php foreach($rows as $row): ?>
            <tr>
                <th scope="row"><?= $counter++ ?></th>
                <td><?= $row["user_name"] ?></td>
                <td><?= $row["quiz_name"] ?></td>
                <td><?= $row["score"] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="home.php" class="nav-button">Take Another Quiz</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
