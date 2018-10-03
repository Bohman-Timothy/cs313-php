<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
<!-- <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
</form> -->
<form method="post" action="teach03_submit.php">
<b>Name:</b> <input type="text" name="name"><br>
<b>Email:</b> <input type="text" name="email"><br>
<b>Major:</b><br>
<input type="radio" name="major" value="Computer Science">Computer Science<br>
<input type="radio" name="major" value="Web Design and Development">Web Design and Development<br>
<input type="radio" name="major" value="Computer Information Technology">Computer Information Technology<br>
<input type="radio" name="major" value="Computer Engineering">Computer Engineering<br>
<b>Comments:</b><br>
<textarea name="comments" rows="5" cols="40"></textarea>
<input type="submit">
</form>
</body>
</html>