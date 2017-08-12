<?php
session_start ();
$currency = 'Rs.';
$current_url = base64_encode ( "http://" . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'] );
include_once ("utils/config.php");
include_once 'utils/DB.php';
?>
<?php 


?>
<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
</head>
<body>
<?php
if (isset ( $_SESSION ["products"] )) {
	$total = 0;
	echo '<form method="post" action="PAYMENT-GATEWAY">';
	echo '<ul>';
	$cart_items = 0;
	// connection to database
	$conn = Database::connect ();
	
	foreach ( $_SESSION ["products"] as $cart_itm ) {
		$product_code = $cart_itm ["code"];
		
		$sql = "SELECT name,description, unitPrice FROM product WHERE productID=? LIMIT 1";
		$stmt = $conn->prepare ( $sql );
		$stmt->execute ( array (
				$product_code 
		) );
		$obj = $stmt->fetch ( PDO::FETCH_OBJ );
		
		echo '<li class="cart-itm">';
		echo '<h3>' . $obj->name . ' (Code :' . $product_code . ')</h3> ';
		echo '<div class="p-price">' . $currency . $obj->unitPrice . '</div>';
		echo '<div class="product-info">';
		echo '<div class="p-qty">Qty : ' . $cart_itm ["qty"] . '</div>';
		echo '<div>' . $obj->description . '</div>';
		echo '<span class="remove-itm"><a href="cart_update.php?removep=' . $cart_itm ["code"] . '&return_url=' . $current_url . '">&times;</a></span>';
		echo '</div>';
		echo '</li>';
		$subtotal = ($cart_itm ["price"] * $cart_itm ["qty"]);
		$total = ($total + $subtotal);
		$cart_items ++;
		echo '</ul>';
		echo '<span class="check-out-txt">';
		echo '<strong>Total : ' . $currency . $total . '</strong>  ';
		echo '</span>';
		echo '</form>';
		echo '<input type="submit" name="continue" value="continue Shopping">';
		echo '<input type="submit" name="checkout" value="CheckOut">';
	}
} 

else {
	echo 'Your Cart is empty';
	echo '<a href="index.php">Go To home page!</a>';
}
?>

</body>
</html>
