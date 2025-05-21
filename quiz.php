<?php // sql queries to actually grab questions and make the quiz
session_start();

if(!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]) {
    header("location.index.php");
    exit;
}

require_once "config.php";
$db = getDB();

if(!isset($_GET['id'])){
    die("Quiz not found or Invalsid Quiz ID");
}

?>

<!doctype html>
<html lang="en">
<head>
    <title></title>
</head>
<body>

</body>
</html>