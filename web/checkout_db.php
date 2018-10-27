<?php
session_start();
include 'project1_functions.php';

$searchId = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $featureId = cleanInput($_POST["featureId"]);

    if ($featureId != '') {
        $db_query_feature_id = 'SELECT id, feature_title, feature_year, format, format_year, feature_set_title, location, existing_loan FROM feature_view WHERE id =:featureId;';
        $db_statement_feature_id = $db->prepare($db_query_feature_id);
        $db_statement_feature_id->execute(array(':featureId' => $featureId));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Check Out a Feature Loan</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="project1.css">
</head>
<body>
	<h1>Check Out a Feature Loan</h1>
	<ul id="navbar">
		<h2>Menu</h2>
		<li><a href="search_db.php">Search the database</a></li>
		<li><a href="update_db.php">Update the database</a></li>
		<li class="active"><a href="checkout_db.php">Check Out a Feature</a></li>
	</ul>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="checkout">
		<h2>Enter data to select a feature to get on loan</h2>
		<label for="enterFeatureId_id">Enter Feature ID:</label>
		<input type="number" min="1" name="featureId" id="enterFeatureId_id" title="Enter the ID found by using the database's search feature" value=""><br />
		<input type="submit" value="Submit" class="submitButton">
	</form>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //show selected feature
        echo '<table class="featureResults">';
        echo '<thead><caption class="exactResultsTableCaption">Result Matching Search</caption></thead>';
        showFullListOfFeatures($db_statement_feature_id);
    }
    ?>
</body>
</html>