<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 10/23/2018
 * Time: 10:28 PM
 */

include 'teach06_functions.php';

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
?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Scriptures and Topics</title>
    </head>
<body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="book_id">Book:</label>
    <input type="text" name="book" id="book_id">
    <label for="chapter_id">Chapter:</label>
    <input type="text" name="chapter" id="chapter_id">
    <label for="verse_id">Verse:</label>
    <input type="text" name="verse" id="verse_id">
    <label for="content_id">Content:</label>
    <input type="textarea" name="content" id="content_id">


    //checkboxes
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
    $contents = clean_input($_POST["contents"]);
    $topics[] = clean_input($_POST["topic[]"]);

//insert scripture
    $statement = $db->prepare('INSERT INTO scripture (book, chapter, verse, content) VALUES (:book, :chapter, :verse, :content)');
    $statement->execute(array(':book' => $book, ':chapter' => $chapter, ':verse' => $verse, ':content' => $content));


    $scripture_id = $pdo->lastInsertId('scripture_id_seq');

    foreach ($topics as $topic)
    {
        //insert scripture_topic
        $statement = $db->prepare('INSERT INTO scriptures_topics (fk_scripture_id, fk_topic_id) VALUES (:scripture, :topic)');
    	$statement->execute(array(':scripture' => $scripture_id, ':topic' => $topic));
    }

//display all scriptures

}


?>

</body>
</html>
