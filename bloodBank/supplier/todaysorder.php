<?php
session_start ();
include_once '../utils/DB.php';
include_once '../utils/config.php';
if (! isset ( $_SESSION ['supplier'] )) {
	$extraUri = 'supLogin.php';
	header ( "Location: http://$host$uri/$extraUri" );
}elseif (! isset ( $_SESSION ['supplier'] ) && $_SESSION ['supplier'] == 'Hospital') {
	$extraUri = 'supLogin.php';
	header ( "Location: http://$host$uri/$extraUri" );
}
if (isset ( $_POST ['login'] )) {
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
			<div id="msg"> Today's Orders...</div>
			<?php
			$supId = $_SESSION ['supplier'];
			$indiatimezone = new DateTimeZone ( "Asia/Kolkata" );
			$date = new DateTime ();
			$date->setTimezone ( $indiatimezone );
			$todayDate = $date->format ( 'Y-m-d' );
			$currentTime = $date->format ( 'H:i:s' );
			
			$sql = "select r.productID,t.name, t.unitPrice,r.qty,r.customerID,r.ODID,r.shipID from product t inner join (select d.productID, d.qty, p.customerID,d.ODID,p.shipID from productOrder p inner join orderDetails d on d.orderID=p.orderID
			 where CAST(`orderDate` AS DATE)=? and d.status=?)as r
			on r.productID=t.productID
			where t.supId=?";
			$conn = Database::connect ();
			$stmt = $conn->prepare ( $sql );
			$result = $stmt->execute ( array (
					$todayDate,
					1,
					$supId 
			) );
			if ($result) {
				$rowcount = $stmt->rowCount ();
				if ($rowcount > 0) {
					?>
					<table class="cart_table">
					<tr>
						<th>Blood ID</th>
						<th>Blood Group</th>
						<th>qty</th>
						<th>Total Price</th>
						<th>customer</th>
						<th></th>
						<th></th>
					</tr>
					
					<?php
					while ( $row = $stmt->fetch ( PDO::FETCH_ASSOC ) ) {
						echo '<tr><td>' . $row ['productID'] . '</td><td>' . $row ['name'] . '</td><td>' . $row ['qty'] . '</td><td>' . $row ['unitPrice'] * $row ['qty'] . '</td><td>' . $row ['customerID'] . '</td>
							<td><a href="address_details.php?shipid='. $row ['shipID'] .'&cust_id='. $row ['customerID'] .'">delivery Details</a></td>
							<td><a href="change_orderstatus.php?odid='. $row ['ODID'] .'">change status</a></td></tr>';
					}
					echo '</table>';
				} else {
					echo "<p>There is no pending order today.</p>";
				}
			} else {
				echo $stmt->errorCode ();
			}
			?>
			
			
			</div>
		</div>

		<?php include_once '../footer.php';?>
	</div>

</body>
</html>