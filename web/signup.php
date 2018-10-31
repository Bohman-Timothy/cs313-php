<?php
session_start();
include 'teach07_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    //Compare passwords
    /*if ($passwordMatches == true) {

    }*/

// Get input from user
    $username = cleanInput($_POST["username"]);
    $password = cleanInput($_POST["password"]);

    // Hash the password
    $passwordHash = password_hash('$password', PASSWORD_DEFAULT);

// Insert password
    $statement = $db->prepare('INSERT INTO user_info (username, password) VALUES (:user, :pass)');
    $statement->execute(array(':user' => $username, ':pass' => $passwordHash));

// Go to sign in screen
    header('Location: signin.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign-Up</title>
</head>
<body>
<h1>Sign-Up</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="signUpForm">
    <h2>Enter login information</h2>
    <label for="username">Username:</label>
    <input type="text" name="username" id="username"><br/>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password"><br/>
    <input type="submit" value="Submit"><br/>
</form>
</body>
</html>
