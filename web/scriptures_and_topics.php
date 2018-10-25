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
    <h2>New Scripture Entry:</h2>
    <label for="book_id">Book:</label>
    <input type="text" name="book" id="book_id"><br/>
    <label for="chapter_id">Chapter:</label>
    <input type="text" name="chapter" id="chapter_id"><br/>
    <label for="verse_id">Verse:</label>
    <input type="text" name="verse" id="verse_id"><br/>
    <label for="content_id">Content:</label>
    <textarea name="content" id="content_id"></textarea>
    <br/>
    <?php
    //checkboxes
    foreach ($db->query('SELECT id, name FROM topic') as $row)
    {
        //add checkbox
        echo '<input type="checkbox" name="topic[]" ';
        echo 'value="' . $row['id'] . '">' . $row['name'] . '<br/>';
    }
    ?>
    <input type="checkbox" name="newTopicCheckbox" value="">
    <input type="text" name="newTopic" id="newTopic_id"><br/>
    <input type="submit" value="Submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $book = cleanInput($_POST["book"]);
    $chapter = cleanInput($_POST["chapter"]);
    $verse = cleanInput($_POST["verse"]);
    $content = cleanInput($_POST["content"]);
    $topics = $_POST["topic"];
    $newTopicCheckbox = $_POST["newTopicCheckbox"];
    $newTopic = cleanInput($_POST["newTopic"]);

    //insert topic
    if (($newTopicCheckbox == true) && ($newTopic != '')) {
        $statement_newTopic = $db->prepare('INSERT INTO topic (name) VALUES (:newTopic)');
        $statement_newTopic->bindValue(':newTopic', $newTopic, PDO::PARAM_STR);
        $statement_newTopic->execute();

        /*$statement_newTopicId = $db->prepare('SELECT id FROM topic where name = :newTopic');
        $statement_newTopicId->bindValue(':newTopic', $newTopic, PDO::PARAM_STR);
        $statement_newTopicId->execute();*/

        /*while ($row = $statement_newTopicId->fetch(PDO::FETCH_ASSOC))
        {
            $newTopicId =  $row['id'];
        }
        array_push($topics, $newTopicId);*/
        array_push($topics, $newTopic);

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

