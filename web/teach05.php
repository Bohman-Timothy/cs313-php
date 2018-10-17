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

echo '<h1>Scripture Resources</h1>';

foreach ($db->query('SELECT book, chapter, verse, content FROM scripture') as $row)
{
	echo '<strong>' . $row['book'] . ' ';
echo $row['chapter']. $row['verse'] . '</strong> - ';
	echo "\"$row['content']\"";
	echo '<br/>';
}

?>