<?php
include 'teach07_functions.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
// Get input from user
    $username = cleanInput($_POST["username"]);
    $password = cleanInput($_POST["password"]);

    $statement = $db->prepare('SELECT id, password FROM user_info WHERE username=:user');
    $statement->execute(array(':user' => $username));

    $userInfo = $statement->fetch(PDO::FETCH_ASSOC);

    if (password_verify($password, $userInfo['password']))
    {
        // Correct Password, save id to session
        echo 'Logged in as' . $username;
    } else {
        // Wrong password
        echo 'Username or password is incorrect';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In</title>
</head>
<body>
<h1>Sign In</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="signInForm">
    <h2>Enter login information</h2>
    <label for="username">Username:</label>
    <input type="text" name="username" id="username"><br/>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password"><br/>
    <input type="submit" value="Submit"><br/>
</form>
</body>
</html>
