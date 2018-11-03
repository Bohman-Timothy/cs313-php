<?php
session_start();
include 'project1_functions.php';

$successMessage = $errorMessage = '';
$username = $password = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submitAction = $_POST["submit"];
    $username = cleanInput($_POST["username"]);
    $password = cleanInput($_POST["password"]);

    if ($submitAction == 'Log In') {
        if (($username != '') && ($password != '')) {
            $db_query_username = 'SELECT id, username, full_name FROM patron WHERE username =:username and password =:password;';
            $db_statement_username = $db->prepare($db_query_username);
            $db_statement_username->execute(array(':username' => $username, ':password' => $password));
            /*$result = $db_statement_username->get_result();*/

            $match = false;
            while ($row = $db_statement_username->fetch(PDO::FETCH_ASSOC)) {
                $match = true;
                $_SESSION["userId"] = $row['id'];
            }

            if (($match == true) && ($password != '')) { //(($username == 'tester') || ($username == 'asquire') || ($username == 'Condorman'))) {
                $_SESSION["user"] = $username;
                $_SESSION["loggedIn"] = true;
                $successMessage = '<p class="successMessage">Successfully logged in as ' . $_SESSION["user"] . '</p>';
            } else {
                $errorMessage = '<p class="errorMessage">Incorrect username or password</p>';
            }
        }
    }
    else if ($submitAction == 'Log Out') {
        session_unset();
        session_destroy();
        $successMessage = '<p class="successMessage">Successfully logged out</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="project1.css">
</head>
<body>
<h1>Sign In</h1>
<ul id="navbar">
    <h2>Menu</h2>
    <li><a href="search_db.php">Search the database</a></li>
    <li><a href="update_db.php">Update the database</a></li>
    <li><a href="checkout_db.php">Check Out or Return a Feature</a></li>
    <li class="active">
        <?php
            if ($_SESSION["loggedIn"] == true) {
                echo '<a href="login_db.php">Sign Out or Switch User</a><br/><span class="loggedInAsUser">Logged in as ' . $_SESSION["user"] . '</span>';
            }
            else {
                echo '<a href="login_db.php">Sign In</a>';
            }
        ?></li>
</ul>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="login">
    <h2>Enter username and password to log in</h2>
    <label for="username_id">Enter Username:</label>
    <input type="text" name="username" id="username_id" required value=""><br/>
    <label for="password_id">Enter Password:</label>
    <input type="password" name="password" id="password_id" required><br/>
    <input type="submit" name="submit" value="Log In" class="submitButton">
</form>
<?php
if ($_SESSION["loggedIn"] == true) { ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="logout">
        <h2>Use the button below to log out</h2>
        <input type="submit" name="submit" value="Log Out" class="submitButton">
    </form>
<?php
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($successMessage != '') {
        echo $successMessage;
    }
    else {
        echo $errorMessage;
    }
}
?>
</body>
</html>