<?php
session_start ();
include_once '../utils/DB.php';
include_once '../utils/config.php';
if (! isset ( $_SESSION ['supplier'] )) {
	$extraUri = 'supLogin.php';
	header ( "Location: http://$host$uri/$extraUri" );
}
$packet = $name = $price = $discription = "";
if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	
	// clean input values
	$name = clean ( $_POST ['name'] );
	
	$price = clean ( $_POST ['price'] );
	$discription = clean ( $_POST ['discription'] );
	$packet = clean ( $_POST ['packet'] );
	// sql insert query
	$supId = $_SESSION ['supplier'];
	$sql = "insert into product (name,unitPrice,description,packet,suppDate,supId) values(?,?,?,?,?,?)";
	$conn = Database::connect ();
	$stmt = $conn->prepare ( $sql );
	$stmt->execute ( array (
			$name,
			$price,
			$discription,
			$packet,
			Date ( "Y-m-d" ),
			$supId
	)
	 );
	if ($stmt) {
		// inserted record
	} else {
		die ( "problem in insert" );
	}
	$insert_id = $conn->lastInsertId ();
	
	
	Database::disconnect ();
}
?>
<html>
<head>
<title>New Blood Stock</title>
<meta http-equiv="Content-Type"
	content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="../style.css" />
<style type="text/css">
select {
	width: 150px;
}

form {
	font-size: 17px;
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

				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"
					method="post" enctype="multipart/form-data">
					<fieldset>
						<legend>Avaible Information</legend>
						<table>
			
							<tr>
								<td>Name:</td>
								<td><input type="text" name="name" placeholder="Blood Group" required  /></td>
							</tr>
							<tr>
								<td>Price:</td>
								<td><input type="text" name="price" placeholder="price" required /></td>
							</tr>
							
							<tr>
								<td>Discription:</td>
								<td><textarea rows="4" cols="50" name="discription"
										placeholder="Hospital Name" required ></textarea></td>
							</tr>
							<tr>
								<td>No of Packet:</td>
								<td><input type="text" name="packet" placeholder="packet" required /></td>
							</tr>
							<tr>
								<td></td>
								<td><input class="button" type="submit" value="upload" /></td>
							</tr>

						</table>

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