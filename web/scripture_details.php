<?php
include 'teach05_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	$search_book_id = cleanInput($_GET["id"]);

	$statement = $db->prepare('SELECT id, book, chapter, verse, content FROM scripture WHERE id=:id');
	$statement->bindValue(':id', $search_book_id, PDO::PARAM_STR);
	$statement->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Scripture Resources - Scripture Text</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<h1>Scripture Details</h1>
<?php
showScriptureDetails($statement);
?>
</body>
</html>