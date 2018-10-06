<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="shopping.css">
<title>Checkout</title>
</head>
<body>
<h1>Checkout</h1>
<h2>Please enter your shipping address</h2>
<form method="post" action="<?php echo htmlspecialchars("confirmation.php");?>">
<label for="street">Street</label>
<input type="text" name="street"><br />
<label for="city">City</label>
<input type="text" name="city"><br />
<label for="state">State</label>
<input type="text" name="state">
<label for="zipCode">Zip Code</label>
<input type="text" name="zipCode"><br />
<input type="submit" value="Confirm purchase">
</form>
</body>
</html>