<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 10/23/2018
 * Time: 10:28 PM
 */

include 'teach06_functions.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Scriptures and Topics</title>
</head>
<body>
<h1>Scriptures and Topics</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="book_id">Book:</label>
    <input type="text" name="book" id="book_id"><br />
    <label for="chapter_id">Chapter:</label>
    <input type="text" name="chapter" id="chapter_id"><br />
    <label for="verse_id">Verse:</label>
    <input type="text" name="verse" id="verse_id"><br />
    <label for="content_id">Content:</label>
    <textarea name="content" id="content_id"></textarea><br />




    <!-- checkboxes -->
<?php
foreach ($db->query('SELECT id, name FROM topic') as $row)
{
    //add checkbox
    echo '<input type="checkbox" name="topic[]" ';
    echo 'value="' . $row['id'] . '">' . $row['name'] . '<br/>';
}
?>

<input type="submit" value="Submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book = clean_input($_POST["book"]);
    $chapter = clean_input($_POST["chapter"]);
    $verse = clean_input($_POST["verse"]);
    $content = clean_input($_POST["content"]);
    $topics = $_POST["topic"];

//insert scripture
    $statement = $db->prepare('INSERT INTO scripture (book, chapter, verse, content) VALUES (:book, :chapter, :verse, :content)');
    $statement->execute(array(':book' => $book, ':chapter' => $chapter, ':verse' => $verse, ':content' => $content));


	$scripture_id = $db->lastInsertId('scripture_id_seq');

foreach ($topics as $topic)
{
	//insert scripture_topic
$statement = $db->prepare('INSERT INTO scriptures_topics (fk_scripture_id, fk_topic_id) VALUES (:scripture, :topic)');
    	$statement->execute(array(':scripture' => $scripture_id, ':topic' => $topic));
}

//display all scriptures
	showAllScriptures($db);
}

?>



</body>
</html>
