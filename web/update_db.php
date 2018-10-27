<?php
include 'project1_functions.php';

$updateFeature = $featureId = $action = '';
$featureId = '';
$featureTitle = '';
$featureYear = '';
$format = '';
$formatYear = '';
$featureSetTitle = '';
$location = '';
$existingLoan = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $updateFeature = $_POST["updateFeature"];
    $featureId = $_POST["featureId"];
    $action = $_POST["action"];

    if ($action == 'Add Feature') {
        $featureTitle = $_POST["featureTitle"];
        $featureYear = $_POST["featureYear"];
        $format = $_POST["format"];
        $formatYear = $_POST["formatYear"];
        $featureSetTitle = $_POST["featureSetTitle"];
        $location = $_POST["location"];
    }
    else if ($action == 'Clear Form') {
        $featureId = '';
        $featureTitle = '';
        $featureYear = '';
        $format = '';
        $formatYear = '';
        $featureSetTitle = '';
        $location = '';
        $existingLoan = '';
    }
    //select ID and display the feature
    else if (($action == 'Select ID') && ($updateFeature != '') && ($featureId != '')) {
        echo 'Feature ID to update: ' . $updateFeature . '<br/>';

        $db_query_feature_id = 'SELECT id, feature_title, feature_year, format, format_year, feature_set_title, location, existing_loan FROM feature_view WHERE id = ' . $updateFeature . ';';
        $db_statement_feature_id = $db->prepare($db_query_feature_id);
        $db_statement_feature_id->execute();

        //show selected feature
        /*echo '<table class="featureResults">';
        echo '<thead><caption class="exactResultsTableCaption">Result Matching Search</caption></thead>';
        showFullListOfFeatures($db_statement_feature_id);*/

        //get values to populate input
        $counter = 0;
        while ($row = $db_statement_feature_id->fetch(PDO::FETCH_ASSOC))
        {
            $featureId = $row['id'];
            $featureTitle = $row['feature_title'];
            $featureYear = $row['feature_year'];
            $format = $row['format'];
            $formatYear = $row['format_year'];
            $featureSetTitle = $row['feature_set_title'];
            $location = $row['location'];
            $existingLoan = $row['existing_loan'];
            $counter++;
        }
        if ($counter == 0) {
            echo 'No match found for ID #' . $featureId;
        }

        //insert scripture
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
        <input type="checkbox" name="updateFeature" id="updateFeatureCheckbox_id" value="" onclick="showFeatureIdInputField();" <?php if ($updateFeature != '') {echo 'checked';} ?>>
		<label for="updateFeatureCheckbox_id">Update a feature instead of inserting a new one</label><br />
        <script>
            showFeatureIdInputField();
        </script>
        <?php
        if ($updateFeature != '') {
            echo '<p id="featureHasBeenSelected_id">Feature ' . $updateFeature . ' has been selected.</p>';
        }
        ?>
		<div id="enterFeatureIdHiddenArea_id">
			<label for="enterFeatureId_id">Enter Feature ID:</label>
            <input type="number" min="1" name="featureId" id="enterFeatureId_id" title="Enter the ID found by using the database's search feature" value="<?php echo $featureId; ?>">
            <input type="submit" name="action" value="Select ID" id="selectIdButton_id" formnovalidate onclick="if(document.getElementById('updateFeatureCheckbox_id').checked){document.getElementById('updateFeatureCheckbox_id').value = document.getElementById('enterFeatureId_id').value;}"><br />
        </div>
		<label for="featureTitle_id">Feature Title:</label>
		<input type="text" name="featureTitle" id="featureTitle_id" title="Enter exact title of the feature" required value="<?php echo $featureTitle; ?>"><br />
		<label for="featureYear_id">Feature Year:</label>
		<input type="text" name="featureYear" id="featureYear_id" title="Enter a four-digit number" required value="<?php echo $featureYear; ?>"><br />
		<label for="format">Format:</label>
		<div class="formatOptions">
			<input type="radio" name="format" value="ultraHd" id="ultraHdOption_id">
			<label for="ultraHdOption_id">4K Ultra HD Blu-ray</label><br />
			<input type="radio" name="format" value="bluray" id="blurayOption_id">
			<label for="blurayOption_id">Blu-ray</label><br />
			<input type="radio" name="format" value="dvd" id="dvdOption_id" checked>
			<label for="dvdOption_id">DVD</label><br />
			<input type="radio" name="format" value="vhs" id="vhsOption_id">
			<label for="vhsOption_id">VHS</label><br />
		</div>
		<label for="formatYear_id">FormatYear:</label>
		<input type="text" name="formatYear" id="formatYear_id" title="Enter a four-digit number" required value="<?php echo $formatYear; ?>"><br />
		<label for="featureSetTitle_id">Feature Set Title:</label>
		<input type="text" name="featureSetTitle" id="featureSetTitle_id" title="Enter exact title of the feature set (if the feature is part of a set); leave blank otherwise" value="<?php echo $featureSetTitle; ?>"><br />
		<label for="location">Location:</label>
		<div class="locationOptions">
			<input type="radio" name="location" value="bedroom" id="bedroomOption_id" checked>
			<label for="bedroomOption_id">Bedroom</label><br />
			<input type="radio" name="location" value="diningRoom" id="diningRoomOption_id">
			<label for="diningRoomOption_id">Dining Room</label><br />
			<input type="radio" name="location" value="familyRoom" id="familyRoomOption_id">
			<label for="familyRoomOption_id">Family Room</label><br />
			<input type="radio" name="location" value="hallway" id="hallwayOption_id">
			<label for="hallwayOption_id">Hallway</label><br />
			<input type="radio" name="location" value="livingRoom" id="livingRoomOption_id">
			<label for="livingRoomOption_id">Living Room</label><br />
		</div>
        <?php
        if ($updateFeature != '') {
            echo '<input type="submit" name="action" value="Update Feature" class="submitButton" id="updateFeatureButton_id">';
        }
        else {
            echo '<input type="submit" name="action" value="Add Feature" class="submitButton" id="addFeatureButton_id">';
        }
        ?>
        <input type="submit" name="action" value="Clear Form" class="submitButton" id="clearFormButton_id">
		<!-- <input type="submit" name="action" value="Add or Update" class="submitButton" id="addOrUpdateButton_id" onclick="if(document.getElementById('updateFeatureCheckbox_id').checked){document.getElementById('updateFeatureCheckbox_id').value = document.getElementById('enterFeatureId_id').value;}"> -->
	</form>
</body>
</html>