<!DOCTYPE html>
<html lang="en">
<head>
<title>Teach 03 Form</title>
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $name = clean_input($_POST["name"]);
   $email = clean_input($_POST["email"]);
   $major = clean_input($_POST["major"]);
   $comments = clean_input($_POST["comments"]);
}

function clean_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>

<!-- <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
</form> -->
<form method="post" action="<?php echo htmlspecialchars(teach03_submit.php);?>">
<b>Name:</b> <input type="text" name="name"><br>
<b>Email:</b> <input type="text" name="email"><br><br>
<b>Major:</b><br>
<input type="radio" name="major" value="Computer Science">Computer Science<br>
<input type="radio" name="major" value="Web Design and Development">Web Design and Development<br>
<input type="radio" name="major" value="Computer Information Technology">Computer Information Technology<br>
<input type="radio" name="major" value="Computer Engineering">Computer Engineering<br><br>
<b>Comments:</b><br>
<textarea name="comments" rows="5" cols="40"></textarea><br>
<input type="submit"><br><br>
</form>

<?php
echo "<h2>Input Submitted:</h2>";
echo $name . "<br>";
echo $email . "<br>";
echo $major . "br>";
echo $comments . "<br>";
?>
</body>
</html>