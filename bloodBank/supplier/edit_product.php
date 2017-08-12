<?php
session_start ();
include_once '../utils/DB.php';
include_once '../utils/config.php';
if (! isset ( $_SESSION ['supplier'] )) {
	$extraUri = 'supLogin.php';
	header ( "Location: http://$host$uri/$extraUri" );
}
if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	$name = $unitPrice = $description = $productID = $packet =
	$page = "";
	
	// clean input values
	$page = clean ( $_GET ['page'] );
	$productID = clean ( $_GET ['productID'] );
	
	// sql select query
	$sql = "select * from product where productID=?";
	$conn = Database::connect ();
	$stmt = $conn->prepare ( $sql );
	$stmt->execute ( array (
			$productID 
	) );
	if ($stmt) {
		$row = $stmt->fetch ( PDO::FETCH_ASSOC );
		$name = $row ['name'];
		$unitPrice = $row ['unitPrice'];
		$description = $row ['description'];
		$packet = $row ['packet'];
	} else {
		die ( "problem in select" );
	}
}
if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	$name = $unitPrice = $description = $productID = $packet =
	$productID = $_POST ['productID'];
	$name = $_POST ['name'];
	$unitPrice = $_POST ['price'];
	$description = $_POST ['description'];
	$packet = $_POST ['packet'];
	$page = $_POST ['page'];
	$sql = "update product set name=?,unitPrice=?,description=?,packet=? where productID=?";
	$conn = Database::connect ();
	$stmt = $conn->prepare ( $sql );
	
	$stmt->execute ( array (
			$name,
			$unitPrice,
			$description,
			$packet,
			$productID 
	) );
	if ($stmt) {
		$extraUri = "view_product.php?page=" . $page;
		// echo $extraUri;
		header ( "Location: http://$host$uri/$extraUri" );
	} else {
		$stmt->errorInfo ();
	}
}
?>
<html>
<head>
<title>edit info</title>
<meta http-equiv="Content-Type"
	content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="../style.css" />
<style type="text/css">
select {
	width: 150px;
}

form {
	font-size: 17px;
	margin: 50px 0 30px 0;
}

table {
	margin: 10px 0 10px 0;
	padding: 10px;
}

table tr td {
	padding: 10px 0 0 10px;
}

.thumb_img {
	width: 100px;
	height: 100px;
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
			<div style="min-height: 400px;">
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"
					method="post">
					<fieldset>
						<legend>update Info</legend>
						<table>
							<tr>
								<td>Blood ID:</td>
								<td><input type="text" name="productID" placeholder="Blood Sample ID"
									value="<?php echo $productID?>" readonly="readonly" /></td>
							</tr>
							<tr>
								<td>Name:</td>
								<td><input type="text" name="name" placeholder="Blood Group"
									value="<?php echo $name;?>" required ></td>
							</tr>
							<tr>
								<td>Price:</td>
								<td><input type="text" name="price" placeholder="price"
									value="<?php echo $unitPrice;?>" required ></td>
							</tr>
							<tr>
								<td>Discription:</td>
								<td><textarea rows="4" cols="50" name="description"
										placeholder="Hospital Name" required ><?php echo $description;?></textarea></td>
							</tr>
							<tr>
								<td>No of Packet:</td>
								<td><input type="text" name="packet" placeholder="No of packet"
									value="<?php echo $packet;?>" required ></td>
							</tr>
							<tr>
								<td></td>
								<td><input class="button" type="submit" value="Update" /></td>
							</tr>


						</table>
						<input type="hidden" name="page" value="<?php echo $page?>">
					</fieldset>
				</form>

			</div>
		</div>
		<div>
		<?php include_once '../footer.php';?>
		</div>
	</div>

</body>
</html>