<?php
session_start ();
include_once 'utils/DB.php';
include_once 'utils/config.php';

if (isset ( $_SESSION ['user'] )) {
  $extraUri = 'final.php';
  header ( "Location: http://$host$uri/$extraUri" );
  }
elseif (isset ( $_SESSION ['order_pending'] ) && $_SESSION ['order_pending'] == 'false') {
	$extraUri = 'index.php';
	header ( "Location: http://$host$uri/$extraUri" );
}
$msg = "";
if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	$errArry = array ();
	// check for form field errors
	// clean the data which is obtained
	$user = clean ( $_POST ['user'] );
	$passwd = clean ( $_POST ['passwd'] );
	if ($user == "") {
		$msg .= '<li>Please provide a userId.</li>';
		array_push ( $errArry, 1 );
	} else {
		if ($passwd == "") {
			$msg .= '<li>Please provide a password.</li>';
			array_push ( $errArry, 2 );
		}
	}
	if (empty ( $errArry )) {
		// check in the database
		$sql = "select passwd,enabled from login_master where userID=? and type=?";
		$conn = Database::connect ();
		$stmt = $conn->prepare ( $sql );
		$result = $stmt->execute ( array (
				$user,
				"receiver" 
		) );
		if ($result) {
			$row = $stmt->fetch ( PDO::FETCH_ASSOC );
			print_r ( $row );
			$dbpass = $row ['passwd'];
			$allowed = $row ["enabled"];
			if ($allowed == 'no') {
				$msg .= '<li>You are not allowed to Login to this site.<br>Please contact admin.</li>';
				unset ( $_POST );
			}
			if ($dbpass == $passwd) {
				// correct user, set userID in session
				$_SESSION ['user'] = $user;
				// check whether user has come from order_address page...if so, send back else send to home page
				if (isset ( $_SESSION ['order_pending'] )) {
					$_SESSION ['user'] = $user;
					unset ( $_SESSION ['order_pending'] );
					unset ( $_POST );
					$extraUri = 'order_address.php';
					header ( "Location: http://$host$uri/$extraUri" );
				} else {
					// first login
					unset ( $_POST );
					$extraUri = 'final.php';
					header ( "Location: http://$host$uri/$extraUri" );
				}
			} else {
				$msg .= "<li>userid or passwd is incorrect! try again!!</li>";
			}
		} else {
			// error occured in the query or user have not entered currect passwd
			// echo 'i am in else';
			$msg .= "<li>ID or Password is incorrect! try again!!</li>";
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Blood Bank - My Account</title>
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
					<span class="title_icon"></span>My
					account
				</div>
				<div class="feat_prod_box_details">
					<p class="details"></p>
					<div class="contact_form">
						<div class="form_subtitle">login into your account</div>
						<div>
				<?php
				if ($msg != "") {
					echo '<ul>' . $msg . '</ul>';
				}
				?>
				</div>
						<form name="register"
							action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"
							method="post">

							<div class="form_row">
								<label class="contact"><strong>Username:</strong></label> <input
									type="text" name="user" class="contact_input" />
							</div>
							<div class="form_row">
								<label class="contact"><strong>Password:</strong></label> <input
									type="password" name="passwd" class="contact_input" />
							</div>
							<div class="form_row">
								<div class="terms">
									<input type="checkbox" name="terms" /> Remember me
								</div>
							</div>
							<div class="form_row">
								<input type="submit" class="register" value="login" />
							</div>
						</form>
					</div>

				</div>
				<div> New user? <a href="register.php">click here</a> to register</div>
				<div class="clear"></div>
			</div>
			<!--end of left content-->

			<!--end of center content-->
			<?php include_once 'footer.php';?>
		</div>
	</div>

</body>
</html>
