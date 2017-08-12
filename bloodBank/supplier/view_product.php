<?php
session_start ();
include_once '../utils/DB.php';
include_once '../utils/config.php';
include_once '../utils/product.php';

if (! isset ( $_SESSION ['supplier'] )) {
	$extraUri = 'supLogin.php';
	header ( "Location: http://$host$uri/$extraUri" );
}elseif (! isset ( $_SESSION ['supplier'] ) && $_SESSION ['supplier'] == 'Hospital') {
	$extraUri = 'supLogin.php';
	header ( "Location: http://$host$uri/$extraUri" );
}

if (isset ( $_GET ['page'] )) {
	$page = $_GET ['page'];
} elseif (isset ( $_POST ['page'] )) {
	$page = $_POST ['page'];
} else {
	$page = 1;
}
// pegination const for this page
$record_per_page = 5;
$start_from = ($page - 1) * $record_per_page;
?>
<html>
<head>
<title>My Blood Bank</title>
<meta http-equiv="Content-Type"
	content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="../style.css" />
<style type="text/css">
.product_thumb {
	margin: 0px;
	padding: 2px;
	height: 50px;
	width: 50px height: px;
}

#paging {
	margin: 30px 0 30px 0;
	text-align: center;
}

#paging a {
	text-decoration: none;
	margin: 0px;
	padding: 10px 15px 10px 15px;
	background-color: #C2A3FF;
	margin-left: 2px;
	font-size: 13px;
	font-weight: bold;
}

#paging a:HOVER {
	background-color: #9B82CC;
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
			<div id="msg"> My Products...!!</div>
<?php
$supId = $_SESSION ['supplier'];
$sql = "select * from product where supId=? order by productID DESC limit $start_from,$record_per_page";
$conn = Database::connect ();
$stmt = $conn->prepare ( $sql );
$stmt->execute ( array (
		$supId 
) );
echo '<table class="cart_table">';
echo '<tr><th>Name</th><th>Price</th><th>Description</th><th>No of Packet</th><th></th><th></th></tr>';
foreach ( $stmt->fetchAll ( PDO::FETCH_CLASS, 'product' ) as $r ) {
	// $r->display ();
	echo '<tr>';
	echo '<td>' . $r->name . '</td>';
	echo '<td>' . $r->unitPrice . '</td>';
	echo '<td>' . $r->description . '</td>';
	echo '<td>' . $r->packet . '</td>';
	echo '<td><a href="edit_product.php?productID=' . $r->productID . '&page=' . $page . '">edit</a></td>';
	echo '<td><a href="delete_product.php?productID=' . $r->productID . '&page=' . $page . '">delete</a></td>';
	echo '</tr>';
}

echo '</table>';
?>
	</div>
			<div id="paging">
	<?php
	$supId = $_SESSION ['supplier'];
	$sql = "select count(*) from product where supId='" . $supId . "'";
	$result = $conn->query ( $sql );
	$total_record = $result->fetchColumn ();
	$totalPages = ceil ( $total_record / $record_per_page );
	for($i = 1; $i <= $totalPages; $i ++) {
		echo "<a href='view_product.php?page=" . $i . "'>" . $i . "</a>";
	}
	?>
	</div>
		</div>
		<div>
		<?php include_once '../footer.php';?>
		</div>
	</div>
</body>


</html>