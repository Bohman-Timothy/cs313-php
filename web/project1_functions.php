<?php
if (!isset($_SESSION["loggedIn"])) {
    $_SESSION["loggedIn"] = false;
}

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

function cleanInput($data) {
    $data = trim($data);
    return $data;
}

function showExactMatchResults($statement, $searchType, $searchLoans, $searchCurrentLoans) {
    switch ($searchLoans) {
        case true:
            echo '<table class="loanResults">';
            echo '<thead><caption class="exactResultsTableCaption"><span class="loanResults">Loan</span> Results Matching Search Exactly</caption></thead>';
            showFullListOfLoans($statement);
            break;
        default:
            switch ($searchType) {
                case 'patron':
                    echo '<table class="patronResults">';
                    echo '<thead><caption class="exactResultsTableCaption"><span class="patronResults">Patron</span> Results Matching Search Exactly</caption></thead>';
                    showFullListOfPatrons($statement);
                    break;
                default:
                    echo '<table class="featureResults">';
                    echo '<thead><caption class="exactResultsTableCaption"><span class="featureResults">Feature</span> Results Matching Search Exactly</caption></thead>';
                    showFullListOfFeatures($statement);
            }
    }
}

function showRegExpResults ($statement, $searchType, $searchLoans, $searchCurrentLoans) {
    switch ($searchLoans) {
        case true:
            switch ($searchType) {
                case 'featureYear':
                    break;
                case 'formatYear':
                    break;
                default:
                    echo '<table class="loanResults">';
                    echo '<thead><caption class="regExpResultsTableCaption"><span class="loanResults">Loan</span> Results Only Partially Matching Search</caption></thead>';
                    showFullListOfLoans($statement);
            }
            break;
        default:
            switch ($searchType) {
                case 'patron':
                    echo '<table class="patronResults">';
                    echo '<thead><caption class="regExpResultsTableCaption"><span class="patronResults">Patron</span> Results Only Partially Matching Search</caption></thead>';
                    showFullListOfPatrons($statement);
                    break;
                case 'featureYear':
                    break;
                case 'formatYear':
                    break;
                default:
                    echo '<table class="featureResults">';
                    echo '<thead><caption class="regExpResultsTableCaption"><span class="featureResults">Feature</span> Results Only Partially Matching Search</caption></thead>';
                    showFullListOfFeatures($statement);
            }
    }
}

function showFullListOfFeatures ($statement) {
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
        if ($_SESSION["checkingForExistingLoan"] == true) {
            $_SESSION["existingLoan"] = $row['existing_loan'];
            echo 'existingLoan: ' . $_SESSION["existingLoan"];
        }
    }
    if ($counter == 0) {
        echo '</table> <p class=\'noResults\'>No results</p>';
        return false;
    }
    else {
        echo '</table>';
        return true;
    }
}

function showFullListOfPatrons($statement) {
    echo '<tr class="searchResultsHeaderRow"><th>ID</th><th>Username</th><th>Full Name</th></tr>';
    $counter = 0;
    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
        echo '<tr><td class="id">' . $row['id'] . '</td>';
        echo '<td class="username">' . $row['username'] . '</td>';
        echo '<td class="fullName">' . $row['full_name'] . '</td></tr>';
        $counter++;
    }
    if ($counter == 0) {
        echo '</table> <p class=\'noResults\'>No results</p>';
    }
    else {
        echo '</table>';
    }
}

function showFullListOfLoans($statement) {
    echo '<tr class="searchResultsHeaderRow"><th>ID</th><th>Loan Date</th><th>Return Date</th><th>Username</th><th>Full Name</th><th>Feature Title</th><th>Feature Year</th><th>Format</th><th>Format Year</th><th>Feature Set Title</th></tr>';
    $counter = 0;
    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
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
        $counter++;
    }
    if ($counter == 0) {
        echo '</table> <p class=\'noResults\'>No results</p>';
    }
    else {
        echo '</table>';
    }
}

/* Note: remove existing_loan */
function setFeatureLoan($featureId, $db) {
    //insert new loan
    $db_insert_new_loan_query = 'INSERT INTO loan (fk_feature_loaned, fk_borrower, updated_by) VALUES (:featureId, :userLoggedIn, :userLoggedIn);';
    echo '<p>' . $db_insert_new_loan_query . '</p>';
    $db_insert_new_loan_statement = $db->prepare($db_insert_new_loan_query);
    $db_insert_new_loan_statement->execute(array(':featureId' => $featureId, ':userLoggedIn' => $_SESSION["userId"]));
    echo '<p>Successfully inserted new loan</p>';
    $loanId = $db->lastInsertId('loan_id_seq');

    //insert new current_loan, or update a feature's entry in the table
    $db_query_current_loan = 'SELECT id FROM current_loan WHERE fk_feature = :featureId;';
    echo '<p>' . $db_query_current_loan . '</p>';
    $db_statement_current_loan = $db->prepare($db_query_current_loan);
    $db_statement_current_loan->execute(array(':featureId' => $featureId));
    while ($row = $db_statement_current_loan->fetch(PDO::FETCH_ASSOC)) {
        $currentLoanId = $row['id'];
    }
    /*$singleResult = $db_statement_current_loan->fetch(PDO::FETCH_ASSOC);
    $currentLoanId = $singleResult['fk_current_loan'];*/
    echo '<p>Successfully checked for existing current loan field associated with selected feature</p>';
    if ($currentLoanId == '') { //insert new current_loan for the selected feature
        echo '<p>Inserting new current loan</p>';
        $db_query_insert_current_loan = 'INSERT INTO current_loan (fk_feature, fk_loan) VALUES (:featureId, :loanId);';
        $db_statement_insert_current_loan = $db->prepare($db_query_insert_current_loan);
        $db_statement_insert_current_loan->execute(array(':featureId' => $featureId, ':loanId' => $loanId));
        echo '<p>Successfully inserted new current loan</p>';
    }
    else { //update existing current_loan fields associated with the selected feature
        echo '<p>Updating current loan status for feature #' . $featureId . '</p>';
        $db_query_update_current_loan = 'UPDATE current_loan SET fk_loan = :loanId, updated_at = :updatedAt WHERE fk_feature = :featureId;';
        echo '<p>' . $db_query_update_current_loan . '</p>';
        $db_statement_update_current_loan = $db->prepare($db_query_update_current_loan);
        $db_statement_update_current_loan->execute(array(':featureId' => $featureId, ':loanId' => $loanId, ':updatedAt' => 'now()'));
        echo '<p>Successfully updated current loan status for feature #' . $featureId . '</p>';
    }

    //update feature loan status to "Yes"
    echo '<p>Updating ID: ' . $featureId . '</p>';
    $db_update_loan_status_query = 'UPDATE feature SET existing_loan = :existingLoan, updated_at = :updatedAt WHERE id = :featureId;';
    echo '<p>' . $db_update_loan_status_query . '</p>';
    $db_update_loan_status_statement = $db->prepare($db_update_loan_status_query);
    $db_update_loan_status_statement->execute(array(':featureId' => $featureId, ':existingLoan' => 'true', ':updatedAt' => 'now()'));
    echo '<p>Successfully updated loan status to "Yes"</p>';
}

/* Note: remove existing_loan */
function returnFeatureLoan($featureId, $db) {
    //get id of current loan for the selected feature
    $db_query_current_loan = 'SELECT id, fk_loan FROM current_loan WHERE fk_feature = :featureId;';
    $db_statement_current_loan = $db->prepare($db_query_current_loan);
    $db_statement_current_loan->execute(array(':featureId' => $featureId));
    while ($row = $db_statement_current_loan->fetch(PDO::FETCH_ASSOC)) {
        $loanId = $row['fk_loan'];
    }
    /*$singleResult = $db_statement_current_loan->fetch(PDO::FETCH_ASSOC);
    $currentLoanId = $singleResult['id'];
    $loanId = $currentLoanId['fk_loan'];*/

    //update loan to reflect return date
    $db_update_loan_query = 'UPDATE loan SET return_date = :returnDate, updated_at = :updatedAt, updated_by = :userLoggedIn WHERE id = :loanId;';
    echo '<p>' . $db_update_loan_query . '</p>';
    $db_update_loan_statement = $db->prepare($db_update_loan_query);
    $db_update_loan_statement->execute(array(':returnDate' => 'now()', ':loanId' => $loanId, ':updatedAt' => 'now()', ':userLoggedIn' => $_SESSION["userId"]));
    echo '<p>Successfully updated loan to reflect return date</p>';

    $db_query_update_current_loan = 'UPDATE current_loan SET fk_loan = :loanId, updated_at = :updatedAt WHERE fk_feature = :featureId;';
    echo '<p>' . $db_query_update_current_loan . '</p>';
    $db_statement_update_current_loan = $db->prepare($db_query_update_current_loan);
    $db_statement_update_current_loan->execute(array(':featureId' => $featureId, ':loanId' => NULL, ':updatedAt' => 'now()'));
    echo '<p>Successfully updated current loan status to NULL for feature #' . $featureId . '</p>';

    //update feature loan status to "No"
    echo '<p>Updating ID: ' . $featureId . '</p>';
    $db_update_loan_status_query = 'UPDATE feature SET existing_loan = :existingLoan, updated_at = :updatedAt WHERE id = :featureId;';
    echo '<p>' . $db_update_loan_status_query . '</p>';
    $db_update_loan_status_statement = $db->prepare($db_update_loan_status_query);
    $db_update_loan_status_statement->execute(array(':featureId' => $featureId, ':existingLoan' => 'false', ':updatedAt' => 'now()'));
    echo '<p>Successfully updated loan status to "No"</p>';
}
?>
