<?php
session_start ();
include_once '../utils/DB.php';
include_once '../utils/config.php';
if (! isset ( $_SESSION ['supplier'] ) && $_SESSION ['supplier'] == 'Hospital') {
	$extraUri = 'supLogin.php';
	header ( "Location: http://$host$uri/$extraUri" );
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Supplier Login</title>
<meta name="robots" content="noindex, nofollow">
<!-- Include CSS File Here -->
<link rel="stylesheet" type="text/css" href="../style.css" />
<script
	src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<style type="text/css">
input[type=text], [type=password] {
	margin-bottom: 15px;
}
</style>
</head>
<body>
	<div id="wrap">

		<div class="header">
			<div class="logo">
				<a href=""> <!-- <img src="images/logo.gif" alt="" border="0" /> -->Logo
				</a>
			</div>
			<div id="menu">
				<?php include_once 'menu_content.php';?>
			</div>

		</div>
		<div class="center_content">
			 <?php
				if (isset ( $_SESSION ['supplier'] )) {
					include_once 'user_welcome.php';
				}
				
				?> 
			<div class="left_content">
				<div id="msg">Delivery Details...</div>
			<?php
			if ($_SERVER ['REQUEST_METHOD'] == 'GET' && isset ( $_GET ['shipid'] )) {
				$ship_id = clean ( $_GET ['shipid'] );
				$cust_id = clean ( $_GET ['cust_id'] );
				
				$sql = "select * from shippingDetails where shipID=?";
				$conn = Database::connect ();
				$stmt = $conn->prepare ( $sql );
				$result = $stmt->execute ( array (
						$ship_id 
				) );
				$sql2 = "select * from customer where custID=?";
				$conn = Database::connect ();
				$stmt2 = $conn->prepare ( $sql2 );
				$result2 = $stmt2->execute ( array (
						$cust_id 
				) );
				if ($result && $result2) {
					$row = $stmt->fetch ( PDO::FETCH_ASSOC );
					$row2 = $stmt2->fetch ( PDO::FETCH_ASSOC );
					?>
					<table class="cart_table">
					<tr>
						<td>Name:</td>
						<td><?php echo $row2['firstname'].'&nbsp;&nbsp;'.$row2['lastname'];?></td>
					</tr>
					<tr>
						<td>Address:</td>
						<td><?php echo $row['addrLine1'].'&nbsp;,'.$row['addrLine2'].'&nbsp;,'.$row['city'].'&nbsp;,'.$row['zip'];?></td>
					</tr>
					<tr>
						<td>Phone No.</td>
						<td><?php echo $row2['phone'];?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?php echo $row2['email'];?></td>
					</tr>
				</table>
					<?php
				} else {
					print_r ( $stmt->errorInfo () );
				}
			}
			
			?>
			<div class="backlink">
					<a href="todaysorder.php">back to Today's Order</a>
				</div>
			</div>
		</div>

		<?php include_once '../footer.php';?>
	</div>

</body>
</html>