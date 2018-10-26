<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $updateFeature = cleanInput($_POST["updateFeature"]);

    //insert topic
    if (($updateFeature != '') && ($enterFeatureId != '')) {
        //insert scripture
        echo 'Feature ID to update: ' . $updateFeature . '<br/>';
        /*$statement = $db->prepare('INSERT INTO scripture (book, chapter, verse, content) VALUES (:book, :chapter, :verse, :content)');
        $statement->execute(array(':book' => $book, ':chapter' => $chapter, ':verse' => $verse, ':content' => $content));

        $scripture_id = $db->lastInsertId('scripture_id_seq');*/
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Update the Feature Database</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="project1.css">
    <script src="project1.js" charset="UTF-8"></script>
</head>
<body>
	<h1>Update the Feature Database</h1>
	<ul id="navbar">
		<h2>Menu</h2>
		<li><a href="search_db.php">Search the database</a></li>
		<li class="active"><a href="update_db.php">Update the database</a></li>
		<li><a href="checkout_db.php">Check Out a Feature</a></li>
	</ul>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="update">
		<h2>Enter data to insert a feature into the database</h2>
		<input type="checkbox" name="updateFeature" id="updateFeatureCheckbox_id" value="" onclick="showFeatureIdInputField()">
		<label for="updateFeatureCheckbox_id">Update a feature instead of inserting a new one</label><br />
		<div id="enterFeatureIdHiddenArea_id">
			<label for="enterFeatureId_id">Enter Feature ID:</label>
			<input type="text" name="enterFeatureId" id="enterFeatureId_id" title="Enter the ID found by using the database's search feature" value=""><br />
		</div>
		<label for="addFeatureTitle_id">Feature Title:</label>
		<input type="text" name="addFeatureTitle" id="addFeatureTitle_id" title="Enter exact title of the feature" required value=""><br />
		<label for="addFeatureYear_id">Feature Year:</label>
		<input type="text" name="addFeatureYear" id="addFeatureYear_id" title="Enter a four-digit number" required value=""><br />
		<label for="addFormat">Format:</label>
		<div class="addFormatOptions">
			<input type="radio" name="addFormat" value="ultraHd" id="ultraHdOption_id">
			<label for="ultraHdOption_id">4K Ultra HD Blu-ray</label><br />
			<input type="radio" name="addFormat" value="bluray" id="blurayOption_id">
			<label for="blurayOption_id">Blu-ray</label><br />
			<input type="radio" name="addFormat" value="dvd" id="dvdOption_id" checked>
			<label for="dvdOption_id">DVD</label><br />
			<input type="radio" name="addFormat" value="vhs" id="vhsOption_id">
			<label for="vhsOption_id">VHS</label><br />
		</div>
		<label for="addFormatYear_id">FormatYear:</label>
		<input type="text" name="addFormatYear" id="addFormatYear_id" title="Enter a four-digit number" required value=""><br />
		<label for="addFeatureSetTitle_id">Feature Set Title:</label>
		<input type="text" name="addFeatureSetTitle" id="addFeatureSetTitle_id" title="Enter exact title of the feature set (if the feature is part of a set)" value=""><br />
		<label for="addLocation">Location:</label>
		<div class="addLocationOptions">
			<input type="radio" name="addLocation" value="bedroom" id="bedroomOption_id" checked>
			<label for="bedroomOption_id">Bedroom</label><br />
			<input type="radio" name="addLocation" value="diningRoom" id="diningRoomOption_id">
			<label for="diningRoomOption_id">Dining Room</label><br />
			<input type="radio" name="addLocation" value="familyRoom" id="familyRoomOption_id">
			<label for="familyRoomOption_id">Family Room</label><br />
			<input type="radio" name="addLocation" value="hallway" id="hallwayOption_id">
			<label for="hallwayOption_id">Hallway</label><br />
			<input type="radio" name="addLocation" value="livingRoom" id="livingRoomOption_id">
			<label for="livingRoomOption_id">Living Room</label><br />
		</div>
		<input type="submit" value="Add or Update" class="submitButton" id="addOrUpdateButton_id" onclick="if(document.getElementById('updateFeatureCheckbox_id').checked){document.getElementById('updateFeatureCheckbox_id').value = document.getElementById('enterFeatureId_id').value;}">
	</form>
</body>
</html>