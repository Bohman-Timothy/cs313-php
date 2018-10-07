<?php
session_start();

include 'shopping.php';

$albumPrice = 10;
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
if (!isset($_SESSION["vanessac_harmonium"])) {
      $_SESSION["vanessac_harmonium"] = 0;
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
if (!isset($_SESSION["gogos_greatest"])) {
      $_SESSION["gogos_greatest"] = 0;
}
if (!isset($_SESSION["avrillav_underskin"])) {
      $_SESSION["avrillav_underskin"] = 0;
}
if (!isset($_SESSION["mamaspapas_leaves"])) {
      $_SESSION["mamaspapas_leaves"] = 0;
}
if (!isset($_SESSION["monkees_bestof"])) {
      $_SESSION["monkees_bestof"] = 0;
}
if (!isset($_SESSION["petshop_discog"])) {
      $_SESSION["petshop_discog"] = 0;
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
if (!isset($_SESSION["nobuo_ffvi"])) {
      $_SESSION["nobuo_ffvi"] = 0;
}

initializeQuantities();

function addToCartSession($musicAlbum) {
	if ($_SESSION[$musicAlbum] < 99) {
		$_SESSION[$musicAlbum] = $_SESSION[$musicAlbum] + 1;
		echo 'Added [code:] <span class="artistAndAlbum">' . $musicAlbum . '</span> to cart.<br />';
	}
	else {
		echo "Maximum allowed is " . 99 . ".<br />";
	}
}

?>
<script>
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <!-- Bootstrap compiled CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="stylesheet" href="shopping.css">
    <!-- <script src="shopping.js" charset="UTF-8"></script> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Browse and Select Music to Buy</title>
</head>
<body>
<h1>Browse and Select Music to Buy</h1>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $musicAlbum = clean_input($_POST["musicAlbum"]);
   if (isset($musicAlbum) && ($musicAlbum != "")) {
	   echo "<p>";
	   addToCartSession($musicAlbum);
	   displayCount($musicAlbum);
	   echo "</p>";
   }
}
echo "<p>Each album costs $" . $albumPrice . "</p>";
?>
<form method="post" action="<?php echo htmlspecialchars("cart.php");?>">
<input type="submit" value="View cart" id="viewCartBtn" class="btn btn-primary">
</form>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="a-ha_hunting" value="a-ha_hunting" class="hide">
<label for="a-ha_hunting">A-ha: <i>Hunting High and Low</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="sarabar_kaleidoscope" value="sarabar_kaleidoscope" class="hide">
<label for="sarabar_kaleidoscope">Sara Bareilles: <i>Kaleidoscope Heart</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="beatles_1" value="beatles_1" class="hide">
<label for="beatles_1">The Beatles: <i>1</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="michelleb_hotel" value="michelleb_hotel" class="hide">
<label for="michelleb_hotel">Michelle Branch: <i>Hotel Paper</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="belindac_runaway" value="belindac_runaway" class="hide">
<label for="belindac_runaway">Belinda Carlisle: <i>Runaway Horses</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="vanessac_harmonium" value="vanessac_harmonium" class="hide">
<label for="vanessac_harmonium">Vanessa Carlton: <i>Harmonium</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="kellyc_allwanted" value="kellyc_allwanted" class="hide">
<label for="kellyc_allwanted">Kelly Clarkson: <i>All I Ever Wanted</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="celined_decade" value="celined_decade" class="hide">
<label for="celined_decade">Celine Dion: <i>All the Way... A Decade of Song</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="enya_shepherd" value="enya_shepherd" class="hide">
<label for="enya_shepherd">Enya: <i>Shepherd Moons</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="evanescence_fallen" value="evanescence_fallen" class="hide">
<label for="evanescence_fallen">Evanescence: <i>Fallen</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="gogos_greatest" value="gogos_greatest" class="hide">
<label for="gogos_greatest">The Go-Go's: <i>Greatest</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="avrillav_underskin" value="avrillav_underskin" class="hide">
<label for="avrillav_underskin">Avril Lavigne: <i>Under My Skin</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="mamaspapas_leaves" value="mamaspapas_leaves" class="hide">
<label for="mamaspapas_leaves">The Mamas and the Papas: <i>All The Leaves Are Brown: The Golden Era Collection</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="monkees_bestof" value="monkees_bestof" class="hide">
<label for="monkees_bestof">The Monkees: <i>The Best of the Monkees</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="petshop_discog" value="petshop_discog" class="hide">
<label for="petshop_discog">Pet Shop Boys: <i>Discography</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="shakira_ladrones" value="shakira_ladrones" class="hide">
<label for="shakira_ladrones">Shakira: <i>D&#243;nde Est&#225;n Los Ladrones?</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="lindsey_stirling" value="lindsey_stirling" class="hide">
<label for="lindsey_stirling">Lindsey Stirling: <i>Lindsey Stirling</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="tmbgiants_flood" value="tmbgiants_flood" class="hide">
<label for="tmbgiants_flood">They Might Be Giants: <i>Flood</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="shania_comeover" value="shania_comeover" class="hide">
<label for="shania_comeover">Shania Twain: <i>Come on Over</i></label>
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="albumAddForm">
<input type="submit" value="Add to cart" class="btn btn-default addToCartBtn">
<input type="text" name="musicAlbum" id="nobuo_ffvi" value="nobuo_ffvi" class="hide">
<label for="nobuo_ffvi">Nobuo Uematsu: <i>Final Fantasy VI Original Soundtrack Remaster Version</i></label>
</form>

<h2>References</h2>
<ul>
<li>https://www.w3schools.com/html/html_symbols.asp</li>
<li>https://www.w3schools.com/html/html_charset.asp</li>
<li>https://www.w3schools.com/php/php_sessions.asp</li>
<li>https://www.tutorialspoint.com/php/php_sessions.htm</li>
<li>https://www.w3schools.com/Php/php_functions.asp</li>
<li>https://stackoverflow.com/questions/15741006/adding-div-element-to-body-or-document-in-javascript</li>
<li>https://www.w3schools.com/jsref/prop_html_classname.asp</li>
<li>https://www.w3schools.com/php/php_includes.asp</li>
<li><a href="https://stackoverflow.com/questions/3792936/how-to-send-data-with-form-label-element">Stack Overflow - name attribute on label</a></li>
<li><a href="https://www.w3schools.com/tags/att_input_type_number.asp">W3Schools - input type number</a></li>
<li><a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/number">Mozilla Developer Network Web Docs - Set width of number input</a></li>
<li><a href="https://stackoverflow.com/questions/23676778/what-html5-form-attribute-should-be-used-for-a-zipcode">Stack Overflow - Form Attribute to Use with Zip Code</a></li>
<li><a href="https://www.w3schools.com/php/php_form_required.asp">W3Schools - PHP Forms - Required Fields</a></li>
<li><a href="https://www.w3schools.com/tags/att_input_pattern.asp">W3Schools - Input Pattern Attribute</a></li>
</ul>
</body>
</html>