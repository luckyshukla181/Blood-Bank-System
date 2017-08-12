<?php
session_start ();
include_once 'utils/DB.php';
include_once 'utils/config.php';
// user is not logged into his account
if (! isset ( $_SESSION ['user'] )) {
	$_SESSION ['order_pending'] = "false";
	$extraUri = 'index.php';
	header ( "Location: http://$host$uri/$extraUri" );
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Summary</title>
<meta http-equiv="Content-Type"
	content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">
/* .cart_table {
	margin: 30px 0 0 90px;
	border-collapse: collapse;
	border: 1px solid black;
	width: 80%;
}

.cart_table th {
	font-size: 1.3em;
	border: 1px solid #98bf21;
	padding: 3px 7px 2px 7px;
	height: 20px;
	background-color: graytext;
}

.cart_table tr td {
	border: 1px solid black;
	height: 50px;
	background-color: white;
	font-size: 14px;
	padding-left: 20px;
}

.cart_table tr.noborder td {
	border: none;
	font-size: 15px;
	font-weight: bold;
}

 */
#msg {
	margin-top: 20px;
	background-color: #F5F5FF;
	padding: 2px 0 2px 0;
	text-align: center;
}

#msg2 {
	margin: 20px 0 20px 0;
	padding: 2px 0 2px 0;
	text-align: center;
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
				<ul>
					<li><a href="index.php">Home</a></li>
					<li><a href="myaccount.php">My Accout</a></li>
					<li><a href="register.php">Register</a></li>
					<li><a href="about.php">About us</a></li>
				</ul>
			</div>

		</div>
		<div class="center_content">
		<?php
		if (isset ( $_SESSION ['user'] )) {
			include_once 'user_welcome.php';
		}
		?>
			<div class="left_content">
				<div id="msg">
					<h3>Your Order was successfully processed...</h3>
				</div>
				<div id="msg2">
					<h4>Order Summary..</h4>
				</div>
				<table class="cart_table">

					<tr>
						<th>Blood Group</th>
						<th>Quantity</th>
						<th>Unit Price</th>
						<th>Total</th>
					</tr>
			
	<?php
	if (isset ( $_SESSION ["products"] )) {
		foreach ( $_SESSION ["products"] as $cart_itm ) // loop through session array
{
			echo '<tr><td>' . $cart_itm ['name'] . '</td><td>' . $cart_itm ['qty'] . '&nbsp;</td><td>' . $cart_itm ['price'] . '</td><td>' . $cart_itm ['qty'] * $cart_itm ['price'] . '</td></tr>';
		}
	}
	?>
	<tr class="noborder">
						<td></td>
						<td></td>
						<td>Grand Total</td>
						<td>Rs.&nbsp;&nbsp;<?php echo $_SESSION['total_amount']?></td>
					</tr>
				</table>

				<div class="backlink">
					<p>
						Go to home Page:<a href="index.php">click here.</a>
					</p>
				</div>
			</div>



		</div>
		
		<?php include_once 'footer.php';?>
	</div>
</body>
</html>