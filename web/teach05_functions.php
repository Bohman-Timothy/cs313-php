<?php

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

function showAllResultsScriptures($statement) {
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo '<p><strong>' . $row['book'] . ' ';
		echo $row['chapter']. ':' . $row['verse'] . '</strong> - ';
		echo '&quot;' . $row['content'] . '&quot;</p>';
	}
}

function showAllResultsScriptureReferences($statement) {
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo '<p><a href ="scripture_details.php?id=' . $row['id'] . '"><strong>' . $row['book'] . ' ';
		echo $row['chapter']. ':' . $row['verse'] . '</strong></a></p>';
	}
}

function showScriptureDetails($statement) {
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo '<h1>' . $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'] . '</h1>';
		echo '<p>&quot;' . $row['content'] . '&quot;</p>';
	}
}

function cleanInput($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

?>
