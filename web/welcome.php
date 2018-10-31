<?php
session_start();
include 'teach07_functions.php';

if (isset($_SESSION["userId"])) {
    $userId = $_SESSION["userId"];
    //continue on page
    $statement = $db->prepare('SELECT username, password FROM user_info WHERE id=:id');
    $statement->execute(array(':id' => $userId));
    $userInfo = $statement->fetch(PDO::FETCH_ASSOC);
    $username = $userInfo['username'];
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
