<!DOCTYPE html lang="en">
<head>
  <title>Timothy's CS 313 Home Page</title>
    <!-- Bootstrap compiled CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
  <link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/inconsolata" type="text/css"/>
  <link rel="stylesheet" href="main.css">
  <script src="main.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body id="home_page">
  <ul id="navbar">
    <li class="active"><a href="index.php">Home</a></li>
    <li><a href="assignments.html">Assignments</a></li>
  </ul>

  <h1>Timothy's CS 313 Home Page</h1>
  <?php
    echo "<p>Server Time: " . date("Y.m.d h:i:sa") . "</p>";
    ?>

  <div id="about">
    <h2>About Entertainment</h2>
    <p>By Timothy Bohman</p>
    <figure class="imgFloatLeft">
      <img src="https://upload.wikimedia.org/wikipedia/en/9/9b/Crystalisboxart.jpg" width="260" height="383">
      <figcaption id="crystalisFigCaption">Crystalis box art</figcaption>
    </figure>
    <p>There are many movies, TV shows, songs, books, and video games that I enjoy. There are some that I really love, and the idea has crossed my mind a few times to start writing reviews of my favorite entertainment media. A few months ago I wrote a somewhat short review of one of my favorite video games of all time: <i><a href="https://en.wikipedia.org/wiki/Crystalis">Crystalis</a></i>. I won't explain my thoughts on it here, but the point is that I started with one review (which I may expand on at a later time), taking the first step into sharing what I love about some of my favorite things with other people. I greatly appreciate the time that many people put into reviewing products for the benefit of others who have not yet tried it out for themselves; such reviews save the world a collectively infinite amount of time and frustration that would come with needing to make decisions on how to spend one's time, effort, and money with minimal information and no help from anyone else, or at least not from anyone who had tried the product before. I may not make a habit of writing reviews of new things I buy or try, because it takes time and mental exertion to write something I consider to be adequate, but I fully intend to give back a bit by sharing my experiences with things that I enjoy most.</p>
    <figure class="imgFloatRight">
      <img src="https://images.blu-ray.com/news/upload/9914_tn.jpg" width="260" height="328" onmouseover="biggerSupermanImg(this)" onmouseout="smallerSupermanImg(this)">
      <figcaption id="supermanFigCaption">Superman: The Movie 4K Ultra HD Blu-ray cover art</figcaption>
    </figure>
    <p>After writing all that, I feel obligated to share something, at least. One of my top 3 favorite movies of all time is <i><a href="https://www.imdb.com/title/tt0078346/">Superman: The Movie</a></i>, and this year (2018) is the 40th anniversary of the movie and the 80th anniversary of Superman as a character. There will be a one-day screening of the first <i>Superman</i> film starring Christopher Reeve in select theaters on Sunday, November 25, and there will be a 4K Ultra HD Blu-ray of the film available on November 6. I feel that director Richard Donner's <i>Superman</i> set the standard for all superhero movies to follow, and none of those subsequent superhero films has been as epic, entertaining, and heroic as this masterpiece. You might think that someone with otherworldly powers could never be portrayed realistically, but the movie's portrayal of the Man of Steel is as realistic as it could be, with all stunts using physical props and actors rather than computer-generated 3d graphics. The crew who worked on the film pioneered techniques to get the action sequences and the special effects to look just right. The impact of the story, the characters, the action, and the heroics should be experienced by all movie lovers.</p>
  </div>
  <h2>Resources Used for Home Page and Assignments Page</h2>
  <ul>
    <li><a href="https://www.w3schools.com/css/css_border.asp">W3Schools - CSS Border</a></li>
    <li><a href="https://www.w3schools.com/css/css_text.asp">W3Schools - Text Underline</a></li>
    <li><a href="https://www.w3schools.com/css/css_navbar.asp">W3Schools - CSS Navigation Bar</a></li>
    <li><a href="https://www.w3schools.com/php/php_date.asp">W3Schools - PHP Date and Time</a></li>
    <li><a href="https://www.w3schools.com/php/php_syntax.asp">W3Schools - PHP Syntax</a></li>
    <li><a href="https://www.w3schools.com/jsref/prop_img_width.asp">W3Schools - JavaScript, Image Width Property</a></li>
    <li><a href="https://www.w3schools.com/jsref/event_onmouseover.asp">W3Schools - JavaScript onmouseover and onmouseout Events</a></li>
    <li><a href="https://www.w3schools.com/tags/tag_figcaption.asp">W3Schools - figcaption Tag</a></li>
    <li><a href="#">Dummy link</a></li>
  </ul>
</body>
</html>
