<?php
session_start();
include 'project1_functions.php';

$searchInput = $searchType = $searchLoans = $searchCurrentLoans = '';
$statement_exact = $statement_regexp = '';
$searchTargetColumn = $searchOrder = $orderBy = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$searchInput = cleanInput($_POST["searchInput"]);
	$searchType = cleanInput($_POST["searchType"]);
	$searchLoans = cleanInput($_POST["searchLoans"]);
	$searchCurrentLoans = cleanInput($_POST["searchCurrentLoans"]);

	switch ($searchType) {
		case 'patron':
			$searchOrder = 'full_name';
			$orderBy = 'ORDER BY ' . $searchOrder . ' ASC';
			switch ($searchLoans) { //Search patrons in the loan table
				case true:
					$db_patron_query_exact = 'SELECT id, loan_date, return_date, username, full_name, feature_title, feature_year, format, format_year, feature_set_title FROM loan_view WHERE username = \'' . $searchInput . '\' OR full_name = \'' . $searchInput . '\' ' . $orderBy . ';';

					$db_patron_query_regexp = 'SELECT id, loan_date, return_date, username, full_name, feature_title, feature_year, format, format_year, feature_set_title FROM loan_view WHERE username ~* \'.*' . preg_quote($searchInput) . '.*\' OR full_name ~* \'.*' . preg_quote($searchInput) . '.*\' ' . $orderBy . ';';
					break;
				default: //Search patrons in the patron table
					$db_patron_query_exact = 'SELECT id, username, full_name FROM patron WHERE username = \'' . $searchInput . '\' OR full_name = \'' . $searchInput . '\' ' . $orderBy . ';';

					$db_patron_query_regexp = 'SELECT id, username, full_name FROM patron WHERE username ~* \'.*' . preg_quote($searchInput) . '.*\' OR full_name ~* \'.*' . preg_quote($searchInput) . '.*\' ' . $orderBy . ';';
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
            else if ($searchType == 'formatYear') {
                $searchTargetColumn = 'format_year';
            }
			
			if (($searchType == 'featureYear') || ($searchType == 'format') || ($searchType == 'formatYear')) {
				$orderBy = 'ORDER BY feature_title ASC, feature_set_title ASC';
			}
			else if ($searchType == 'featureSetTitle') {
				$orderBy = 'ORDER BY feature_set_title ASC, feature_title ASC';
			}
			else if ($searchType == 'featureTitle') {
				$orderBy = 'ORDER BY feature_title ASC, feature_set_title ASC';
			}
			
			switch ($searchLoans) { //Search features in the loan table
				case true:
					switch ($searchType) {
						case 'featureYear':
                            $db_query_exact = $db_query_regexp = 'SELECT id, loan_date, return_date, username, full_name, feature_title, feature_year, format, format_year, feature_set_title FROM loan_view WHERE ' . $searchTargetColumn . ' = \'' . $searchInput . '\' ' . $orderBy . ';';
                            break;
                        case 'formatYear':
							$db_query_exact = $db_query_regexp = 'SELECT id, loan_date, return_date, username, full_name, feature_title, feature_year, format, format_year, feature_set_title FROM loan_view WHERE ' . $searchTargetColumn . ' = \'' . $searchInput . '\' ' . $orderBy . ';';
							break;
						default: //featureTitle, featureSetTitle, format
							$db_query_exact = 'SELECT id, loan_date, return_date, username, full_name, feature_title, feature_year, format, format_year, feature_set_title FROM loan_view WHERE ' . $searchTargetColumn . ' = \'' . $searchInput . '\' ' . $orderBy . ';';

							$db_query_regexp = 'SELECT id, loan_date, return_date, username, full_name, feature_title, feature_year, format, format_year, feature_set_title FROM loan_view WHERE ' . $searchTargetColumn . ' ~* \'.*' . preg_quote($searchInput) . '.*\' ' . $orderBy . ';';
					}
					break;
				default: //Search features in the feature table
					switch ($searchType) {
						case 'featureYear':
                            $db_query_exact = $db_query_regexp = 'SELECT id, feature_title, feature_year, format, format_year, feature_set_title, location, existing_loan FROM feature_view WHERE ' . $searchTargetColumn . ' = \'' . preg_quote($searchInput) . '\' ' . $orderBy . ';';
                            break;
                        case 'formatYear':
							$db_query_exact = $db_query_regexp = 'SELECT id, feature_title, feature_year, format, format_year, feature_set_title, location, existing_loan FROM feature_view WHERE ' . $searchTargetColumn . ' = \'' . preg_quote($searchInput) . '\' ' . $orderBy . ';';
							break;
						default: //featureTitle, featureSetTitle, format
							$db_query_exact = 'SELECT id, feature_title, feature_year, format, format_year, feature_set_title, location, existing_loan FROM feature_view WHERE ' . $searchTargetColumn . ' = \'' . $searchInput . '\' ' . $orderBy . ';';

							$db_query_regexp = 'SELECT id, feature_title, feature_year, format, format_year, feature_set_title, location, existing_loan FROM feature_view WHERE ' . $searchTargetColumn . ' ~* \'.*' . preg_quote($searchInput) . '.*\' AND !~* \'' . $searchInput . '\' ' . $orderBy . ';';
					}
			}

			switch ($searchInput) { //Prevent error when matching empty string to an int for search by year
                case '':
                    switch ($searchType) {
                        case 'featureYear':
                            break;
                        case 'formatYear':
                            break;
                        default:
                            $statement_exact = $db->prepare($db_query_exact);
                            $statement_exact->execute();

                            $statement_regexp = $db->prepare($db_query_regexp);
                            $statement_regexp->execute();
                    }
                    break;
                default:
                    $statement_exact = $db->prepare($db_query_exact);
                    $statement_exact->execute();

                    $statement_regexp = $db->prepare($db_query_regexp);
                    $statement_regexp->execute();
            }
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<title>Search the Feature Database</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="project1.css">
    <script src="project1.js" charset="UTF-8"></script>
</head>
<body>
	<h1>Search the Feature Database</h1>
	<ul id="navbar">
		<h2>Menu</h2>
		<li class="active"><a href="search_db.php">Search the database</a></li>
		<li><a href="update_db.php">Update the database</a></li>
		<li><a href="checkout_db.php">Check Out or Return a Feature</a></li>
        <li>
            <?php
            if ($_SESSION["loggedIn"] == true) {
                echo '<a href="login_db.php">Sign Out or Switch User</a><br/><span class="loggedInAsUser">Logged in as ' . $_SESSION["user"] . '</span>';
            }
            else {
                echo '<a href="login_db.php">Sign In</a>';
            }
            ?></li>
	</ul>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="search" id="searchForm_id">
        <h2>Enter data to search the database</h2>
		<label for="searchInput">Search Value:</label>
		<input type="text" name="searchInput" title="Enter text for exact match or matching part of a title or name" value="<?php echo $searchInput ?>"><br />
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
            <input type="radio" name="searchType" value="formatYear" id="formatYearOption_id">
            <label for="formatYearOption_id">Format Year</label><br />
			<input type="radio" name="searchType" value="patron" id="patronOption_id">
			<label for="patronOption_id">Patron</label><br />
		</div>
		<input type="checkbox" name="searchLoans" id="searchLoansOnly_id"> <!-- onclick="showCurrentLoansOption()" -->
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
	echo '<p class="statusMessage">Searched for: ';
	if (($searchInput == '') && ($searchType != 'featureYear') && ($searchType != 'formatYear')) {
        echo 'ALL DATABASE ENTRIES </p>';
    }
    else {
        echo $searchInput . '</p>';
    }
	switch ($searchType) {
		case 'patron':
			showExactMatchResults($patron_statement_exact, $searchType, $searchLoans, $searchCurrentLoans);
			showRegExpResults($patron_statement_regexp, $searchType, $searchLoans, $searchCurrentLoans);
			break;
		default:
            switch ($searchInput) { //Prevent error when matching empty string to an int for search by year
                case '':
                    switch ($searchType) {
                        case 'featureYear':
                            break;
                        case 'formatYear':
                            break;
                        default:
                            showExactMatchResults($statement_exact, $searchType, $searchLoans, $searchCurrentLoans);
                            showRegExpResults($statement_regexp, $searchType, $searchLoans, $searchCurrentLoans);
                    }
                    break;
                default:
                    showExactMatchResults($statement_exact, $searchType, $searchLoans, $searchCurrentLoans);
                    showRegExpResults($statement_regexp, $searchType, $searchLoans, $searchCurrentLoans);
            }
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
		<li>https://www.lifewire.com/display-none-vs-visibility-hidden-3466884</li>
		<li>https://stackoverflow.com/questions/17630945/is-there-an-opposite-to-displaynone</li>
		<li>https://stackoverflow.com/questions/1847460/how-can-i-make-a-float-top-with-css</li>
		<li>https://www.w3schools.com/php/func_date_date_format.asp</li>
        <li><a href="https://stackoverflow.com/questions/547821/two-submit-buttons-in-one-form">Stack Overflow - Two submit buttons in one form</a></li>
        <li><a href="https://stackoverflow.com/questions/18725078/bypass-html-required-attribute-when-submitting">Stack Overflow - Bypass HTML required attribute when submitting</a></li>
        <li><a href="https://www.w3schools.com/css/css_form.asp">W3Schools - CSS Forms</a></li>
        <li><a href="https://www.w3schools.com/cssref/sel_focus.asp">W3Schools - CSS :focus Selector</a></li>
        <li><a href="https://www.w3schools.com/jsref/jsref_concat_string.asp">W3Schools - JavaScript String concat() Method</a></li>
        <li><a href="https://www.w3schools.com/jsref/prop_radio_checked.asp">W3Schools - Input Radio checked Property</a></li>
        <li><a href="https://www.w3schools.com/php/php_sessions.asp">W3Schools - PHP 5 Sessions</a></li>
        <li><a href="https://www.johnmorrisonline.com/build-php-login-form-using-sessions/">How to Build a PHP Login Form Using Sessions</a></li>
        <li><a href="https://www.w3schools.com/sql/sql_alter.asp">W3Schools - SQL ALTER TABLE statement</a></li>
        <li><a href="https://www.plus2net.com/php_tutorial/array-session.php">PHP session array variable push</a></li>
        <li><a href="https://stackoverflow.com/questions/4227043/how-do-i-cancel-form-submission-in-submit-button-onclick-event">Stack Overflow - How do I cancel form submission in submit button onclick event?</a></li>
        <li><a href="https://www.postgresql.org/message-id/4717EA47.2080701%40att.net">PostgreSQL - Re: Drop Not Null</a></li>
        <li><a href="https://stackoverflow.com/questions/512451/how-can-i-add-a-column-to-a-postgresql-database-that-doesnt-allow-nulls">Stack Overflow - How to add a not null column to a PostgreSQL database</a></li>
        <li><a href=""></a></li>
	</ul>
	</div>
</body>
</html>