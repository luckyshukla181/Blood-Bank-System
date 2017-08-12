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
	$sql = "delete from product where productID=?";
	$conn = Database::connect ();
	$stmt = $conn->prepare ( $sql );
	$result = $stmt->execute ( array (
			$productID 
	) );
	if ($result) {
		$extraUri = 'view_product.php';
		header ( "Location: http://$host$uri/$extraUri" );
	} else {
		die ( "problem in delete" );
	}
}
?>