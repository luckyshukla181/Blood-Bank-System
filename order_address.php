<?php
session_start ();
include_once 'utils/DB.php';
include_once 'utils/config.php';
// user is not logged into his account
if (! isset ( $_SESSION ['user'] )) {
	$_SESSION ['order_pending'] = "true";
	$extraUri = 'myaccount.php';
	header ( "Location: http://$host$uri/$extraUri" );
}

?>
<?php
// handiling address here for delivery--storing it in session
if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	// user already loggedin
	// setting indian time zone
	$timezone = new DateTimeZone ( "Asia/Kolkata" );
	$date = new DateTime ();
	$date->setTimezone ( $timezone );
	$dateStr = $date->format ( 'y-m-d h:m:s' );
	// insert order details into productOrder table and orderdetails table
	$user = $_SESSION ['user'];
	$sql = "insert into productOrder (orderDate,customerID,statusID) values(?,?,?)";
	$conn = Database::connect ();
	$stmt = $conn->prepare ( $sql );
	$result = $stmt->execute ( array (
			$dateStr,
			$user,
			1 
	) );
	
	if ($result) {
		// get order ID
		$orderID = $conn->lastInsertId ();
		$totalPrice = 0;
		
		// setting order_id in session
		$_SESSION ['order_id'] = $orderID;
		
		// inserting each product details in the orderDetails table
		if (isset ( $_SESSION ["products"] )) {
			
			foreach ( $_SESSION ["products"] as $cart_itm ) {
				$sql = "insert into orderDetails(orderID,productID,qty,unitPrice,price,status)values(?,?,?,?,?,?)";
				$conn = Database::connect ();
				$stmt = $conn->prepare ( $sql );
				$productID = $cart_itm ['code'];
				$qty = $cart_itm ['qty'];
				$unitPrice = $cart_itm ['price'];
				$price = $qty * $unitPrice;
				$totalPrice = $totalPrice + $price;
				$res = $stmt->execute ( array (
						$orderID,
						$productID,
						$qty,
						$unitPrice,
						$price,
						1 
				) );
				if ($res) {
					// all is well--update total price in order table.
					$sql = "update productOrder set totalPrice=? where orderID=?";
					$conn = Database::connect ();
					$stmt = $conn->prepare ( $sql );
					$r = $stmt->execute ( array (
							$totalPrice,
							$orderID 
					) );
					if ($r) {
						$_SESSION ['total_amount'] = $totalPrice;
						// updated total price successfully
					} else {
						$stmt->errorInfo ();
					}
				} else {
					// error at second stage
					$stmt->errorInfo ();
				}
			}
		}
	} else {
		// error at first stage
		$stmt->errorInfo ();
	}
	
	// get address details and store in a array
	$addr1 = clean ( $_POST ['address1'] );
	$addr2 = clean ( $_POST ['address2'] );
	$city = clean ( $_POST ['city'] );
	//$district = clean ( $_POST ['district'] );
	$state = clean ( $_POST ['state'] );
	$pin = clean ( $_POST ['pin'] );
	
	// taking orderId from session
	$orderID = $_SESSION ['order_id'];
	// inserting the address details for payment
	$sql = "insert into shippingDetails(addrLine1,addrLine2,city,state,zip) values(?,?,?,?,?)";
	$conn = Database::connect ();
	$stmt = $conn->prepare ( $sql );
	$result = $stmt->execute ( array (
			$addr1,
			$addr2,
			$city,
			$state,
			$pin 
	) );
	if ($result) {
		//
		$shipID = $conn->lastInsertId ();
		$sql = "update productOrder set shipID=? where orderID=? ";
		$stmt = $conn->prepare ( $sql );
		$r = $stmt->execute ( array (
				$shipID,
				$orderID 
		) );
		if ($r) {
			// everryting went good....move to demo payment
			$extraUri = 'payment.php';
			header ( "Location: http://$host$uri/$extraUri" );
		} else {
			$stmt->errorInfo ();
		}
	} else {
		$stmt->errorInfo ();
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Address</title>
<meta http-equiv="Content-Type"
	content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">
fieldset{
background-color: #EBEBFF;
border-radius: 10px;
}
table {
	padding: 20px;
	
}

table tr td {
	padding: 10px 0 0 10px;
}
</style>
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
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"
					method="post">
					<fieldset>
						<legend> Delivery Address</legend>
						<table>
							<tr>
								<td>Address Line 1:</td>
								<td><input type="text" name="address1" id="address1" required></td>
							</tr>
							<tr>
								<td>Address Line 2:</td>
								<td><input type="text" name="address2" id="address2"></td>
							</tr>

							<tr>
								<td>City:</td>

								<td><input type="text" name="city" id="city" required></td>
							</tr>
							<tr>
								<td>State:</td>
								<td><input type="text" name="state" id="state" required></td>
							</tr>

							<tr>
								<td>Pin:</td>
								<td><input type="text" name="pin" id="pin" pattern="[0-9]{6}" required></td>
							</tr>

							<tr>
								<td><button class="button" value="clear" type="reset">Clear</button></td>
								<td>

									<button class="button" value="Next" type="submit"
										style="float: right;">Next</button>
								</td>
							</tr>
						</table>
					</fieldset>



				</form>

			</div>
			<div>
		<?php include_once 'footer.php';?>
		</div>
		</div>
	</div>
</body>
</html>
