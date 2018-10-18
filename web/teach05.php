<?php

include 'teach05_functions.php';

$statement = '';
$search_book_scripture_text = '';
$search_book_scripture_ref = '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Scripture Resources</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<h1>Scripture Resources</h1>

<?php
$statement_original = $db->query('SELECT book, chapter, verse, content FROM scripture');
showAllResultsScriptures($statement_original);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$search_book_scripture_text = cleanInput($_POST["search_book_scripture_text"]);
	$search_book_scripture_ref = cleanInput($_POST["search_book_scripture_ref"]);
	
	if ($search_book_scripture_text != '') {
		$search_book = $search_book_scripture_text;
	}
	else {
		$search_book = $search_book_scripture_ref;
	}
	
	$statement = $db->prepare('SELECT id, book, chapter, verse, content FROM scripture WHERE book=:book');
	$statement->bindValue(':book', $search_book, PDO::PARAM_INT);
	$statement->execute();
}
?>

	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="search_book_scripture_text">Search for book (display scripture on page):</label>
	<input type="text" name="search_book_scripture_text" title="Must use the full book name" value="<?php echo $search_book_scripture_text ?>">
	<input type="submit" value="Search">
	</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
if ($search_book_scripture_text != '') {
		showAllResultsScriptures($statement);
	}
}
?>

	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="search_book_scripture_ref">Search for book (display link to separate page):</label>
	<input type="text" name="search_book_scripture_ref" title="Must use the full book name" value="<?php echo $search_book_scripture_ref ?>">
	<input type="submit" value="Search">
	</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($search_book_scripture_ref != '') {
	showAllResultsScriptureReferences($statement);
}
}
?>

</body>
</html>
