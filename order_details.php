<?php
session_start ();
include_once 'utils/DB.php';
include_once 'utils/config.php';
if (! isset ( $_SESSION ['user'] )) {
	$extraUri = 'index.php';
	header ( "Location: http://$host$uri/$extraUri" );
}
$msg = "";
if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Blood Bank - My Account</title>
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

				<div class="title">
					<span class="title_icon"><img src="img/radish-icon.png" alt="" /></span>My Order
				</div>
				<div>
					
					<?php
					
					$custID = $_SESSION ['user'];
					$orderID = $_GET ['order_id'];
					$orderID = base64_decode ( $orderID );
					
					$sql = "select p.name,o.qty,o.unitPrice,o.price from orderDetails o inner join product p 
					on o.productID=p.productID
					where orderID=?";
					$conn = Database::connect ();
					$stmt = $conn->prepare ( $sql );
					$r = $stmt->execute ( array (
							$orderID 
					) );
					if ($r) {
						$rowcount = $stmt->rowCount ();
						if ($rowcount > 0) {
							?>
							<h3 style="text-align: center;">Order ID:<?php echo $orderID;?></h3>
							<table class="cart_table">
						<tr>
							<th>Blood Group</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Sub-Total</th>
						</tr>
							<?php
							$grandTotal=0;
							while ( $row = $stmt->fetch ( PDO::FETCH_ASSOC ) ) {
								
								$name=$row['name'];
								$unitPrice=$row['unitPrice'];
								$subtotal=$row['price'];
								$qty=$row['qty'];
								$grandTotal +=$subtotal;
								echo '<tr>
										<td>' . $name . '</td>
										<td>' . $unitPrice . '</td>
										<td>' . $qty . '&nbsp;&nbsp;Kg.</td>
										<td>' . $subtotal . '</td>
										</tr>';
							}
							echo '<tr class="noborder">
										<td></td>
										<td></td>
										<td>Grand Total</td>
										<td>Rs.&nbsp;&nbsp;' . $grandTotal . '</td>
										</tr>';
							?>
							</table><?php
						} else {
							echo '<p>There is no order details in your account.</p>';
						}
					} else {
						echo $stmt->errorInfo ();
					}
					
					?>
					<div class="backlink">
					<p><a href="myorder.php">Click here</a> to go to Order Page</p>
					</div>

				</div>

				<div class="clear"></div>
			</div>
			<!--end of left content-->

			<!--end of center content-->
			<?php include_once 'footer.php';?>
		</div>
	</div>

</body>
</html>
