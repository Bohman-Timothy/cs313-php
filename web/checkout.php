<?php
session_start();

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
	<title>Checkout</title>
</head>
<body>
<h1>Checkout</h1>

<?php
echo "<span class='totalCost'>Total Cost: $" . $totalCost . "</span>";
?>

<h2>Please enter your shipping address</h2>
<form method="post" action="<?php echo htmlspecialchars("confirmation.php");?>">
<label for="street">Street</label>
<input type="text" name="street" value=""><br />
<label for="city">City</label>
<input type="text" name="city" value=""><br />
<label for="state">State</label>
<input type="text" name="state" value="">
<label for="zipCode">Zip Code</label>
<input type="text" name="zipCode" value=""><br />
<input type="submit" value="Confirm purchase" id="confirmPurchaseBtn" class="btn btn-success">
</form>

<form method="post" action="<?php echo htmlspecialchars("cart.php");?>">
<input type="submit" value="Return to cart" id="returnToCartBtn" class="btn btn-info">
</form>
</body>
</html>