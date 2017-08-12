<?php
session_start ();
include_once '../utils/DB.php';
include_once '../utils/config.php';
if (! isset ( $_SESSION ['supplier'] ) && $_SESSION ['supplier'] == 'Hospital') {
	$extraUri = 'supLogin.php';
	header ( "Location: http://$host$uri/$extraUri" );
}
if ($_SERVER ['REQUEST_METHOD'] == 'GET' && isset ( $_GET ['odid'] )) {
	$odid = clean ( $_GET ['odid'] );
	$sql = "update orderDetails set status=? where ODID=?";
	$conn = Database::connect ();
	$stmt = $conn->prepare ( $sql );
	$result = $stmt->execute ( array (
			2,
			$odid 
	) );
	if ($result) {
		$extraUri = 'todaysorder.php';
		header ( "Location: http://$host$uri/$extraUri" );
	} else {
		$extraUri = 'error.php';
		header ( "Location: http://$host$uri/$extraUri" );
	}
}
?>