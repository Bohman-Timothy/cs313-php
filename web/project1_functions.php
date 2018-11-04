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
            $resultsTableClass = 'loanResults';
            $resultsCaptionClass = "exactResultsTableCaption";
            $tableCaption = '<span class="' . $resultsTableClass . '">Loan</span> Results Matching Search Exactly';
            showFullListOfLoans($statement, $tableCaption, $resultsTableClass, $resultsCaptionClass);
            break;
        default:
            switch ($searchType) {
                case 'patron':
                    $resultsTableClass = 'patronResults';
                    $resultsCaptionClass = "exactResultsTableCaption";
                    $tableCaption = '<span class="' . $resultsTableClass . '">Patron</span> Results Matching Search Exactly';
                    showFullListOfPatrons($statement, $tableCaption, $resultsTableClass, $resultsCaptionClass);
                    break;
                default:
                    $resultsTableClass = 'featureResults';
                    $resultsCaptionClass = "exactResultsTableCaption";
                    $tableCaption = '<span class="' . $resultsTableClass . '">Feature</span> Results Matching Search Exactly';
                    showFullListOfFeatures($statement, $tableCaption, $resultsTableClass, $resultsCaptionClass);
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
                    $resultsTableClass = 'loanResults';
                    $resultsCaptionClass = "regExpResultsTableCaption";
                    $tableCaption = '<span class="' . $resultsTableClass . '">Loan</span> Results Only Partially Matching Search';
                    showFullListOfLoans($statement, $tableCaption, $resultsTableClass, $resultsCaptionClass);
            }
            break;
        default:
            switch ($searchType) {
                case 'patron':
                    $resultsTableClass = 'patronResults';
                    $resultsCaptionClass = "regExpResultsTableCaption";
                    $tableCaption = '<span class="' . $resultsTableClass . '">Patron</span> Results Only Partially Matching Search';
                    showFullListOfPatrons($statement, $tableCaption, $resultsTableClass, $resultsCaptionClass);
                    break;
                case 'featureYear':
                    break;
                case 'formatYear':
                    break;
                default:
                    $resultsTableClass = 'featureResults';
                    $resultsCaptionClass = "regExpResultsTableCaption";
                    $tableCaption = '<span class="' . $resultsTableClass . '">Feature</span> Results Only Partially Matching Search';
                    showFullListOfFeatures($statement, $tableCaption, $resultsTableClass, $resultsCaptionClass);
            }
    }
}

function showFullListOfFeatures ($statement, $tableCaption, $resultsTableClass, $resultsCaptionClass) {
    echo '<table class="' . $resultsTableClass . '">';
    echo '<thead><caption class="' . $resultsCaptionClass . '">' . $tableCaption . '</caption></thead>';
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

function showFullListOfPatrons($statement, $tableCaption, $resultsTableClass, $resultsCaptionClass) {
    echo '<table class="' . $resultsTableClass . '">';
    echo '<thead><caption class="' . $resultsCaptionClass . '">' . $tableCaption . '</caption></thead>';
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

function showFullListOfLoans($statement, $tableCaption, $resultsTableClass, $resultsCaptionClass) {
    echo '<table class="' . $resultsTableClass . '">';
    echo '<thead><caption class="' . $resultsCaptionClass . '">' . $tableCaption . '</caption></thead>';
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

function setFeatureLoan($featureId, $db) {
    //insert new loan
    $db_insert_new_loan_query = 'INSERT INTO loan (fk_feature_loaned, fk_borrower, fk_updated_by) VALUES (:featureId, :userLoggedIn, :userLoggedIn);';
    echo '<p>' . $db_insert_new_loan_query . '</p>';
    $db_insert_new_loan_statement = $db->prepare($db_insert_new_loan_query);
    $db_insert_new_loan_statement->execute(array(':featureId' => $featureId, ':userLoggedIn' => $_SESSION["userId"]));
    $loanId = $db->lastInsertId('loan_id_seq');

    //insert new current_loan, or update a feature's entry in the current_loan table
    $db_query_current_loan = 'SELECT id FROM current_loan WHERE fk_feature = :featureId;';
    $db_statement_current_loan = $db->prepare($db_query_current_loan);
    $db_statement_current_loan->execute(array(':featureId' => $featureId));
    $row_single_result = $db_statement_current_loan->fetch(PDO::FETCH_ASSOC);
    $currentLoanId = $row_single_result['id'];

    if ($currentLoanId == '') { //insert new current_loan for the selected feature
        $db_query_insert_current_loan = 'INSERT INTO current_loan (fk_feature, fk_loan, fk_created_by, fk_updated_by) VALUES (:featureId, :loanId, :userId, :userId);';
        $db_statement_insert_current_loan = $db->prepare($db_query_insert_current_loan);
        $db_statement_insert_current_loan->execute(array(':featureId' => $featureId, ':loanId' => $loanId, ':userId' => $_SESSION["userId"]));
    }
    else { //update existing current_loan fields associated with the selected feature
        $db_query_update_current_loan = 'UPDATE current_loan SET fk_loan = :loanId, updated_at = :updatedAt, fk_updated_by = :userId WHERE fk_feature = :featureId;';
        $db_statement_update_current_loan = $db->prepare($db_query_update_current_loan);
        $db_statement_update_current_loan->execute(array(':featureId' => $featureId, ':loanId' => $loanId, ':updatedAt' => 'now()', ':userId' => $_SESSION["userId"]));
    }
}

function returnFeatureLoan($featureId, $db) {
    //get id of current loan for the selected feature
    $db_query_current_loan = 'SELECT id, fk_loan FROM current_loan WHERE fk_feature = :featureId;';
    $db_statement_current_loan = $db->prepare($db_query_current_loan);
    $db_statement_current_loan->execute(array(':featureId' => $featureId));
    $row_single_result  = $db_statement_current_loan->fetch(PDO::FETCH_ASSOC);
    $loanId = $row_single_result['fk_loan'];

    //update loan to reflect return date
    $db_update_loan_query = 'UPDATE loan SET return_date = :returnDate, updated_at = :updatedAt, fk_updated_by = :userLoggedIn WHERE id = :loanId;';
    $db_update_loan_statement = $db->prepare($db_update_loan_query);
    $db_update_loan_statement->execute(array(':returnDate' => 'now()', ':loanId' => $loanId, ':updatedAt' => 'now()', ':userLoggedIn' => $_SESSION["userId"]));

    $db_query_update_current_loan = 'UPDATE current_loan SET fk_loan = :loanId, updated_at = :updatedAt, fk_updated_by = :userLoggedIn WHERE fk_feature = :featureId;';
    $db_statement_update_current_loan = $db->prepare($db_query_update_current_loan);
    $db_statement_update_current_loan->execute(array(':featureId' => $featureId, ':loanId' => NULL, ':updatedAt' => 'now()', ':userLoggedIn' => $_SESSION["userId"]));
}
?>
