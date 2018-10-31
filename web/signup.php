<?php
session_start();
include 'teach07_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
// Get input from user
    $username = cleanInput($_POST["username"]);
    $password = cleanInput($_POST["password"]);
    $confirmPassword = cleanInput($_POST["confirmPassword"]);

    //Compare passwords
    if ($password === $confirmPassword) {
        if ((strlen($password) > 6) && (preg_match('/[0-9]/', $password)))
        {
            // Hash the password
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Insert password
            $statement = $db->prepare('INSERT INTO user_info (username, password) VALUES (:user, :pass)');
            $statement->execute(array(':user' => $username, ':pass' => $passwordHash));

// Go to sign in screen
            header('Location: signin.php');
            die();
        }
        else
        {
            $insufficientPassword = true;
            $passwordError = true;
        }
    }
    else
    {
//Passwords don't match!
        $passwordsDontMatch = true;
        $passwordError = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign-Up</title>
</head>
<style>
    .error {
        color: red;
    }
</style>
<body>
<h1>Sign-Up</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="signUpForm">
    <h2>Enter login information</h2>
    <label for="username">Username:</label>
    <input type="text" name="username" id="username"><br/>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password"><?php if($passwordError == true){echo '<span class="error">*</span>';} ?><br/>
    <label for="confirmPassword">Confirm Password:</label>
    <input type="password" name="confirmPassword" id="confirmPassword"><?php if($passwordError == true){echo '<span class="error">*</span>';} ?><br/>
    <input type="submit" value="Submit"><br/>
</form>
<?php
if($passwordsDontMatch == true) {
    echo '<span class="error">Passwords don\'t match.</span>';
}
if($insufficientPassword == true) {
    echo '<span class="error">Password must be at least 7 characters long and contain at least one number.</span>';
}
?>
</body>
</html>
