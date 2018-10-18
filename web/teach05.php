<?php

include 'teach05_functions.php';

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

echo '<h1>Scripture Resources</h1>';

$statement = $db->query('SELECT book, chapter, verse, content FROM scripture');

showAllResultsScriptures($statement);

$search_book_scripture_text = '';
$search_book_scripture_ref = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$search_book_scripture_text = cleanInput($_POST["search_book_scripture_text"]);
	$search_book_scripture_ref = cleanInput($_POST["search_book_scripture_ref"]);
	
	if ($search_book_scripture_text != '') {
		$search_book = $search_book_scripture_text;
	}
	else {
		$search_book = $search_book_scripture_ref;
	}
	
	$statement = $db->prepare('SELECT book, chapter, verse, content FROM scripture WHERE book=:book');
	$statement->bindValue(':book', $search_book, PDO::PARAM_STR);
	$statement->execute();
}

?>

<!DOCTYPE html>
<html lang="en">
<body>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="search_book_scripture_text">Search for book (display scripture on page):</label>
	<input type="text" name="search_book_scripture_text" title="Must use the full book name" value="<?php echo $search_book_scripture_text ?>">
	<input type="submit" value="Search">
	</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	showAllRows($statement);
}
?>

	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="search_book_scripture_ref">Search for book (display link to separate page):</label>
	<input type="text" name="search_book_scripture_ref" title="Must use the full book name" value="<?php echo $search_book_scripture_ref ?>">
	<input type="submit" value="Search">
	</form>
</body>
</html>