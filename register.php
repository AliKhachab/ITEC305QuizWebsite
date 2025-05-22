<?php
require_once "config.php";
$db = getDB();

$username = "";
$password = "";
$confirmpassword = "";

$username_err ="";
$pw_err="";
$confirm_pw_err="";
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    //Validating the username
    if(empty(trim($_POST["username"])))
    {
        $username_err = "Please enter a Username";
    }
    else if(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err="User names can only contain Letters, Numbers, and Underscore";
    }
    else
    {
        //Search the database for it
        $sql = "Select id from users where name = :username";
        if($stmt= $db->prepare($sql))
        {
            $stmt->bindParam(":username", $param_username);
            $param_username = trim($_POST["username"]);
            if($stmt->execute())
            {
                if($stmt->rowCount()==1)
                {
                    $username_err = "This username is already taken!";
                }
                else{
                    $username = trim($_POST["username"]); //If this worked, we now have a valid username saved
                }
            }
        }
        else{
            echo "oops something broke!";
        }
        unset($stmt);
    }

    //Validating Password Requirements
    if(empty(trim($_POST["password"]))){
        $pw_err = "Please enter a password";
    }
    else if(strlen(trim($_POST["password"]))<8)
    {
        $pw_err = "Your password is not long enough. Please make it 8 characters or longer.";
    }
    else
    {
        $password =trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"])))
    {
        $confirm_pw_err = "Must enter a confirmation for the pw";
    }
    else{
        $confirmpassword = $_POST["confirm_password"];
        if(!$pw_err && $confirmpassword != $password)
        {
            $pw_err = "Passwords do not match!";
        }
    }

    //Check if we have errors
    if(empty($username_err) && empty($pw_err) && empty($confirm_pw_err))
    {
        //here we can add the user into the database
        $sql = "Insert into users (name, password) VALUE (:username, :password)";
        if($stmt= $db->prepare($sql))
        {
            $stmt->bindParam(":username", $param_username);
            $stmt->bindParam(":password", $hashedpass);
            $param_username = trim($username);
            $hashedpass = password_hash($password, PASSWORD_DEFAULT);
            if($stmt->execute())
            {
                //it worked. User should be in database
                header("location: login.php");
            }
            else{
                echo "Something went wrong!";
            }
        }
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <title>Register!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="loginRegister.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<div class="login-register-wrapper">
    <h2>Sign Up</h2>
    <p>Please fill out this form to create an account</p>
    <form action="register.php" method="post">
        <div class="form-group">
            <label class="username">Username</label>
            <input placeholder="Enter your username..." type="text" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"" name="username" value="<?= $username?>"
            >
            <span class="invalid_feedback"><?= $username_err?></span>
        </div>
        <div class="form-group">
            <label class="password">Password</label>
            <input placeholder="Enter your password..." type="password" class="form-control <?php echo (!empty($pw_err)) ? 'is-invalid' : ''; ?>"
                   name="password" value="<?= $password?>">
            <span class="invalid_feedback"><?= $pw_err?></span>
        </div>
        <div class="form-group">
            <label class="confirm-password">Confirm Password</label>
            <input placeholder="Enter your password again..." type="password" class="form-control <?php echo (!empty($confirm_pw_err)) ? 'is-invalid' : ''; ?>" name="confirm_password" value="<?= $confirmpassword?>"
            >
            <span class="invalid_feedback"><?= $confirm_pw_err?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary">
        </div>
        <p>Have an account? <a class="link-register" href="login.php">Log in here!</a></p>
    </form>
    <footer class="photo-creds"<small>Image by robokoboto</small>
</div>
</body>
</html>
