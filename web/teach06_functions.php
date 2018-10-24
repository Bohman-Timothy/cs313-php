<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 10/23/2018
 * Time: 10:39 PM
 */

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

function showAllScriptures($db) {
	$statement = $db->prepare('SELECT * FROM scripture');
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo '<strong>' . $row['book'] . ' ';
		echo $row['chapter']. ':' . $row['verse'] . '</strong> - ';
		echo '&quot;' . $row['content'] . '&quot;';
		echo 'Topics: ';

$statementScripTopic = $db->prepare('SELECT * FROM scriptures_topics LEFT JOIN topic on fk_topic_id = topic.id WHERE fk_scripture_id=:row');
$statementScripTopic.bindValue(:row, $row['id'], PDO::INT);
$statementScripTopic.execute();

		while ($rowTopic = $statementScripTopic->fetch(PDO::FETCH_ASSOC))
{
	//print topics
	echo 'Topic: ' . $rowTopic['name'] . <br/>;
}
		echo '<br/>';
	}
}

function showAllResultsScriptureReferences($statement) {
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo '<a href ="scripture_details.php?id=' . $row['id'] . '"><strong>' . $row['book'] . ' ';
		echo $row['chapter']. ':' . $row['verse'] . '</strong></a>';
		echo '<br/>';
	}
}

function cleanInput($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

?>
