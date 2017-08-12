<?php
session_start ();
include_once '../utils/DB.php';
include_once '../utils/config.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>complete</title>
<meta http-equiv="refresh" content="5;url=http://localhost/bloodBank/supplier/supLogin.php">
<meta http-equiv="Content-Type"
	content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">
#proc{
height: 200px;
width: 200px;
}
</style>

</head>
<body style="background-color: white">
	<div style="margin: 200px 0 0 300px; font-size: 18"><p>Please wait a while.....	</p><img id="proc"src="../images/processing.gif"></img></div>
</body>
</html>