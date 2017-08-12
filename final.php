<?php
?>
<?php

session_start ();
// if user has come here after completing a shopping, clear session data
if (isset ( $_SESSION ['order_pending'] ) && $_SESSION ['order_pending'] == "false") {
	unset ( $_SESSION ['order_pending'] );
	unset ( $_SESSION ['products'] );
}
include_once 'utils/DB.php';
include_once 'utils/config.php';
function feat_product($id, $name, $description) {
	echo '<div class="feat_prod_box">';
	echo '<div class="prod_det_box">';
	echo '<div class="box_top"></div>';
	echo '<div class="box_center">';
	echo '<div class="prod_title">' . $name . '</div>';
	echo '<p class="details">' . $description . '</p>';
	echo '<a href="view_product.php?product_id=' . $id . '" class="more">- Add to cart -</a>';
	echo '<div class="clear"></div>';
	echo '</div>';
	echo '<div class="box_bottom"></div>';
	echo '</div>';
	echo '<div class="clear"></div>';
	echo '</div>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Blood Bank</title>
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
			<div class="title">
				
			</div>
				 <?php
				$sql = "select productID,name,description from product limit 6 ";
				$conn = Database::connect ();
				$stmt = $conn->prepare ( $sql );
				$result = $stmt->execute ();
				if ($result) {
					foreach ( $stmt->fetchAll ( PDO::FETCH_FUNC, 'feat_product' ) as $row ) {
						echo $row;
					}
				}
				
				?>

	</div>
		<div class="clear">
			<a href=""> view more</a>
		</div>

	</div>
	<?php include_once 'footer.php';?>
	</div>
</body>
</html>