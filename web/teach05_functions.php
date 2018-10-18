<?php

function showAllResultsScriptures($statement) {
	while ($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		echo '<strong>' . $row['book'] . ' ';
		echo $row['chapter']. ':' . $row['verse'] . '</strong> - ';
		echo '&quot;' . $row['content'] . '&quot;';
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
