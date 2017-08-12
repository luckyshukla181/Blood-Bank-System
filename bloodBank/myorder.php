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
					<span class="title_icon"><img src="img/radish-icon.png" alt="" /></span>My
					account
				</div>
				<div>
					<h3>Your order details....</h3>
					<?php
					function print_order($orderId, $orderDate, $totalPrice, $status) {
						$en_order = base64_encode ( $orderId );
						echo '<tr>
							<td>' . $orderId . '</td>
							<td>' . $orderDate . '</td>
							<td>' . $totalPrice . '</td>
							<td>' . $status . '</td>
 							<td><a href="order_details.php?order_id=' . $en_order . '">view details</a></td>
							</tr>';
					}
					$custID = $_SESSION ['user'];
					$sql = "select orderID,orderDate,totalPrice,statusID from productOrder where customerID=? order by orderDate DESC limit 10";
					$conn = Database::connect ();
					$stmt = $conn->prepare ( $sql );
					$r = $stmt->execute ( array (
							$custID 
					) );
					if ($r) {
						$rowcount = $stmt->rowCount ();
						if ($rowcount > 0) {
							?>
							<table class="cart_table">
						<tr>
							<th>Order ID</th>
							<th>Date</th>
							<th>Total Price</th>
							<th>Status</th>
							<th>link</th>
						</tr>
							<?php
							foreach ( $stmt->fetchAll ( PDO::FETCH_FUNC, 'print_order' ) as $row ) {
								echo $row;
							}
							?>
							</table><?php
						} else {
							echo '<p>There is no order details in your account.</p>';
						}
					} else {
						echo $stmt->errorInfo ();
					}
					
					?>

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
