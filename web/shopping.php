<?php

function clean_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

echo "Shopping.php test<br />";
echo $musicMap["enya_shepherd"] . "<br />";
?>