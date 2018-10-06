<?php
session_start();

//$musicAlbums = "";

//include 'shopping.php';

/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $musicAlbums = $_POST["musicAlbums"];
   $test_text = $_POST["test_text"];
}*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Shopping Cart</title>
</head>
<body>
<h1>Shopping Cart</h1>
<h2>Items in your cart:</h2>
<?php
/*echo "<ul>";
foreach ($musicAlbums as $musicAlbums=>$value) {
	echo "<li>" . $musicMap[$value] . "</li>";
}
echo "</ul>";*/
echo "<ul>";
foreach ($musicMap as $musicAlbums=>$value) {
	echo "<li>" . $_SESSION[$value] . " of " $musicMap[$value]. "</li>";
}
echo "</ul>";
echo "<h2>Items in cart (session):</h2>";
print_r($_SESSION);
echo $_SESSION["inCart"];
?>
</body>
</html>