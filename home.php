<?php
session_start();
if(!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]) {
    header("location:index.php");
    exit;
}
require_once "config.php";
$db = getDB();
$quizzes = array();
try {
    $sql = "SELECT id, name FROM quizzes";
    $stmt = $db->prepare($sql);
    if ($stmt->execute()) {
        // $quizzes = fetch all the rows from the statement
        //... continue from here
    } else {
        throw new PDOException("Statement didn't execute.");
    }
} catch (PDOException $e) {
    die("Error getting quiz data. ".$e->getMessage());
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="home.css" rel="stylesheet">
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
            <a class="btn btn-info" role="button">First quiz</a>
            <a class="btn btn-info" role="button">Second quiz</a>
            <!-- change these buttons so that it reads quiz names from the above array we pulled using the sql query-->
        </div>
    </div>
</body>
</html>
