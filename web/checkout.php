<?php
session_start();

include 'shopping.php';

$totalCost = $_SESSION["totalCost"];
$street = $city = $state = $zipCode = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$street = clean_input($_POST["street"]);
	$city = clean_input($_POST["city"]);
	$state = clean_input($_POST["state"]);
	$zipCode = clean_input($_POST["zipCode"]);

	if ((isset($street)) && ($street != "") &&
		(isset($city)) && ($city != "") &&
		(isset($state)) && ($state != "") &&
		(isset($zipCode)) && ($zipCode != "")) {
		header("Location: confirmation.php");
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">

    <!-- Bootstrap compiled CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<link rel="stylesheet" href="shopping.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Checkout</title>
</head>
<body>
<h1>Checkout</h1>

<?php
echo "<span class='totalCost'>Total Cost: $" . $totalCost . "</span>";
?>

<h2>Please enter your shipping address</h2>
<p>All fields are required.</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<label for="street">Street</label>
<input type="text" name="street" value="<?php echo $street ?>"><br />
<label for="city">City</label>
<input type="text" name="city" value="<?php echo $city ?>"><br />
<label for="state">State</label>
<input type="text" name="state" value="<?php echo $state ?>">
<label for="zipCode">Zip Code (5 digits)</label>
<input type="text" name="zipCode" pattern="[0-9]{5}" value="<?php echo $zipCode ?>" class="zipCode"><br />
<input type="submit" value="Confirm purchase" id="confirmPurchaseBtn" class="btn btn-primary floatLeft">
</form>

<form method="post" action="<?php echo htmlspecialchars("cart.php");?>">
<input type="submit" value="Return to cart" id="returnToCartBtn" class="btn btn-return">
</form>
</body>
</html>