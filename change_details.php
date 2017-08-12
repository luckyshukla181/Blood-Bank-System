<?php
session_start ();
include_once 'utils/DB.php';
include_once 'utils/config.php';
if (! isset ( $_SESSION ['user'] )) {
	$extraUri = 'index.php';
	header ( "Location: http://$host$uri/$extraUri" );
}
$msg = "";
if ($_SERVER ['REQUEST_METHOD'] == 'POST'&& isset($_POST['change'])) {
	$custID = $_POST ['custID'];
	$firstname = $_POST ['firstname'];
	$lastname = $_POST ['lastname'];
	$bloodGroup = $_POST ['bloodGroup'];
	$addrLine1 = $_POST ['addrLine1'];
	$addrLine2 = $_POST ['addrLine2'];
	$city = $_POST ['city'];
	$state = $_POST ['state'];
	$zip = $_POST ['zip'];
	$phone = $_POST ['phone'];
	$email = $_POST ['email'];
	$dob = $_POST ['dob'];
	$sql = "update customer set firstname=?,lastname=?,bloodGroup=?,addrLine1=?,addrLine2=?,city=?,state=?,zip=?,phone=?,email=?,dob=? where custID=?";
	$conn = Database::connect ();
	$stmt = $conn->prepare ( $sql );
	$result = $stmt->execute ( array (
			$firstname,
			$lastname,
			$bloodGroup,
			$addrLine1,
			$addrLine2,
			$city,
			$state,
			$zip,
			$phone,
			$email,
			$dob,
			$custID 
	) );
	if ($result) {
		echo $result;
		$extraUri = 'myaccount1.php';
		header ( "Location: http://$host$uri/$extraUri" );
	} else {
		echo $stmt->errorInfo ();
		die ( "problem in update" );
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Blood Bank- My Account</title>
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
			<div class="left_content">

				<div class="title">
					<span class="title_icon"><img src="img/radish-icon.png" alt="" /></span>My
					account
				</div>
				<div>
					<h3>Your account details....</h3>
					<?php
					$custID = $_SESSION ['user'];
					$sql = "select * from customer where custID=?";
					$conn = Database::connect ();
					$stmt = $conn->prepare ( $sql );
					$r = $stmt->execute ( array (
							$custID 
					) );
					if ($r) {
						$row = $stmt->fetch ( PDO::FETCH_ASSOC );
						// print_r ( $row );
						$firstname = $row ['firstname'];
						$lastname = $row ['lastname'];
						$bloodGroup = $row ['bloodGroup'];
						$addrLine1 = $row ['addrLine1'];
						$addrLine2 = $row ['addrLine2'];
						$city = $row ['city'];
						$state = $row ['state'];
						$zip = $row ['zip'];
						$phone = $row ['phone'];
						$email = $row ['email'];
						$dob = $row ['dob'];
						?>
						<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>"
						method="post">
						<table class="cart_table">
							<tr>
								<td>CustomerID</td>
								<td><?php echo $custID;?></td>
							</tr>
							<tr>
								<td>First Name:</td>
								<td><input type="text" name="firstname"
									value="<?php echo $firstname;?>"></td>
							</tr>
							<tr>
								<td>Last Name:</td>
								<td><input type="text" name="lastname"
									value="<?php echo $lastname;?>"></td>
							</tr
							<tr>
								<td>Blood Group:</td>
								<td><input type="text" name="bloodGroup"
									value="<?php echo $bloodGroup;?>"></td>
							</tr>
							<tr>
								<td>Address Line1:</td>
								<td><input type="text" name="addrLine1"
									value="<?php echo $addrLine1;?>"></td>
							</tr>
							<tr>
								<td>Address Line2:</td>
								<td><input type="text" name="addrLine2"
									value="<?php echo $addrLine2;?>"></td>
							</tr>
							<tr>
								<td>City:</td>
								<td><input type="text" name="city" value="<?php echo $city;?>"></td>
							</tr>
							<tr>
								<td>State:</td>
								<td><input type="text" name="state" value="<?php echo $state;?>"></td>
							</tr>
							<tr>
								<td>Zip:</td>
								<td><input type="text" name="zip" value="<?php echo $zip;?>"></td>
							</tr>
							<tr>
								<td>Mobile No.</td>
								<td><input type="text" name="phone" value="<?php echo $phone;?>"></td>
							</tr>
							<tr>
								<td>email:</td>
								<td><input type="text" name="email" value="<?php echo $email;?>"></td>
							</tr>
							<tr>
								<td>DOB</td>
								<td><input type="text" name="dob" value="<?php echo $dob;?>">&nbsp;&nbsp;&nbsp;<?php echo 'yyyy-mm-dd' ?></td>
							</tr>
							<tr>
								<td></td>
								<td><input type="submit" class="button" value="Change Details" name="change"/></td>
							</tr>

						</table>
						<input name="custID"type="hidden" value="<?php echo $custID;?>" />
					</form>
						<?php
					} else {
						echo $stmt->errorInfo ();
					}
					
					?>

				</div>

				<div class="clear"></div>
			</div>
			<!--end of left content-->

			<!--end of center content-->
			<?php include_once 'footer.php';?>
		</div>
	</div>

</body>
</html>
