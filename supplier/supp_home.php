<?php
session_start ();
include_once '../utils/DB.php';
include_once '../utils/config.php';
if (! isset ( $_SESSION ['supplier'] ) ) {
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

.message_renger {
	margin: 10px 30px 10px 30px;
	padding: 5px;
	height: 150px;
	border: 3px double #DDD;
	border-radius: 5px;
	box-shadow: 0 0 5px #194719;
	background-color: #ffffff;
}

.message_renger p {
	margin: 15px;
	font-size: 14px;
}

.msg {
	margin-top: 20px;
	background-color: #B8B8E6;
	padding: 5px 0 5px 0;
	text-align: center;
	font-size: 16px;
}
.left_content{
padding-bottom: 50px;
}
</style>
<!-- Include CSS File Here -->
<script type="text/javascript">
$(document).ready(function(){
$(myform).slideDown("slow");
	
});
</script>
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

				<div class="message_renger">
					<!-- Today's order summaary -->
					<div class="msg">Today's Orders summary...</div>
			<?php
			$supId = $_SESSION ['supplier'];
			$indiatimezone = new DateTimeZone ( "Asia/Kolkata" );
			$date = new DateTime ();
			$date->setTimezone ( $indiatimezone );
			$todayDate = $date->format ( 'Y-m-d' );
			$currentTime = $date->format ( 'H:i:s' );
			
			$sql = "select r.unitPrice, r.qty from product t inner join (select unitPrice,qty,d.productID from orderDetails d inner join productOrder p
					on p.orderID=d.orderID where CAST(`orderDate` AS DATE)=?) as r
					on t.productID=r.productID and t.supId=?";
			$conn = Database::connect ();
			$stmt = $conn->prepare ( $sql );
			$result = $stmt->execute ( array (
					$todayDate,
					$supId 
			) );
			if ($result) {
				$rowcount = $stmt->rowCount ();
				if ($rowcount > 0) {
					$orderCounter = 0;
					$totalSale = 0;
					while ( $row = $stmt->fetch ( PDO::FETCH_ASSOC ) ) {
						// print_r($row);
						$orderCounter ++;
						$totalSale += $row ['unitPrice'] * $row ['qty'];
					}
					echo '<p>Total number of order today:&nbsp;&nbsp;&nbsp;' . $orderCounter . '</p>';
					echo '<p>Total amount of order today:&nbsp;Rs.&nbsp;&nbsp;' . $totalSale . '</p>';
				} else {
					echo "<p>There is no order today.</p>";
				}
			} else {
				echo $stmt->errorCode ();
			}
			?>
			</div>
				<div class="message_renger">
					<!-- pending order summary -->
					<div class="msg">Today's pending order summary...</div>
				<?php
				$supId = $_SESSION ['supplier'];
				$indiatimezone = new DateTimeZone ( "Asia/Kolkata" );
				$date = new DateTime ();
				$date->setTimezone ( $indiatimezone );
				$todayDate = $date->format ( 'Y-m-d' );
				$currentTime = $date->format ( 'H:i:s' );
				
				$sql = "select count(*) as total_pending from product t inner join (select d.productID, d.qty, p.customerID,d.ODID,p.shipID from productOrder p inner join orderDetails d on d.orderID=p.orderID
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
						$row = $stmt->fetch ( PDO::FETCH_ASSOC );
						$total_pending = $row ['total_pending'];
						echo '<p>Pending Order Today: ' . $total_pending . '</p>';
					} else {
						echo "<p>There is no pending order today.</p>";
					}
				} else {
					echo $stmt->errorCode ();
				}
				?>
			</div>

			</div>
		</div>

		<?php include_once '../footer.php';?>
	</div>

</body>
</html>