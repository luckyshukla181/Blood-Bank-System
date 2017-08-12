<?php
session_start ();
include_once ("utils/config.php");
include_once ("utils/DB.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Blood Bank</title>
<meta http-equiv="Content-Type"
	content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">
.productImg {
	border: 1px double #DDD;
	width: 300px;
	height: 200px;
	float: left;
	margin: 20px 20px 20px 10px;
	border-radius: 5px;
}

.footer {
	clear: both;
}

.details {
	float: left;
	margin: 20px 20px 20px 10px;
	width: 400px;
	height: 200px;
	font-size: 20px;
}

.details table tr td {
	width: 400px;
	background-color: #F0F0FF;
	height: 46px;
	padding-left: 20px;
	border-radius: 6px;
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
				<form action="cart_update.php" method="post">
			<?php
			// looking in get for product_id
			
			if (isset ( $_GET ['product_id'] )) {
				$product_id = $_GET ['product_id'];
				$sql = "select * from product where productID=?";
				$conn = Database::connect ();
				$stmt = $conn->prepare ( $sql );
				$stmt->execute ( array (
						$product_id 
				) );
				$row = $stmt->fetch ( PDO::FETCH_ASSOC );
				$name = $row ['name'];
				$unitPrice = $row ['unitPrice'];
				?>
				<div>
						<div class="details">
							<table>
								<tr>
									<td>Name:</td>
									<td><?php echo $name?></td>
								</tr>
								<tr>
									<td>Unit Price:</td>
									<td><?php echo $unitPrice;?></td>
								</tr>
								<tr>
									<td>Qty:</td>
									<td><select name="product_qty"><?php
				for($i = 1; $i < 10; $i ++) {
					echo '<option value="' . $i . '">' . $i . '</option>';
				}
				?>
										</select>&nbsp;</td>
								</tr>
								<tr>
									<td></td>
									<td><input class="button" type="submit" value="add to cart" /></td>
								</tr>

							</table>
						</div>
					</div>
				<?php
				echo '<input type="hidden" name="productID" value="' . $row ["productID"] . '" />';
				echo '<input type="hidden" name="price" value="' . $row ["unitPrice"] . '" />';
				echo '<input type="hidden" name="type" value="add" />';
			}
			?>	

				</form>
			</div>
		</div>
		<?php include_once 'footer.php';?>
	</div>

</body>
</html>
