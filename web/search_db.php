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

$search = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$search = cleanInput($_POST["search"]);

	$statement = $db->prepare('SELECT id, feature_title, feature_year, format, format_year, feature_set_title, location, existing_loan FROM feature_view WHERE feature_title=:feature_title');
	$statement->bindValue(':feature_title', $search, PDO::PARAM_INT);
	$statement->execute();
}

function showFullListOfFeatures($statement) {
	echo '<ul class="featureResults">';
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo '<li>' . $row['feature_title'] . ' | ' . $row['feature_year'] . ' | ' . $row['format'];
		echo ' | ' . $row['format_year'] . ' | ' . $row['feature_set_title'] . ' | ' . $row['location'];
		echo ' | ' . $row['existing_loan'] . '</li>';
	}
	echo '</ul>';
}

function cleanInput($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Search the Feature Database</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<h1>Search the Feature Database</h1>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="search">Search:</label>
	<input type="text" name="search" title="Text must match exactly" value="<?php echo $search ?>">
	<input type="submit" value="Search">
	</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	showFullListOfFeatures($statement);
}
?>
</body>
</html>