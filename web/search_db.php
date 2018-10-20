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

$searchInput = $searchType = '';
$statement_exact = $statement_regexp = '';
$searchTargetColumn = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$searchInput = cleanInput($_POST["searchInput"]);
	$searchType = cleanInput($_POST["searchType"]);
	/*$db_copy = $db;*/

	switch ($searchType) {
		case 'patron':
			$db_patron_query_exact = 'SELECT id, username, full_name FROM patron WHERE username ~* \'' . preg_quote($searchInput) . '\' OR full_name ~* \'' . preg_quote($searchInput) . '\';';
			$patron_statement_exact = $db->prepare($db_patron_query_exact);
			$patron_statement_exact->execute();

			$db_patron_query_regexp = 'SELECT id, username, full_name FROM patron WHERE username ~* \'.*' . preg_quote($searchInput) . '.*\' OR full_name ~* \'.*' . preg_quote($searchInput) . '.*\';';
			$patron_statement_regexp = $db->prepare($db_patron_query_regexp);
			$patron_statement_regexp->execute();
			break;
		default:
	/*if (($searchType == 'featureTitle') || ($searchType == 'featureSetTitle')) {*/
		if ($searchType == 'featureTitle') {
			$searchTargetColumn = 'feature_title';
		}
		else if ($searchType == 'featureSetTitle') {
			$searchTargetColumn = 'feature_set_title';
		}
		else if ($searchType == 'featureYear') {
			$searchTargetColumn = 'feature_year';
		}
		else if ($searchType == 'format') {
			$searchTargetColumn = 'format';
		}

		/*$db_query_exact = 'SELECT id, feature_title, feature_year, format, format_year, feature_set_title, location, existing_loan FROM feature_view WHERE ' . $searchTargetColumn . ' = \'' . $searchInput . '\';';*/
		$db_query_exact = 'SELECT id, feature_title, feature_year, format, format_year, feature_set_title, location, existing_loan FROM feature_view WHERE ' . $searchTargetColumn . ' = \'' . preg_quote($searchInput) . '\';';
		$statement_exact = $db->prepare($db_query_exact);
		$statement_exact->execute();
		
		/*$db_query_regexp = 'SELECT id, feature_title, feature_year, format, format_year, feature_set_title, location, existing_loan FROM feature_view WHERE ' . $searchTargetColumn . ' ~* \'.*' . $searchInput . '.*\';';*/
		$db_query_regexp = 'SELECT id, feature_title, feature_year, format, format_year, feature_set_title, location, existing_loan FROM feature_view WHERE ' . $searchTargetColumn . ' ~* \'.*' . preg_quote($searchInput) . '.*\';';
		$statement_regexp = $db->prepare($db_query_regexp);
		$statement_regexp->execute();
	}
	/*else*/ /*if ($searchType == 'patron') {*/
	/*}*/
}

function showExactMatchResults($statement, $searchType) {
	/*if (($searchType == 'featureTitle') || ($searchType == 'featureSetTitle')) {
		echo '<table class="featureResults">';
	}
	else if ($searchType == 'patron') {
		echo '<table class="patronResults">';
	}
	echo '<thead><caption class="exactResultsTableCaption">Results Matching Search Exactly</caption></thead>';
	if (($searchType == 'featureTitle') || ($searchType == 'featureSetTitle')) {
		showFullListOfFeatures($statement);
	}
	else if ($searchType == 'patron') {
		showFullListOfPatrons($statement);
	}*/
	switch ($searchType) {
		case 'patron':
			echo '<table class="patronResults">';
			echo '<thead><caption class="regExpResultsTableCaption">Results at Least Partially Matching Search</caption></thead>';
			showFullListOfPatrons($statement);
			break;
		default:
			echo '<table class="featureResults">';
			echo '<thead><caption class="regExpResultsTableCaption">Results at Least Partially Matching Search</caption></thead>';
			showFullListOfFeatures($statement, $searchType);
	}
}

function showRegExpResults ($statement, $searchType) {
	/*if (($searchType == 'featureTitle') || ($searchType == 'featureSetTitle')) {
		echo '<table class="featureResults">';
	}
	else if ($searchType == 'patron') {
		echo '<table class="patronResults">';
	}
	echo '<thead><caption class="regExpResultsTableCaption">Results at Least Partially Matching Search</caption></thead>';
	if (($searchType == 'featureTitle') || ($searchType == 'featureSetTitle')) {
		showFullListOfFeatures($statement);
	}
	else if ($searchType == 'patron') {
		showFullListOfPatrons($statement);
	}*/
	switch ($searchType) {
		case 'patron':
			echo '<table class="patronResults">';
			echo '<thead><caption class="regExpResultsTableCaption">Results at Least Partially Matching Search</caption></thead>';
			showFullListOfPatrons($statement);
			break;
		default:
			echo '<table class="featureResults">';
			echo '<thead><caption class="regExpResultsTableCaption">Results at Least Partially Matching Search</caption></thead>';
			showFullListOfFeatures($statement, $searchType);
	}
}

function showFullListOfFeatures ($statement, $searchType) {
	/*if (($searchType == 'featureTitle') || ($searchType == 'featureSetTitle')) {
		echo '<table class="results">';
		echo '<thead><caption class="resultsTableCaption">Results at Least Partially Matching Search</caption></thead>';*/
		echo '<tr class="searchResultsHeaderRow"><th>ID</th><th>Feature Title</th><th>Feature Year</th><th>Format</th><th>Format Year</th>';
		echo '<th>Feature Set Title</th><th>Location</th><th>Existing Loan</th></tr>';
	/*}*/
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		if (($searchType == 'featureTitle') || ($searchType == 'featureSetTitle')) {
			echo '<tr><td class="id">' . $row['id'] . '</td>';
			echo '<td class="featureTitle">' . $row['feature_title'] . '</td>';
			echo '<td class="featureYear">' . $row['feature_year'] . '</td>';
			echo '<td class="format">' . $row['format'] . '</td>';
			echo '<td class="formatYear">' . $row['format_year'] . '</td>';
			echo '<td class="featureSetTitle">' . $row['feature_set_title'] . '</td>';
			echo '<td class="location">' . $row['location'] . '</td>';
			echo '<td class="existingLoan">' . $row['existing_loan'] . '</td></tr>';
		}
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

function showFullListOfPatrons($statement) {
	/*echo '<table class="results">';
	echo '<thead><caption class="resultsTableCaption">Results at Least Partially Matching Search</caption></thead>';*/
	echo '<tr class="searchResultsHeaderRow"><th>ID</th><th>username</th><th>Full Name</th></tr>';
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo '<tr><td class="id">' . $row['id'] . '</td>';
		echo '<td class="username">' . $row['username'] . '</td>';
		echo '<td class="fullName">' . $row['full_name'] . '</td></tr>';
	}
	echo '</table>';
}

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
		<input type="text" name="searchInput" title="Enter text for exact match or matching part of a title or name" value="<?php echo $searchInput ?>"><br />
		<label for="searchType">Search Type:</label><br />
		<div class="searchTypeOptions">
			<input type="radio" name="searchType" value="featureTitle" checked>Feature Title<br />
			<input type="radio" name="searchType" value="featureSetTitle">Feature Set Title<br />
			<input type="radio" name="searchType" value="featureYear">Feature Year<br />
			<input type="radio" name="searchType" value="format">Format<br />
			<input type="radio" name="searchType" value="patron">Patron<br />
		</div>
		<input type="submit" value="Search" class="submitButton">
	</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	/*if ($searchType == 'patron') {
		showExactMatchResults($patron_statement_exact, $searchType);
		showRegExpResults($patron_statement_regexp, $searchType);
	}
	else {
		showExactMatchResults($statement_exact, $searchType);
		showRegExpResults($statement_regexp, $searchType);
	}*/
	/*switch ($searchType) {
		case 'patron':
			showFullListOfPatrons($patron_statement_exact);
			showFullListOfPatrons($patron_statement_regexp);
			break;
		default:
			showFullListOfFeatures($statement_exact, $searchType);
			showFullListOfFeatures($statement_regexp, $searchType);
	}*/
	switch ($searchType) {
		case 'patron':
			showExactMatchResults($patron_statement_exact, $searchType);
			showRegExpResults($patron_statement_regexp, $searchType);
			break;
		default:
			showExactMatchResults($statement_exact, $searchType);
			showRegExpResults($statement_regexp, $searchType);
	}
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
		<li>https://www.w3schools.com/cssref/pr_font_font-style.asp</li>
		<li>https://dev.w3.org/html5/html-author/charref</li>
		<li>https://www.w3schools.com/php/php_switch.asp</li>
	</ul>
</body>
</html>