<?php
session_start();

include 'shopping.php';

$street = $city = $state = $zipCode = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$street = clean_input($_POST["street"]);
	$city = clean_input($_POST["city"]);
	$state = clean_input($_POST["state"]);
	$zipCode = clean_input($_POST["zipCode"]);
}

$totalQuantity = $_SESSION["totalQuantity"];
$totalCost = $_SESSION["totalCost"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">

    <!-- Bootstrap compiled CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<link rel="stylesheet" href="shopping.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Purchase Confirmed</title>
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo "<h1 id='purchaseConfirmed'>Purchase Confirmed</h1>";
	echo "<h2>Items Purchased:</h2>";
	echo "<ul class='itemsPurchased'>";
	foreach ($musicMap as $albumKey=>$fullName) {
		$quantity = clean_input($_SESSION[$albumKey]);
		if ($quantity > 0) {
			echo "<li><span class='quantity'>" . $quantity . "</span> of <span class='artistAndAlbum'>" . $fullName . "</span></li>";
		}
	}
	echo "</ul>";
	echo "Total Quantity: " . $totalQuantity . "<br />";
	echo "<span class='totalCost'>Total Cost: $" . $totalCost . "</span>";
	echo "<h2>Shipping Address:</h2>";
	echo "<div class='streetAddress'>";
	echo $street . "<br />";
	echo $city . "<br />";
	echo $state . ", " . $zipCode . "</div><br />";
	echo "<h2 class='thanks'>Thanks for shopping with us!</h2>";
}
?>

<form method="post" action="<?php echo htmlspecialchars("browse.php");?>">
<input type="submit" value="Continue browsing" id="continueBrowsingBtn" class="btn btn-return">
</form>

<?php
include 'resetshopsession.php';
?>
</body>
</html>