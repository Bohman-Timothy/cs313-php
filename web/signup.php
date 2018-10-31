<?php
session_start();
include 'teach07_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
// Get input from user
    $username = cleanInput($_POST["username"]);
    $password = cleanInput($_POST["password"]);
    $passwordConfirm = cleanInput($_POST["passwordConfirm"]);

    //Compare passwords
    if ($password === $passwordConfirm) {
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
//Passwords don't match!
        $passwordsDontMatch = true;
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
    <input type="password" name="password" id="password"><br/><?php if($passwordsDontMatch == true){echo <span class="error">'*'</span>;}?>
    <input type="submit" value="Submit"><br/>
    <label for="confirmPassword">Password:</label>
    <input type="password" name="confirmPassword" id="confirmPassword"><?php if($passwordsDontMatch == true){echo '<span class="error">*</span>';}?><br/>
    <input type="submit" value="Submit"><br/>
</form>
<?php
if($passwordsDontMatch == true){
    echo '<span class="error">Passwords don\'t match.</span>';
}
?>
</body>
</html>
