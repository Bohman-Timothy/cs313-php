<?php
try
{
	$dbUrl = getenv('DATABASE_URL');
	
	$dbOpts = parse_url($dbUrl);
	
	$dbHost = $dbOpts["host"];
	$dbPort = $dbOpts["port"];
	$dbUser = $dbOpts["user"];
	$dbPassword = $dbOpts["pass"];
	$dbName = ltrim($dbOpts["path"],'/');

	$db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
	
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $ex)
{
	echo 'Error!: ' . $ex->getMessage();
	die();
}

$searchInput = $searchType = $statement = $statement_regexp = $searchTargetColumn = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$searchInput = cleanInput($_POST["searchInput"]);
	$searchType = cleanInput($_POST["searchType"]);
	
	if ($searchType == 'featureTitle') {
		$searchTargetColumn = 'feature_title';
	}
	/*else if ($searchType == 'featureSetTitle') {
		$searchTargetColumn = 'feature_set_title';
	}*/
	searchFeatureExact($searchInput, $searchTargetColumn);
	searchRegExp($searchInput, $searchTargetColumn);
}

function searchFeatureExact ($searchInput, $searchTargetColumn) {
	$statement = $db->prepare('SELECT id, feature_title, feature_year, format, format_year, feature_set_title, location, existing_loan FROM feature_view WHERE feature_title=:feature_title');
	$statement->bindValue(':feature_title', $searchInput, PDO::PARAM_INT);
	$statement->execute();
}

function searchRegExp ($searchInput, $searchTargetColumn) {
	/*$db_expression = 'SELECT id, feature_title, feature_year, format,
		format_year, feature_set_title, location, existing_loan
		FROM feature_view
		WHERE ' . $searchTargetColumn .' ~* \'.*' . $searchInput . '.*\'';
	$statement_regexp = $db->prepare($db_expression);
	$statement_regexp->execute();*/
}

function showExactMatchResults($statement) {
	echo '<table class="featureResults">';
	echo '<thead><caption>Results Matching Search Exactly</caption></thead>';
	showFullListOfFeatures($statement);
}

function showRegExpResults ($statement) {
	echo '<table class="featureResults">';
	echo '<thead><caption>Results at Least Partially Matching Search</caption></thead>';
	showFullListOfFeatures($statement);
}

function showFullListOfFeatures ($statement) {
	echo '<tr class="searchResultsHeaderRow"><th>ID</th><th>Feature Title</th><th>Feature Year</th><th>Format</th><th>Format Year</th>';
	echo '<th>Feature Set Title</th><th>Location</th><th>Existing Loan</th></tr>';
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo '<tr><td class="id">' . $row['id'] . '</td>';
		echo '<td class="featureTitle">' . $row['feature_title'] . '</td>';
		echo '<td class="featureYear">' . $row['feature_year'] . '</td>';
		echo '<td class="format">' . $row['format'] . '</td>';
		echo '<td class="formatYear">' . $row['format_year'] . '</td>';
		echo '<td class="featureSetTitle">' . $row['feature_set_title'] . '</td>';
		echo '<td class="location">' . $row['location'] . '</td>';
		echo '<td class="existingLoan">' . $row['existing_loan'] . '</td></tr>';
	}
	echo '</table>';
}

/*function showFullListOfFeaturesRegexp($statement_regexp) {	
	echo '<table class="featureResults"> <thead><caption>Features Matching Search: ';
	echo $search . '</caption></thead>';
	echo '<tr class="searchResultsHeaderRow"><th>ID</th><th>Feature Title</th><th>Feature Year</th><th>Format</th><th>Format Year</th>';
	echo '<th>Feature Set Title</th><th>Location</th><th>Existing Loan</th></tr>';
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo '<tr><td class="id">' . $row['id'] . '</td>';
		echo '<td class="featureTitle">' . $row['feature_title'] . '</td>';
		echo '<td class="featureYear">' . $row['feature_year'] . '</td>';
		echo '<td class="format">' . $row['format'] . '</td>';
		echo '<td class="formatYear">' . $row['format_year'] . '</td>';
		echo '<td class="featureSetTitle">' . $row['feature_set_title'] . '</td>';
		echo '<td class="location">' . $row['location'] . '</td>';
		echo '<td class="existingLoan">' . $row['existing_loan'] . '</td></tr>';
	}
	echo '</table>';
}*/

function cleanInput($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Search the Feature Database</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/inconsolata" type="text/css"/>
    <link rel="stylesheet" href="project1_db.css">
</head>
<body>
	<h1>Search the Feature Database</h1>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label for="searchInput">Search Value:</label>
		<input type="text" name="searchInput" title="Text must match exactly" value="<?php echo $search ?>"><br />
		<label for="searchType">Search Type:</label><br />
		<div class="searchTypeOptions">
			<input type="radio" name="searchType" value="featureTitle" checked>Feature Title<br />
			<input type="radio" name="searchType" value="featureSetTitle">Feature Set Title<br />
		</div>
		<input type="submit" value="Search" class="submitButton">
	</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	showExactMatchResults($statement);
	showRegExpResults($statement_regexp);
}
?>

	<h2>References</h2>
	<ul>
		<li>https://stackoverflow.com/questions/2491068/does-height-and-width-not-apply-to-span/37876264</li>
		<li>https://stackoverflow.com/questions/5684144/how-to-completely-remove-borders-from-html-table</li>
		<li><a href="https://stackoverflow.com/questions/35787892/default-value-in-select-query-for-null-values-in-postgres">Default value if null and cast data to another type</a></li>
		<li>https://www.rapidtables.com/web/html/html-codes.html</li>
		<li>https://www.regular-expressions.info/postgresql.html</li>
		<li>https://www.regular-expressions.info/numericranges.html</li>
		<li>https://www.w3schools.com/html/html_forms.asp</li>
	</ul>
</body>
</html>