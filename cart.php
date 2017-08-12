<?php
session_start ();
include_once 'utils/DB.php';
include_once 'utils/config.php';
if (! isset ( $_SESSION ['user'] )) {
	$extraUri = 'myaccount.php';
	header ( "Location: http://$host$uri/$extraUri" );
}
$current_url = base64_encode ( "http://" . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'] );
?>
<?php
// handling form submit
if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	
	if (($_POST ['shopping'])) {
		// back to index url
		unset ( $_POST );
		$extraUri = 'final.php';
		header ( "Location: http://$host$uri/$extraUri" );
	} else if ($_POST ['checkout']) {
		// inserting order details in the database
		
		// going to process url
		unset ( $_POST );
		$extraUri = 'order_address.php';
		header ( "Location: http://$host$uri/$extraUri" );
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Cart</title>
<meta http-equiv="Content-Type"
	content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
	<div id="wrap">
		
			<?php include_once 'menu.php';?>
		<div class="center_content">
		<?php
		if (isset ( $_SESSION ['user'] )) {
			include_once 'user_welcome.php';
		}
		?>
			<div class="left_content">
        <?php
								
								if (isset ( $_SESSION ["products"] )) {
									echo '<table class="cart_table">
											<tr>
											<th></th>
											<th>Blood Group</th>
											<th>Unit price</th>
											<th>Qty</th>
											<th>Total</th><th></th>
											</tr>';
									$total = 0;
									$thispage = htmlspecialchars ( $_SERVER ['PHP_SELF'] );
									echo '<form method="post" action="' . $thispage . '">';
									$cart_items = 0;
									// connection to database
									$conn = Database::connect ();
									
									foreach ( $_SESSION ["products"] as $cart_itm ) {
										$product_code = $cart_itm ["code"];
										
										$sql = "SELECT name,unitPrice,description FROM product WHERE productID=? LIMIT 1";
										$stmt = $conn->prepare ( $sql );
										$stmt->execute ( array (
												$product_code 
										) );
										$obj = $stmt->fetch ( PDO::FETCH_OBJ );
										echo '<td>' . $obj->name . ' (Code :' . $product_code . ')</td> ';
										echo '<td>Rs.' . $obj->unitPrice . '</td>';
										echo '<td>' . $cart_itm ["qty"] . '&nbsp;&nbsp;</td>';
										$subtotal = ($cart_itm ["price"] * $cart_itm ["qty"]);
										echo '<td>' . $subtotal . '</td>';
										echo '<td><a href="cart_update.php?removep=' . $cart_itm ["code"] . '&return_url=' . $current_url . '"><img src="./img/delete.png"></a></span></td>';
										$total = ($total + $subtotal);
									
										$cart_items ++;
										echo '</tr>';
									}
									$_SESSION ['total_amount'] = $total;
									echo '<tr><td colspan="3">';
									echo '<strong>Grand Total</strong></td>';
									echo '<td colspan="3">Rs.&nbsp;&nbsp;<strong>' . $total . '</strong></td>';
									echo '</tr>';
									echo '<tr class="noborder"><td></td><td></td><td></td><td><input class="button" type="submit" name="shopping"value="Back to shopping"/></td>';
									echo '<td><input class="button"type="submit" name="checkout"value="check out"/></td><td></td></tr></table>';
								} else {
									echo '<p class="message">Your Cart is empty !!<br>';
									echo '<a href="index.php">Go To home page!</a></p>';
								}
								?>
		</div>
		<div>
		<?php include_once 'footer.php';?>
		</div>
	</div>
</body>
</html>
