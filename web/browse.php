<?php
session_start();

include 'shopping.php';

$musicAlbum = "";

if (!isset($_SESSION["a-ha_hunting"])) {
      $_SESSION["a-ha_hunting"] = 0;
}
if (!isset($_SESSION["sarabar_kaleidoscope"])) {
      $_SESSION["sarabar_kaleidoscope"] = 0;
}
if (!isset($_SESSION["beatles_1"])) {
      $_SESSION["beatles_1"] = 0;
}
if (!isset($_SESSION["michelleb_hotel"])) {
      $_SESSION["michelleb_hotel"] = 0;
}
if (!isset($_SESSION["belindac_runaway"])) {
      $_SESSION["belindac_runaway"] = 0;
}
if (!isset($_SESSION["kellyc_allwanted"])) {
      $_SESSION["kellyc_allwanted"] = 0;
}
if (!isset($_SESSION["celined_decade"])) {
      $_SESSION["celined_decade"] = 0;
}
if (!isset($_SESSION["enya_shepherd"])) {
      $_SESSION["enya_shepherd"] = 0;
}
if (!isset($_SESSION["mamaspapas_leaves"])) {
      $_SESSION["mamaspapas_leaves"] = 0;
}
if (!isset($_SESSION["shakira_ladrones"])) {
      $_SESSION["shakira_ladrones"] = 0;
}
if (!isset($_SESSION["shania_comeover"])) {
      $_SESSION["shania_comeover"] = 0;
}
if (!isset($_SESSION["lindsey_stirling"])) {
      $_SESSION["lindsey_stirling"] = 0;
}
if (!isset($_SESSION["tmbgiants_flood"])) {
      $_SESSION["tmbgiants_flood"] = 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $musicAlbum = clean_input($_POST["musicAlbum"]);
   if (isset($musicAlbum) && ($musicAlbum != "")) {
      addToCartSession($musicAlbum);
      displayCount($musicAlbum);
   }
}

function displayCount($musicAlbum) {
	 echo $musicMap[$musicAlbum] . ' #: ' . $_SESSION[$musicAlbum] . "<br />";
}

function addToCartSession($musicAlbum) {
	$_SESSION[$musicAlbum] = $_SESSION[$musicAlbum] + 1;
	echo "Added " . $musicAlbum . " to cart.<br />";
}

function clean_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

?>
<script>
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- <link rel="stylesheet" href="shopping.css">
    <script src="shopping.js" charset="UTF-8"></script> -->

<title>Browse and Select Music to Buy</title>
</head>
<body>
<h1>Browse and Select Music to Buy</h1>
<!-- <form method="post" action="<?php echo htmlspecialchars("cart.php");?>">
-->

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input type="submit" value="Add to cart">
<input type="checkbox" name="musicAlbum" id="a-ha_hunting" value="a-ha_hunting">
<label for="a-ha_hunting">A-ha: <i>Hunting High and Low</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input type="submit" value="Add to cart">
<input type="checkbox" name="musicAlbum" id="sarabar_kaleidoscope" value="sarabar_kaleidoscope">
<label for="sarabar_kaleidoscope">Sara Bareilles: <i>Kaleidoscope Heart</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<!-- <button type="submit">Add to cart</button> -->
<input type="submit" value="Add to cart">
<input type="checkbox" name="musicAlbum" id="beatles_1" value="beatles_1">
<label for="beatles_1">The Beatles: <i>1</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<!-- <button type="submit">Add to cart</button> -->
<input type="submit" value="Add to cart">
<input type="checkbox" name="musicAlbum" id="michelleb_hotel" value="michelleb_hotel"> <label for="michelleb_hotel">Michelle Branch: <i>Hotel Paper</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input type="submit" value="Add to cart">
<input type="checkbox" name="musicAlbum" id="belindac_runaway" value="belindac_runaway">
<label for="belindac_runaway">Belinda Carlisle: <i>Runaway Horses</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input type="submit" value="Add to cart">
<input type="checkbox" name="musicAlbum" id="kellyc_allwanted" value="kellyc_allwanted">
<label for="kellyc_allwanted">Kelly Clarkson: <i>All I Ever Wanted</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input type="submit" value="Add to cart">
<input type="checkbox" name="musicAlbum" id="celined_decade" value="celined_decade">
<label for="celined_decade">Celine Dion: <i>All the Way... A Decade of Song</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input type="submit" value="Add to cart">
<input type="checkbox" name="musicAlbum" id="enya_shepherd" value="enya_shepherd">
<label for="enya_shepherd">Enya: <i>Shepherd Moons</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input type="submit" value="Add to cart">
<input type="checkbox" name="musicAlbum" id="mamaspapas_leaves" value="mamaspapas_leaves">
<label for="mamaspapas_leaves">The Mamas and the Papas: <i>All The Leaves Are Brown: The Golden Era Collection</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input type="submit" value="Add to cart">
<input type="checkbox" name="musicAlbum" id="shakira_ladrones" value="shakira_ladrones">
<label for="shakira_ladrones">Shakira: <i>D&#243;nde Est&#225;n Los Ladrones?</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input type="submit" value="Add to cart">
<input type="checkbox" name="musicAlbum" id="shania_comeover" value="shania_comeover">
<label for="shania_comeover">Shania Twain: <i>Come on Over</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input type="submit" value="Add to cart">
<input type="checkbox" name="musicAlbum" id="lindsey_stirling" value="lindsey_stirling">
<label for="lindsey_stirling">Lindsey Stirling: <i>Lindsey Stirling</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input type="submit" value="Add to cart">
<input type="checkbox" name="musicAlbum" id="tmbgiants_flood" value="tmbgiants_flood">
<label for="tmbgiants_flood">They Might Be Giants: <i>Flood</i></label>
</form>
<!-- <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input type="submit" value="Add to cart">
</form> -->

<h2>References</h2>
https://www.w3schools.com/html/html_symbols.asp
https://www.w3schools.com/html/html_charset.asp
https://www.w3schools.com/php/php_sessions.asp
https://www.tutorialspoint.com/php/php_sessions.htm
https://www.w3schools.com/Php/php_functions.asp
https://stackoverflow.com/questions/15741006/adding-div-element-to-body-or-document-in-javascript
https://www.w3schools.com/jsref/prop_html_classname.asp
https://www.w3schools.com/php/php_includes.asp
</body>
</html>