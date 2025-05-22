<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true)
{
    header('location:home.php');
    exit;
}

require_once "config.php";
$db = getDB();
$username = "";
$password = "";

$username_err ="";
$pw_err="";
$login_err="";

//make sure they put in a username
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // var_dump($_POST);

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter your username.";
    } else {
        $username = trim($_POST["username"]);
    }
    //make sure they put in a pw
    if (empty(trim($_POST['password']))) {
        $pw_err = "Please enter your password.";
    } else {
        $password = trim($_POST['password']);
    }
    if (empty($username_err) && empty($pw_err)) {
        $sql = "Select id, name, password from users where name = :username"; //make the statement
            if ($stmt = $db->prepare($sql)) { //preparing it to run as sql
            $stmt->bindParam(":username", $param_username);
            $param_username = trim($username);//inserting the variable into the statement securely
            if ($stmt->execute()) //executing the statement in the db
            {
                if ($stmt->rowCount() == 1) //If i get 1 row back, it means that this is a real user that exists
                {
                    //check if the pw correct
                    if ($row = $stmt->fetch()) {
                        $id = $row['id'];
                        $username = $row['name'];
                        $hashed_pw = $row['password'];
                        if (password_verify($password, $hashed_pw)) //check if the hashes match
                        {
                            //This person should be logged in!
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION['username'] = $username;
                            header('location:home.php');
                            exit;
                        } else {
                            //Password was not valid
                            $login_err = "Invalid password.";
                        }
                    } else {
                        //User was not found in the db
                        $login_err = "User not found, please register for an account.";
                    }
                } else {
                    $login_err = "Issue when querying database. Please check to see if your username is spelt correctly.";
                }
            }
        }
        unset($stmt);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="loginRegister.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Login</title>
</head>
<body>
<div class="login-register-wrapper">
    <h2>Log In</h2>
    <p class = "login-instructions">Please fill out this form to log in</p>
    <?php if(!empty($login_err)): ?>
        <div class="alert alert-danger"><?= $login_err ?></div>
    <?php endif; ?>
    <form action="login.php" method="post">
        <div class="form-group">
            <label class="username">Username</label>
            <input placeholder="Enter your username..."  type="text" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" name="username" value="<?= $username?>">
            <div class="invalid-feedback"><?= $username_err?></div>
        </div>
        <div class="form-group">
            <label class = "password">Password</label>
            <input placeholder="Enter your password..." type="password" class="form-control <?php echo (!empty($pw_err)) ? 'is-invalid' : ''; ?>"
                   name="password" value="<?= $password?>">
            <div class="invalid-feedback"><?= $pw_err?></div>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary">
        </div>
        <p>Don't have an account? <a class="link-register" href="register.php">Sign up now!</a></p>
    </form>
    <footer class="photo-creds"<small>Image by robokoboto</small>
</div>
</body>
</html>
