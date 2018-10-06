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
echo "<h1>Purchase Confirmed</h1>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo "<ul class='itemsPurchased'>";
	foreach ($musicMap as $albumKey=>$fullName) {
		$quantity = clean_input($_SESSION[$albumKey]);
		if ($quantity > 0) {
			echo "<li><span class='quantity'>" . $quantity . "</span> of <span class='artistAndAlbum'>" . $fullName . "</span></li>";
		}
	}
	echo "Shipping Address:";
	echo $street;
	echo $city;
	echo $state . ", " . $zipCode;
}
?>
</body>
</html>