<?php
session_start ();
include_once 'utils/DB.php';
include_once 'utils/config.php';

  if (! isset ( $_SESSION ['user'] )) {
  $extraUri = 'index.php';
  header ( "Location: http://$host$uri/$extraUri" );
  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Blood Bank - My Account</title>
<meta http-equiv="Content-Type"
	content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="style.css" />
<style type="text/css">
.cart_table{
background-color: #EBEBFF;
border: none;
border-radius: 25px;
}
.cart_table tr td{
border: none;
border-bottom: 1px dashed #ffffff;
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
						<table class="cart_table">
						<tr>
							<td>CustomerID</td>
							<td><?php echo $custID;?></td>
						</tr>
						<tr>
							<td>First Name:</td>
							<td><?php echo $firstname;?></td>
						</tr>
						<tr>
							<td>Last Name:</td>
							<td><?php echo $lastname;?></td>
						</tr>
						<tr>
							<td>Blood Group:</td>
							<td><?php echo $bloodGroup;?></td>
						</tr>
						<tr>
							<td>Address Line1:</td>
							<td><?php echo $addrLine1;?></td>
						</tr>
						<tr>
							<td>Address Line2:</td>
							<td><?php echo $addrLine2;?></td>
						</tr>
						<tr>
							<td>City:</td>
							<td><?php echo $city;?></td>
						</tr>
						<tr>
							<td>State:</td>
							<td><?php echo $state;?></td>
						</tr>
						<tr>
							<td>Zip:</td>
							<td><?php echo $zip;?></td>
						</tr>
						<tr>
							<td>Mobile No.</td>
							<td><?php echo $phone;?></td>
						</tr>
						<tr>
							<td>email:</td>
							<td><?php echo $email;?></td>
						</tr>
						<tr>
							<td>DOB</td>
							<td><?php echo $dob;?></td>
						</tr>
						<tr>
							<td></td>
							<td>
								<form action="change_details.php" method="post">
									<input type="hidden" value="<?php echo $custID;?>" hidd /> <input
										class="button " type="submit" value="Change Details" />
							
							</td>
						</tr>

					</table>
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
