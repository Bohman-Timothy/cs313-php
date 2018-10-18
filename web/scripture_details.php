<?php
include 'teach05_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$search_book_id = cleanInput($_GET["id"]);

	$statement = $db->prepare('SELECT id, book, chapter, verse, content FROM scripture WHERE id=:id');
	$statement->bindValue(':id', $search_book_id, PDO::PARAM_STR);
	$statement->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<body>
<?php
showAllResultsScriptures($statement);
?>
</body>
</html>