<?php
session_start();

include 'shopping.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$street = clean_input($_SESSION['street']);
	$city = clean_input($_SESSION['city']);
	$state = clean_input($_SESSION['state']);
	$zipCode = clean_input($_SESSION['zipCode']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="shopping.css">
<title>Purchase Confirmed</title>
</head>
<body>
<?php
echo $musicMap['beatles_1'] . "<br />";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo "<h1>Purchase Confirmed</h1>";
	echo "<ul class='itemsPurchased'>";
	foreach ($musicMap as $albumKey=>$fullName) {
		$quantity = clean_input($_SESSION[$albumKey]);
		if ($quantity > 0) {
			echo "<li><span class='quantity'>" . $quantity . "</span> of <span class='artistAndAlbum'>" . $fullName . "</span></li>";
		}
	}
	echo "Shipping Address:";
	echo $street . "<br />";
	echo $city . "<br />";
	echo $state . ", " . $zipCode . "<br />";
	echo "<h2 class='thanks'>Thanks for shopping with us!</h2>";
}
?>
</body>
</html>