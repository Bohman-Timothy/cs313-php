<?php
session_start();
include 'project1_functions.php';

if ($_SESSION["loggedIn"] == true) {
    //Let the user continue on this page
} else {
    //Redirect to login page
    header("Location: login_db.php");
    die();
}

if (!isset($_SESSION["checkoutList"])) {
    $_SESSION["checkoutList"] = array();
}
if (!isset($_SESSION["checkingForExistingLoan"])) {
    $_SESSION["checkingForExistingLoan"] = false;
}
if (!isset($_SESSION["existingLoan"])) {
    $_SESSION["existingLoan"] = NULL;
}

$featureId = $searchId = '';
$successMessage = $errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $featureId = $_POST["featureId"];
    $submitAction = $_POST["submit"];
    $addToCheckout = $_POST["addToCheckout"];
    $submittedFeature = $_POST["selectedFeatureInputHidden"];
    $successMessage = $errorMessage = '';

    print_r($_SESSION);

    if ($submitAction == 'Search') {
        if ($featureId != '') {
            $db_query_feature_id = 'SELECT id, feature_title, feature_year, format, format_year, feature_set_title, location, existing_loan FROM feature_view WHERE id = :featureId;';
            $db_statement_feature_id = $db->prepare($db_query_feature_id);
            $db_statement_feature_id->execute(array(':featureId' => $featureId));
            $_SESSION["featureId"] = $featureId;
            $_SESSION["checkingForExistingLoan"] = true;
        }
    }
    else if ($submitAction == 'Confirm Checkout') {
        if ($_SESSION["existingLoan"] != "Yes") {
            array_push($_SESSION["checkoutList"], $submittedFeature);
            $successMessage = '<p class="successMessage">Feature successfully added to checkout list.</p>';
            setFeatureLoan($_SESSION["featureId"], $db);
        } else {
            $errorMessage = '<p class="errorMessage">You must select a feature that isn\'t already loaned out.</p>';
        }
        $_SESSION["checkingForExistingLoan"] = false;
        //echo '<p class="errorMessage">You must check the box to confirm.</p>';
    }
    else if ($submitAction == 'Confirm Return') {
        if ($_SESSION["existingLoan"] == "Yes") {
            //get id of current loan for the selected feature
            $db_query_current_loan = 'SELECT id, fk_loan FROM current_loan WHERE fk_feature = :featureId;';
            $db_statement_current_loan = $db->prepare($db_query_current_loan);
            $db_statement_current_loan->execute(array(':featureId' => $featureId));
            $singleResult = $db_statement_current_loan->fetch(PDO::FETCH_ASSOC);
            $currentLoanId = $singleResult['id'];
            $loanId = $singleResult['fk_loan'];
            echo '<p>current_loan ID: ' . $loanId . '</p>';
            echo '<p>loan ID: ' . $loanId . '</p>';

            //get user id associated with the loan
            $db_loan_borrower_query = 'SELECT fk_borrower FROM loan WHERE id = :loanId;';
            echo '<p>' . $db_loan_borrower_query . '</p>';
            $db_loan_borrower_statement = $db->prepare($db_loan_borrower_query);
            $db_loan_borrower_statement->execute(array(':loanId' => $loanId));
            $counter = 0;
            while ($row_loan_borrower = $db_loan_borrower_statement->fetch(PDO::FETCH_ASSOC)) {
                $borrowerId = $row_loan_borrower['fk_borrower'];
                echo '<p>Counter: ' . counter . '</p>';
                $counter++;
            }
            echo '<p>Successfully retrieved borrower ID: ' . $borrowerId . '</p>';

            //Restrict returns to the borrower or an admin
            if (($borrowerId == $_SESSION["userId"]) || ($_SESSION["user"] == 'asquire')) {
                returnFeatureLoan($_SESSION["featureId"], $db);
                $successMessage = '<p class="successMessage">The feature has been marked as returned.</p>';
            }
            else {
                $errorMessage = '<p class="errorMessage">You are not authorized to mark this feature as returned. The original borrower or an administrator must mark it as returned.</p>';
            }
        } else {
            $errorMessage = '<p class="errorMessage">You can\'t return a feature that hasn\'t been loaned out.</p>';
        }
        $_SESSION["checkingForExistingLoan"] = false;
    }
    else if ($submitAction == 'Clear Selection') {
        /*print_r($_SESSION);*/
        $_SESSION["checkingForExistingLoan"] = false;
    }

    print_r($_SESSION);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<title>Check Out Or Return a Feature Loan</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="project1.css">
</head>
<body>
	<h1>Check Out Or Return a Feature Loan</h1>
	<ul id="navbar">
		<h2>Menu</h2>
		<li><a href="search_db.php">Search the database</a></li>
		<li><a href="update_db.php">Update the database</a></li>
		<li class="active"><a href="checkout_db.php">Check Out or Return a Feature</a></li>
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
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="searchIdForCheckout_id">
		<h2>Enter data to select a feature to get on loan</h2>
		<label for="enterFeatureId_id">Enter Feature ID:</label>
		<input type="number" min="1" name="featureId" id="enterFeatureId_id" title="Enter the ID found by using the database's search feature" required value=""><br />
		<input type="submit" name="submit" value="Search" class="submitButton" id="searchIdButton_id">
	</form>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($submitAction == 'Search') {
            //show selected feature
            echo '<table class="featureResults">';
            echo '<thead><caption class="exactResultsTableCaption">Result Matching Search</caption></thead>';
            $matchExists = showFullListOfFeatures($db_statement_feature_id);
            if ($matchExists == false) {
                echo '<p class="errorMessage">You must enter a valid feature ID before you can check a feature out.</p>';
            } else { //Prompt user to add the selected feature to their checkout list
                if ($_SESSION["existingLoan"] != 'Yes') {
                    ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="checkout_id"> <!--  onsubmit="return isValidForm();" -->
                        <h2>Add the feature listed above to your checkout list?</h2>
                        <!-- <input type="checkbox" name="addToCheckout" id="addToCheckout_id">
                        <label for="addToCheckout_id">Yes, add to checkout list</label><br/> -->
                        <input type="number" min="1" name="selectedFeatureInputHidden" value="<?php echo $featureId ?>"
                               id="selectedFeatureInputHidden_id">
                        <input type="submit" name="submit" value="Confirm Checkout" class="submitButton" id="confirmAddToCheckoutButton_id">
                        <input type="submit" name="submit" value="Clear Selection" class="submitButton"
                               id="clearSelectionButton_id" onclick="selectCheckbox();">
                    </form>
                    <?php
                }
                else {
                    echo '<p class="statusMessage">This feature is already checked out.</p>';
                    ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="checkout_id">
                        <h2>Return This Feature?</h2>
                        <input type="number" min="1" name="selectedFeatureInputHidden" value="<?php echo $featureId ?>"
                               id="selectedFeatureInputHidden_id">
                        <input type="submit" name="submit" value="Confirm Return" class="submitButton" id="confirmReturnFeatureButton_id">
                        <input type="submit" name="submit" value="Clear Selection" class="submitButton"
                               id="clearSelectionButton_id" onclick="selectCheckbox();">
                    </form>
                    <?php
                }
            }
        }
        if ($successMessage != '') {
            echo $successMessage;
        }
        else if ($errorMessage != '') {
            echo $errorMessage;
        }
        else if ($statusMessage != '') {
            echo $statusMessage;
        }
    }
    ?>
</body>
</html>