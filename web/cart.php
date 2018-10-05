<?php
session_start();
?>
<?php
$musicAlbums = "";
$musicMap = array("beatles_1"=>"The Beatles: <i>1</i>",
"belindac_runaway"=>"Belinda Carlisle: <i>Runaway Horses</i>",
"shakira_ladrones"=>"Shakira: <i>D&#243;nde Est&#225;n Los Ladrones?</i>",
"michelleb_hotel"=>"Michelle Branch: <i>Hotel Paper</i>",
"lindsey_stirling"=>"Lindsey Stirling: <i>Lindsey Stirling</i>",
"kellyc_allwanted"=>"Kelly Clarkson: <i>All I Ever Wanted",
"enya_shepherd"=>"Enya: <i>Shepherd Moons</i>",
"celined_decade"=>"Celine Dion: <i>All the Way... A Decade of Song</i>",
"a-ha_hunting"=>"A-ha: <i>Hunting High and Low</i>",
"sarabar_kaleidoscope"=>"Sara Bareilles: <i>Kaleidoscope Heart</i>",
"mamaspapas_leaves"=>"The Mamas and the Papas: <i>All The Leaves Are Brown: The Golden Era Collection</i>",
"tmbgiants_flood"=>"They Might Be Giants: <i>Flood</i>",
"shania_comeover"=>"Shania Twain: <i>Come on Over</i>");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $musicAlbums = $_POST["musicAlbums"];
   $test_text = $_POST["test_text"];
}
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
echo "<ul>";
foreach ($musicAlbums as $musicAlbums=>$value) {
	echo "<li>" . $musicMap[$value] . "</li>";
}
echo "</ul>";
<h2>Items in cart (session):</h2>
//print_r($_SESSION);
echo $_SESSION["inCart"];
?>
</body>
</html>