<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Browse Music</title>
</head>
<body>
<h1>Browse Music</h1>
<form method="post" action="<?php echo htmlspecialchars("cart.php");?>">
<input type="checkbox" name="musicAlbums[]" id="beatles_1" value="beatles_1"> <label for="beatles_1">The Beatles: <i>1</i></label><br />
<input type="checkbox" name="musicAlbums[]" id="belindac_runaway" value="belindac_runaway"> <label for="belindac_runaway">Belinda Carlisle: <i>Runaway Horses</i></label><br />
<input type="checkbox" name="musicAlbums[]" id="shakira_ladrones" value="shakira_ladrones"> <label for="shakira_ladrones">Shakira: <i>D&#243;nde Est&#225;n Los Ladrones?</i></label><br />
<input type="checkbox" name="musicAlbums[]" id="michelleb_hotel" value="michelleb_hotel"> <label for="michelleb_hotel">Michelle Branch: <i>Hotel Paper</i></label><br />
<input type="checkbox" name="musicAlbums[]" id="lindsey_stirling" value="lindsey_stirling"> <label for="lindsey_stirling">Lindsey Stirling: <i>Lindsey Stirling</i></label><br />
<input type="checkbox" name="musicAlbums[]" id="kellyc_allwanted" value="kellyc_allwanted"> <label for="kellyc_allwanted">Kelly Clarkson: <i>All I Ever Wanted</i></label><br />
<input type="checkbox" name="musicAlbums[]" id="enya_shepherd" value="enya_shepherd"> <label for="enya_shepherd">Enya: <i>Shepherd Moons</i></label><br />
<input type="checkbox" name="musicAlbums[]" id="celined_decade" value="celined_decade"> <label for="celined_decade">Celine Dion: <i>All the Way... A Decade of Song</i></label><br />
<input type="checkbox" name="musicAlbums[]" id="a-ha_hunting" value="a-ha_hunting"> <label for="a-ha_hunting">A-ha: <i>Hunting High and Low</i></label><br />
<input type="checkbox" name="musicAlbums[]" id="sarabar_kaleidoscope" value="sarabar_kaleidoscope"> <label for="sarabar_kaleidoscope">Sara Bareilles: <i>Kaleidoscope Heart</i></label><br />
<input type="checkbox" name="musicAlbums[]" id="mamaspapas_leaves" value="mamaspapas_leaves"> <label for="mamaspapas_leaves">The Mamas and the Papas: <i>All The Leaves Are Brown: The Golden Era Collection</i></label><br />
<input type="checkbox" name="musicAlbums[]" id="tmbgiants_flood" value="tmbgiants_flood"> <label for="tmbgiants_flood">They Might Be Giants: <i>Flood</i></label><br />
<input type="checkbox" name="musicAlbums[]" id="shania_comeover" value="shania_comeover"> <label for="shania_comeover">Shania Twain: <i>Come on Over</i></label><br /><br />
<input type="text" name="test_text" value="This"><br />
<input type="submit" value="Add to cart"><br /><br />
</form>

<h2>References</h2>
https://www.w3schools.com/html/html_symbols.asp
https://www.w3schools.com/html/html_charset.asp
</body>
</html>