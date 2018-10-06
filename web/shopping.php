<?php

$musicMap = array("a-ha_hunting"=>"A-ha: <i>Hunting High and Low</i>",
"sarabar_kaleidoscope"=>"Sara Bareilles: <i>Kaleidoscope Heart</i>",
"beatles_1"=>"The Beatles: <i>1</i>",
"michelleb_hotel"=>"Michelle Branch: <i>Hotel Paper</i>",
"belindac_runaway"=>"Belinda Carlisle: <i>Runaway Horses</i>",
"kellyc_allwanted"=>"Kelly Clarkson: <i>All I Ever Wanted</i>",
"celined_decade"=>"Celine Dion: <i>All the Way... A Decade of Song</i>",
"enya_shepherd"=>"Enya: <i>Shepherd Moons</i>",
"mamaspapas_leaves"=>"The Mamas and the Papas: <i>All The Leaves Are Brown: The Golden Era Collection</i>",
"shakira_ladrones"=>"Shakira: <i>D&#243;nde Est&#225;n Los Ladrones?</i>",
"shania_comeover"=>"Shania Twain: <i>Come on Over</i>",
"lindsey_stirling"=>"Lindsey Stirling: <i>Lindsey Stirling</i>",
"tmbgiants_flood"=>"They Might Be Giants: <i>Flood</i>");

function initializeQuantities() {
	foreach ($musicMap as $albumKey=>$fullName) {
		if (!isset($_SESSION[$albumKey])) {
			$_SESSION[$albumKey] = 8;
		}
	}
}

function clean_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

function displayCount($musicAlbum) {
	 echo "<span class='quantity'>" . $_SESSION[$musicAlbum] . "</span>" . " of <span class='artistAndAlbum'>" . $musicAlbum . "</span> in cart.<br />";
}

/*echo "Shopping.php test<br />";
echo $musicMap["enya_shepherd"] . "<br />";*/
?>