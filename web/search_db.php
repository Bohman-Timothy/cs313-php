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

$searchInput = $searchType = $searchLoans = $searchCurrentLoans = '';
$statement_exact = $statement_regexp = '';
$searchTargetColumn = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$searchInput = cleanInput($_POST["searchInput"]);
	$searchType = cleanInput($_POST["searchType"]);
	$searchLoans = cleanInput($_POST["searchLoans"]);
	$searchCurrentLoans = cleanInput($_POST["searchCurrentLoans"]);

	/* Hidden feature to allow viewing all rows at once */
	if ($searchInput == '_ALL') {
		$searchInput = '';
	}

	switch ($searchType) {
		case 'patron':
			switch ($searchLoans) {
				case true:
					$db_patron_query_exact = 'SELECT id, loan_date, return_date, username, full_name, feature_title, feature_year, format, format_year, feature_set_title FROM loan_view WHERE username = \'' . preg_quote($searchInput) . '\' OR full_name = \'' . preg_quote($searchInput) . '\';';

					$db_patron_query_regexp = 'SELECT id, loan_date, return_date, username, full_name, feature_title, feature_year, format, format_year, feature_set_title FROM loan_view WHERE username ~* \'.*' . preg_quote($searchInput) . '.*\' OR full_name ~* \'.*' . preg_quote($searchInput) . '.*\';';
					break;
				default:
					$db_patron_query_exact = 'SELECT id, username, full_name FROM patron WHERE username ~* \'' . preg_quote($searchInput) . '\' OR full_name ~* \'' . preg_quote($searchInput) . '\';';

					$db_patron_query_regexp = 'SELECT id, username, full_name FROM patron WHERE username ~* \'.*' . preg_quote($searchInput) . '.*\' OR full_name ~* \'.*' . preg_quote($searchInput) . '.*\';';
			}
			$patron_statement_exact = $db->prepare($db_patron_query_exact);
			$patron_statement_exact->execute();

			$patron_statement_regexp = $db->prepare($db_patron_query_regexp);
			$patron_statement_regexp->execute();
			break;
		default:
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
			switch ($searchLoans) {
				case true:
					$db_query_exact = 'SELECT id, loan_date, return_date, username, full_name, feature_title, feature_year, format, format_year, feature_set_title FROM loan_view WHERE ' . $searchTargetColumn . ' = \'' . preg_quote($searchInput) . '\';';

					$db_query_regexp = 'SELECT id, loan_date, return_date, username, full_name, feature_title, feature_year, format, format_year, feature_set_title FROM loan_view WHERE ' . $searchTargetColumn . ' ~* \'.*' . preg_quote($searchInput) . '.*\';';
					break;
				default:
					switch ($searchType) {
						case 'featureYear':
							$db_query_exact = $db_query_regexp = 'SELECT id, feature_title, feature_year, format, format_year, feature_set_title, location, existing_loan FROM feature_view WHERE ' . $searchTargetColumn . ' = \'' . preg_quote($searchInput) . '\';';
							break;
						default:
							$db_query_exact = 'SELECT id, feature_title, feature_year, format, format_year, feature_set_title, location, existing_loan FROM feature_view WHERE ' . $searchTargetColumn . ' = \'' . preg_quote($searchInput) . '\';';

							$db_query_regexp = 'SELECT id, feature_title, feature_year, format, format_year, feature_set_title, location, existing_loan FROM feature_view WHERE ' . $searchTargetColumn . ' ~* \'.*' . preg_quote($searchInput) . '.*\';';
					}
			}
			$statement_exact = $db->prepare($db_query_exact);
			$statement_exact->execute();

			$statement_regexp = $db->prepare($db_query_regexp);
			$statement_regexp->execute();
	}
}

function showExactMatchResults($statement, $searchType, $searchLoans, $searchCurrentLoans) {
	switch ($searchLoans) {
		case true:
			echo '<table class="loanResults">';
			echo '<thead><caption class="exactResultsTableCaption">Results Matching Search Exactly</caption></thead>';
			showFullListOfLoans($statement);
			break;
		default:
			switch ($searchType) {
				case 'patron':
					echo '<table class="patronResults">';
					echo '<thead><caption class="exactResultsTableCaption">Results Matching Search Exactly</caption></thead>';
					showFullListOfPatrons($statement);
					break;
				default:
					echo '<table class="featureResults">';
					echo '<thead><caption class="exactResultsTableCaption">Results Matching Search Exactly</caption></thead>';
					showFullListOfFeatures($statement, $searchType);
			}
	}
}

function showRegExpResults ($statement, $searchType, $searchLoans, $searchCurrentLoans) {
	switch ($searchLoans) {
		case true:
			echo '<table class="loanResults">';
			echo '<thead><caption class="regExpResultsTableCaption">Results at Least Partially Matching Search</caption></thead>';
			showFullListOfLoans($statement);
			break;
		default:
			switch ($searchType) {
				case 'patron':
					echo '<table class="patronResults">';
					echo '<thead><caption class="regExpResultsTableCaption">Results at Least Partially Matching Search</caption></thead>';
					showFullListOfPatrons($statement);
					break;
				case 'featureYear':
					break;
				default:
					echo '<table class="featureResults">';
					echo '<thead><caption class="regExpResultsTableCaption">Results at Least Partially Matching Search</caption></thead>';
					showFullListOfFeatures($statement, $searchType);
			}
	}
}

function showFullListOfFeatures ($statement, $searchType) {
		echo '<tr class="searchResultsHeaderRow"><th>ID</th><th>Feature Title</th><th>Feature Year</th><th>Format</th><th>Format Year</th>';
		echo '<th>Feature Set Title</th><th>Location</th><th>Existing Loan</th></tr>';

	$counter = 0;
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
		$counter++;
		}
	}
	if ($counter == 0) {
		echo '</table> <p class="noResults">No results</p>';
	}
	else {
		echo '</table>';
	}
}

function showFullListOfPatrons($statement) {
	echo '<tr class="searchResultsHeaderRow"><th>ID</th><th>Username</th><th>Full Name</th></tr>';
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		if ($row['id'] != '') {
			echo '<tr><td class="id">' . $row['id'] . '</td>';
			echo '<td class="username">' . $row['username'] . '</td>';
			echo '<td class="fullName">' . $row['full_name'] . '</td></tr>';
		}
		else {
			echo '<tr><td class="noResults">No results</td></tr>';
		}
	}
	echo '</table>';
}

function showFullListOfLoans($statement) {
	echo '<tr class="searchResultsHeaderRow"><th>ID</th><th>Loan Date</th><th>Return Date</th><th>Username</th><th>Full Name</th><th>Feature Title</th><th>Feature Year</th><th>Format</th><th>Format Year</th><th>Feature Set Title</th></tr>';
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		if ($row['id'] != '') {
			echo '<tr><td class="id">' . $row['id'] . '</td>';
			echo '<td class="loanDate">' . $row['loan_date'] . '</td>';
			echo '<td class="returnDate">' . $row['return_date'] . '</td>';
			echo '<td class="username">' . $row['username'] . '</td>';
			echo '<td class="fullName">' . $row['full_name'] . '</td>';
			echo '<td class="featureTitle">' . $row['feature_title'] . '</td>';
			echo '<td class="featureYear">' . $row['feature_year'] . '</td>';
			echo '<td class="format">' . $row['format'] . '</td>';
			echo '<td class="formatYear">' . $row['format_year'] . '</td>';
			echo '<td class="featureSetTitle">' . $row['feature_set_title'] . '</td>';
		}
		else {
			echo '<tr><td class="noResults">No results</td></tr>';
		}
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
    <link rel="stylesheet" href="project1_db.css">
    <script src="project1.js" charset="UTF-8"></script>
</head>
<body>
	<h1>Search the Feature Database</h1>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="search">
		<label for="searchInput">Search Value:</label>
		<input type="text" name="searchInput" title="Enter text for exact match or matching part of a title or name" required value="<?php echo $searchInput ?>"><br />
		<label for="searchType">Search Type:</label><br />
		<div class="searchTypeOptions">
			<input type="radio" name="searchType" value="featureTitle" id="featureTitleOption_id" checked>
			<label for="featureTitleOption_id">Feature Title</label><br />
			<input type="radio" name="searchType" value="featureSetTitle" id="featureSetTitleOption_id">
			<label for="featureSetTitleOption_id">Feature Set Title</label><br />
			<input type="radio" name="searchType" value="featureYear" id="featureYearOption_id">
			<label for="featureYearOption_id">Feature Year</label><br />
			<input type="radio" name="searchType" value="format" id="formatOption_id">
			<label for="formatOption_id">Format</label><br />
			<input type="radio" name="searchType" value="patron" id="patronOption_id">
			<label for="patronOption_id">Patron</label><br />
		</div>
		<input type="checkbox" name="searchLoans" id="searchLoans_id"> <!-- onclick="showCurrentLoansOption()" -->
		<label for="searchLoansOnly_id">Search Loans Only</label><br />
		<!-- <div id="currentLoans_id">
			<input type="checkbox" name="searchCurrentLoans" id="searchCurrentLoans_id" checked>
			<label for="searchCurrentLoans_id">Current Loans Only</label><br />
		</div> -->
		<p id="searchAllFeatures_id">Searches all features or all patrons or all loans</p>
		<input type="submit" value="Search" class="submitButton">
	</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo '<p>Searched for: ' . $searchInput . '</p>';
	switch ($searchType) {
		case 'patron':
			showExactMatchResults($patron_statement_exact, $searchType, $searchLoans, $searchCurrentLoans);
			showRegExpResults($patron_statement_regexp, $searchType, $searchLoans, $searchCurrentLoans);
			break;
		default:
			showExactMatchResults($statement_exact, $searchType, $searchLoans, $searchCurrentLoans);
			showRegExpResults($statement_regexp, $searchType, $searchLoans, $searchCurrentLoans);
	}
}
?>

	<h2 id="referencesHeading_id" onclick="showReferences()">References</h2>
	<p id="clickToShowReferences_id">Click heading to show references</p>
	<div id="referencesList_id">
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
		<li>https://stackoverflow.com/questions/8529656/how-do-i-convert-a-string-to-a-number-in-php/8529687</li>
		<li>https://www.w3schools.com/howto/howto_js_display_checkbox_text.asp</li>
		<li>https://www.w3schools.com/sql/sql_and_or.asp</li>
		<li>https://stackoverflow.com/questions/8922002/attach-event-listener-through-javascript-to-radio-button</li>
	</ul>
	</div>
</body>
</html>