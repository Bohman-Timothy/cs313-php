<?php
session_start();
include 'project1_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = cleanInput($_POST["username"]);
    $password = cleanInput($_POST["password"]);

    if (($username != '') && ($password != '')) {
        $db_query_username = 'SELECT id, username, full_name FROM patron WHERE username =:username;';
        $db_statement_username = $db->prepare($db_query_username);
        $db_statement_username->execute(array(':username' => $username));
        echo '<p>Successfully logged in as ' . $username . '</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check Out a Feature Loan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="project1.css">
</head>
<body>
<h1>Check Out a Feature Loan</h1>
<ul id="navbar">
    <h2>Menu</h2>
    <li><a href="search_db.php">Search the database</a></li>
    <li><a href="update_db.php">Update the database</a></li>
    <li><a href="checkout_db.php">Check Out a Feature</a></li>
    <li class="active"><a href="login_db.php">Sign In</a></li>
</ul>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="checkout">
    <h2>Enter username and password</h2>
    <label for="username_id">Enter Username:</label>
    <input type="text" name="username" id="username_id" required value=""><br/>
    <label for="password_id">Enter Password:</label>
    <input type="password" name="password" id="password_id" required><br/>
    <input type="submit" value="Submit" class="submitButton">
</form>
</body>
</html>