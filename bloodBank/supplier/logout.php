<?php
session_start ();
include_once '../utils/DB.php';
include_once '../utils/config.php';
unset ( $_SESSION );
$_SESSION = array ();
if (isset ( $_COOKIE [session_name ()] )) {
	setcookie ( session_name (), '', time () - 48000, '/' );
}
session_destroy ();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>logout</title>
<meta http-equiv="Content-Type"
	content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="../style.css" />
<style type="text/css">
#msg {
	margin-top: 20px;
	background-color: #F5F5FF;
	padding: 2px 0 2px 0;
	text-align: center;
	font-size: 17px;
	text-decoration: blink;
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
				<div id="msg">you have logged out successfully...!!</div>
				<div class="backlink">
					<p>
						Login again?:<a href="supLogin.php">click here.</a>
					</p>
				</div>
			</div>



		</div>
		
		<?php include_once '../footer.php';?>
	</div>
</body>
</html>