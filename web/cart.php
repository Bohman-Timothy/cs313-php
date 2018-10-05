<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Shopping Cart</title>
</head>
<body>
<?php
$name = $email = $major = $comments = $continents = "";
$musicMap = array("beatles_1"=>"The Beatles: 1",
"belindac_runaway"=>"Belinda Carlisle: Runaway Horses",
"shakira_ladrones"=>"Shakira: D&#243;nde Est&#225;n Los Ladrones?",
"michelleb_hotel"=>"Michelle Branch: Hotel Paper",
"lindsey_stirling"=>"Lindsey Stirling: Lindsey Stirling",
"kellyc_allwanted"=>"Kelly Clarkson: All I Ever Wanted",
"enya_shepherd"=>"Enya: Shepherd Moons",
"celined_decade"=>"Celine Dion: All the Way... A Decade of Song",
"a-ha_hunting"=>"A-ha: Hunting High and Low",
"sarabar_kaleidoscope"=>"Sara Bareilles: Kaleidoscope Heart",
"mamaspapas_leaves"=>"The Mamas and the Papas: All The Leaves Are Brown: The Golden Era Collection",
"tmbgiants_flood"=>"They Might Be Giants: Flood",
"shania_comeover"=>"Shania Twain: Come on Over");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $musicAlbums = $_POST["musicAlbums"];
}
?>

<h1>Shopping Cart</h1>
<?php
echo "<ul>"
foreach ($musicAlbums as $musicAlbumss=>$value) {
	echo "<li>" . $musicMap[$value] . "</li>";
}
echo "</ul>"
?>
</body>
</html>