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
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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
                    showFullListOfFeatures($statement);
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

/* Note: change existing_loan from boolean to the id of the loan itself*/
function setFeatureLoan($featureId, $db) {
    //insert new loan
    $db_insert_new_loan_query = 'INSERT INTO loan (fk_feature_loaned, fk_borrower) VALUES (:featureId, :userLoggedIn)';
    echo '<p>' . $db_insert_new_loan_query . '</p>';
    $db_insert_new_loan_statement = $db->prepare($db_insert_new_loan_query);
    $db_insert_new_loan_statement->execute(array(':featureId' => $featureId, ':userLoggedIn' => $_SESSION["userId"]));
    echo '<p>Successfully inserted new loan</p>';
    $currentLoanId = $db->lastInsertId('loan_id_seq');

    //update feature loan status to "Yes" and set currentLoan to the ID of the new loan
    echo '<p>Updating ID: ' . $featureId . '</p>';
    $db_update_loan_status_query = 'UPDATE feature SET existing_loan = :existingLoan, fk_current_loan = :currentLoan WHERE id = :featureId;';
    echo '<p>' . $db_update_loan_status_query . '</p>';
    $db_update_loan_status_statement = $db->prepare($db_update_loan_status_query);
    $db_update_loan_status_statement->execute(array(':featureId' => $featureId, ':existingLoan' => 'true', ':currentLoan' => $currentLoanId));
    echo '<p>Successfully updated loan status to "Yes"</p>';
}

/* Note: change existing_loan from boolean to the id of the loan itself*/
function returnFeatureLoan($featureId, $db) {
    //update loan to reflect return date
    $db_update_loan_query = 'UPDATE loan (return_date) VALUES (now())';
    echo '<p>' . $db_update_loan_query . '</p>';
    $db_update_loan_statement = $db->prepare($db_update_loan_query);
    $db_update_loan_statement->execute();
    echo '<p>Successfully updated loan to reflect return date</p>';

    //update feature loan status to "No" and set currentLoan to NULL
    echo '<p>Updating ID: ' . $featureId . '</p>';
    $db_update_loan_status_query = 'UPDATE feature SET existing_loan = :existingLoan, fk_current_loan = :currentLoan WHERE id = :featureId;';
    echo '<p>' . $db_update_loan_status_query . '</p>';
    $db_update_loan_status_statement = $db->prepare($db_update_loan_status_query);
    $db_update_loan_status_statement->execute(array(':featureId' => $featureId, ':existingLoan' => 'false', ':currentLoan' => 'NULL'));
    echo '<p>Successfully updated loan status to "No"</p>';
}
?>
