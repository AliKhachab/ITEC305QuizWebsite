<?php
require_once "config.php";
$db = getDB();

//Query to get top 10 highest scores for Pokemon Trivia
$pokemonQuery = "SELECT u.name AS user_name, s.score, q.name AS quiz_name
                 FROM scores s
                 JOIN users u ON s.user_id = u.id
                 JOIN quizzes q ON s.quiz_id = q.id
                 WHERE q.name = 'Pokemon Trivia'
                 ORDER BY s.score DESC
                 LIMIT 10";

//Query to get top 10 highest scores for Capitals of the World
$capitalsQuery = "SELECT u.name AS user_name, s.score, q.name AS quiz_name
                  FROM scores s
                  JOIN users u ON s.user_id = u.id
                  JOIN quizzes q ON s.quiz_id = q.id
                  WHERE q.name = 'Capitals of the World'
                  ORDER BY s.score DESC
                  LIMIT 10";

$pokemonRows = $db->query($pokemonQuery);
$capitalsRows = $db->query($capitalsQuery);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quiz Leaderboards</title>
    <link href="leaderboard.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container mt-4">
    <h1>Quiz Leaderboards</h1>

    <!-- Pokemon Trivia Leaderboard -->
    <div class="mb-5">
        <h2 class="mb-3">Pokemon Trivia - Top 10 Scores</h2>
        <table class="table table-primary table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">User</th>
                <th scope="col">Score</th>
            </tr>
            </thead>
            <tbody>
            <?php $counter = 1; ?>
            <?php foreach($pokemonRows as $row): ?>
                <tr>
                    <th scope="row"><?= $counter++ ?></th>
                    <td><?= htmlspecialchars($row["user_name"]) ?></td>
                    <td><?= $row["score"] ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if ($counter == 1): ?>
                <tr>
                    <td colspan="3" class="text-center text-muted">No scores available for Pokemon Trivia</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Capitals of the World Leaderboard -->
    <div class="mb-5">
        <h2 class="mb-3">Capitals of the World - Top 10 Scores</h2>
        <table class="table table-success table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">User</th>
                <th scope="col">Score</th>
            </tr>
            </thead>
            <tbody>
            <?php $counter = 1; ?>
            <?php foreach($capitalsRows as $row): ?>
                <tr>
                    <th scope="row"><?= $counter++ ?></th>
                    <td><?= htmlspecialchars($row["user_name"]) ?></td>
                    <td><?= $row["score"] ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if ($counter == 1): ?>
                <tr>
                    <td colspan="3" class="text-center text-muted">No scores available for Capitals of the World</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="home.php" class="nav-button">Take Another Quiz</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>