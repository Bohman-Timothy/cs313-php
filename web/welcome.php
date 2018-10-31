<?php
session_start();
include 'teach07_functions.php';

if ($_SESSION["loggedIn"] == true) {
    //continue on page
}
else {
    header("Location: signin.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <h1>Welcome</h1>
    <?php
    echo 'Welcome to our site, ' . $username . '!';
    ?>
</head>
<body>
</body>
</html>
