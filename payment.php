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
// processing payment Demo payment
if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	$cardNo = clean ( $_POST ['credit_card'] );
	$month = clean ( $_POST ['month'] );
	$year = clean ( $_POST ['year'] );
	$holder = clean ( $_POST ['holder'] );
	// creating a card expiry date, 01 is default day
	$dateTime = new DateTime ();
	$dateTime->setDate ( $year, $month, 01 );
	$expDate = $dateTime->format ( 'y-m-d' );
	
	$cvv = clean ( $_POST ['cvv'] );
	$ordeID = $_SESSION ['order_id'];
	$totalAmount = $_SESSION ['total_amount'];
	
	// inserting deatils in the database
	$sql = "insert into payment(amount,cardNumber,expDate,holder,paydate) values(?,?,?,?,?)";
	$conn = Database::connect ();
	$stmt = $conn->prepare ( $sql );
	$r = $stmt->execute ( array (
			$totalAmount,
			$cardNo,
			$expDate,
			$holder,
			date ( 'y-m-d' ) 
	) );
	if ($r) {
		$paymentID = $conn->lastInsertId ();
		$sql = "update productOrder set paymentID=? where orderID=? ";
		$ordeID = $_SESSION ['order_id'];
		$conn = Database::connect ();
		$stmt = $conn->prepare ( $sql );
		$result = $stmt->execute ( array (
				$paymentID,
				$ordeID 
		) );
		if ($result) {
			// payment successful...send user to order_bill page
			$_SESSION ['order_pending'] = 'false';
			$extraUri = 'order_success.php';
			header ( "Location: http://$host$uri/$extraUri" );
		} else {
			$stmt->errorInfo ();
		}
	} else {
		// payment failed
		$stmt->errorInfo ();
	}
	unset ( $_POST );
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Cart</title>
<meta http-equiv="Content-Type"
	content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">

fieldset{
background-color: #EBEBFF;
border-radius: 10px;
}

#cvv {
	width: 90px;
}

fieldset {
	width: 60%;
}

table {
	padding: 30px;
}

table tr td {
	padding: 5px 0 5px 5px;
}

#totalAmount {
	margin: 20px 170px 20px 170px;
	text-decoration: blink;
	font-style: italic;
	height: 30px;
	vertical-align: middle;
	text-align: center;
	padding-top: 5px;
	font-size: medium;
	border: 2px solid black;
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
					<div id="totalAmount">
						<span>Total Payble amount is: Rs. <?php echo $_SESSION['total_amount']?></span>
					</div>
					<fieldset>
						<legend>Payment Gateway</legend>
						<table>
							<tr>
								<td>DEBIT CARD NUMBER:</td>
								<td><input type="text" name="credit_card" pattern="[0-9]{16}" title="Enter 16 digit debit card number" id="credit_card" required/></td>
							</tr>
							<tr>
								<td>NAME ON CARD:</td>
								<td><input type="text" name="holder" id="holder" required></td>

							</tr>
							<tr>
								<td>Expiry Details</td>
								<td><span>MONTH:&nbsp;&nbsp;<select name="month" id="month" required>
				<?php
				for($i = 1; $i < 13; $i ++) {
					echo '<option value="' . $i . '">' . $i . '</option>';
				}
				?>
				</select> YEAR:<select name="year" id="year" required>
				<?php
				for($i = 2015; $i < 2030; $i ++) {
					echo '<option value="' . $i . '">' . $i . '</option>';
				}
				?>
				</select></span></td>

							</tr>
							<tr>
								<td>CVV:</td>
								<td><input type="password" name="cvv" id="cvv" pattern="[0-9]{3}" title="Enter 3 digit cvv number" required></td>
							</tr>
							<tr>
								<td></td>
								<td>
									<button class="button" type="submit">PAY</button>
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