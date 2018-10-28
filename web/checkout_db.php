<?php
session_start();
include 'project1_functions.php';

if (!isset($_SESSION["checkoutList"])) {
    $_SESSION["checkoutList"] = array();
}
if (!isset($_SESSION["checkingForExistingLoan"])) {
    $_SESSION["checkingForExistingLoan"] = false;
}
if (!isset($_SESSION["existingLoan"])) {
    $_SESSION["existingLoan"] = NULL;
}

$searchId = '';
$successMessage = $errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $featureId = cleanInput($_POST["featureId"]);
    $submitAction = $_POST["submit"];
    $addToCheckout = $_POST["addToCheckout"];
    $submittedFeature = $_POST["selectedFeatureInputHidden"];
    $successMessage = $errorMessage = '';

    if ($submitAction == 'Search') {
        if ($featureId != '') {
            $db_query_feature_id = 'SELECT id, feature_title, feature_year, format, format_year, feature_set_title, location, existing_loan FROM feature_view WHERE id =:featureId;';
            $db_statement_feature_id = $db->prepare($db_query_feature_id);
            $db_statement_feature_id->execute(array(':featureId' => $featureId));
        }
    }
    else if ($submitAction == 'Submit') {
        if ($addToCheckout == 'checked') {
            if ($_SESSION["existingLoan"] != true) {
                array_push($_SESSION["checkoutList"], $submittedFeature);
                echo '<p class="successMessage">Feature successfully added to checkout list.</p>';
            } else {
                echo '<p class="errorMessage">You must select a feature that isn\'t already loaned out.</p>';
            }
        } else {
            echo '<p class="errorMessage">You must check the box to confirm.</p>';
        }
        print_r($_SESSION);
    }
    else if ($submitAction == 'Clear Selection') {
        print_r($_SESSION);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
		<input type="number" min="1" name="featureId" id="enterFeatureId_id" title="Enter the ID found by using the database's search feature" value=""><br />
		<input type="submit" name="submit" value="Search" class="submitButton">
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
                if ($_SESSION["existingLoan"] != true) {
                    ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="checkout_id">
                        <h2>Add the feature listed above to your checkout list?</h2>
                        <input type="checkbox" name="addToCheckout" id="addToCheckout_id" required>
                        <label for="addToCheckout_id">Yes, add to checkout list</label><br/>
                        <input type="number" min="1" name="selectedFeatureInputHidden" required value="<?php echo $featureId; ?>"
                               id="selectedFeatureInputHidden_id">
                        <input type="submit" name="submit" value="Submit" class="submitButton">
                        <input type="submit" name="submit" value="Clear Selection" class="submitButton"
                               id="clearSelectionButton_id" onclick="confirmCheckboxIsSelected();">
                    </form>
                    <?php
                }
                else {
                    echo '<p class="errorMessage">This feature is already checked out. Please select another feature.</p>';
                }
            }
        }
    }
    ?>
</body>
</html>