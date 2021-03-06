<?php
session_start ();
include_once '../utils/DB.php';
include_once '../utils/config.php';
if ($_SERVER ['REQUEST_METHOD'] == 'POST' && isset ( $_POST ['register'] )) {
	echo 'hi';
	$user = clean ( $_POST ['userID'] );
	$password = clean ( $_POST ['passwd'] );
	$email = clean ( $_POST ['email'] );
	$firstname = clean ( $_POST ['firstname'] );
	$phone = clean ( $_POST ['phone'] );
	$addline1 = clean ( $_POST ['addline1'] );
	$sql1 = "insert into supplier values(?,?,?,?,?)";
	$sql2 = "insert into login_master values(?,?,?,?)";
	$conn = Database::connect ();
	try {
		$conn->beginTransaction ();
		$stmt = $conn->prepare ( $sql1 );
		$stmt->execute ( array (
				$user,
				$firstname,
				$addline1,
				$phone,
				$email
		) );
		$stmt = $conn->prepare ( $sql2 );
		$stmt->execute ( array (
				$user,
				$password,
				'Hospital',
				'no' 
		) );
		$conn->commit ();
		$extraUri = 'registration_complete.php';
		header ( "Location: http://$host$uri/$extraUri" );
	} catch ( Exception $e ) {
		$conn->rollBack ();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Veg shop - Register</title>
<meta http-equiv="Content-Type"
	content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="../style.css" />
<style type="text/css">
.contact_form {
	margin-left: 200px;
	padding-bottom: 50px;
	background-color: #E0E0FF;
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
				<?php include_once 'menu_content.php';?>
			</div>

		</div>
		<div class="center_content">
			<div class="left_content">
				
				<div class="feat_prod_box_details">
					<p class="details"></p>
					<div class="contact_form">
						<div class="form_subtitle">create new account</div>
						<form name="register"
							action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"
							method="post">
							<div class="form_row">
								<label class="contact"><strong>Username:</strong></label> <input
									type="text" class="contact_input" name="userID" required />
							</div>
							<div class="form_row">
								<label class="contact"><strong>Password:</strong></label> <input
									type="password" class="contact_input" name="passwd" required  />
							</div>
							<div class="form_row">
								<label class="contact"><strong>Email:</strong></label> <input
									type="text" class="contact_input" name="email" required />
							</div>
							<div class="form_row">
								<label class="contact"><strong>Name:</strong></label> <input
									type="text" class="contact_input" name="firstname" required />
							</div>
							<div class="form_row">
								<label class="contact"><strong>Phone:</strong></label> <input
									type="text" class="contact_input" name="phone" required />
							</div>
							<div class="form_row">
								<label class="contact"><strong>AddressLine1:</strong></label> <input
									type="text" class="contact_input" name="addline1" required />
							</div>
							<div class="form_row">
								<div class="terms">
									<input type="checkbox" name="terms" /> I agree to the <a
										href=""required >terms &amp; conditions</a>
								</div>
							</div>
							<div class="form_row">
								<input type="submit" name="register" class="register"
									value="Register" />
							</div>
						</form>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<!--end of left content-->
		</div>
			<?php include_once '../footer.php';?>

</div>
</body>
</html>
