<!DOCTYPE html>
<html lang="en">
<head>
<title>Teach 03 Form</title>
</head>
<body>
<?php
$name = $email = $major = $comments = $continents = "";
$majors = array("Computer Science", "Web Design and Development", "Computer information Technology", "Computer Engineering");
$continentsMap = array("na"=>"North America","sa"=>"South America","eu"=>"Europe","as"=>"Asia","au"=>"Australia","af"=>"Africa");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $name = clean_input($_POST["name"]);
   $email = clean_input($_POST["email"]);
   $major = clean_input($_POST["major"]);
   $comments = clean_input($_POST["comments"]);
   $continents = $_POST["continents"];
   foreach ($continents as $continentss=>$value) {
   	   //echo "Test before cleaning:1. " . $value;
   	   $value = clean_input($_POST["name"]);
   	   //echo "<br>Test after cleaning:2. " . $value;
	   }
}

function clean_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<!-- <form method="post" action="<?php echo htmlspecialchars(teach03_submit.php);?>"> -->
<h2>Please enter the following data:</h2>
<b>Name:</b> <input type="text" name="name" value="<?php echo $name;?>"><br>
<b>Email:</b> <input type="text" name="email" value="<?php echo $email;?>"><br><br>
<b>Major:</b><br>
<?php
foreach ($majors as $majorss=>$value) {
	echo "<input type=\"radio\" name=\"major\" value=\"" . $value . "\">" . $value . "<br>";

}
?>
<br>
<!--
<input type="radio" name="major" value="Computer Science">Computer Science<br>
<input type="radio" name="major" value="Web Design and Development">Web Design and Development<br>
<input type="radio" name="major" value="Computer Information Technology">Computer Information Technology<br>
<input type="radio" name="major" value="Computer Engineering">Computer Engineering<br><br>
 -->
<b>Comments:</b><br>
<textarea name="comments" rows="5" cols="40"><?php echo $comments?></textarea><br><br>
<b>Continents Visited:</b><br>
<input type="checkbox" name="continents[]" value="na">North America<br>
<input type="checkbox" name="continents[]" value="sa">South America<br>
<input type="checkbox" name="continents[]" value="eu">Europe<br>
<input type="checkbox" name="continents[]" value="as">Asia<br>
<input type="checkbox" name="continents[]" value="au">Australia<br>
<input type="checkbox" name="continents[]" value="af">Africa<br>
<input type="checkbox" name="continents[]" value="an">Antarctica<br>

<!--
<input type="checkbox" name="continents[]" value="North America">North America<br>
<input type="checkbox" name="continents[]" value="South America">South America<br>
<input type="checkbox" name="continents[]" value="Europe">Europe<br>
<input type="checkbox" name="continents[]" value="Asia">Asia<br>
<input type="checkbox" name="continents[]" value="Australia">Australia<br>
<input type="checkbox" name="continents[]" value="Africa">Africa<br>
<input type="checkbox" name="continents[]" value="Antarctica">Antarctica<br>
-->
<input type="submit"><br><br>
</form>

<?php
echo "<h2>Input Submitted:</h2>";
echo "Name: " . $name . "<br>";
echo "Email: " . $email . "<br>";
echo "Major: " . $major . "<br>";
echo "Comments: " . $comments . "<br>";
echo "Continents: " . "<br>";
/* foreach ($continents as $continents=>$value) {
	echo $value . "<br>";
} */
foreach ($continents as $continents=>$value) {
	echo $continentsMap[$value] . "<br>";
}
?>
</body>
</html>