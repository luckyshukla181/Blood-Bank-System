<?php
session_start ();
include_once '../utils/DB.php';
include_once '../utils/config.php';
$error = $user = "";
if (isset ( $_POST ['login'] )) {
	$user = clean ( $_POST ['demail'] );
	$passwd = clean ( $_POST ['password'] );
	$errorArray = array ();
	if ($user == "") {
		$error .= '<li>Please enter user name.</li>';
		array_push ( $errorArray, 1 );
	} else {
		if ($passwd == "") {
			$error .= '<li>Please provide a passowrd.</li>';
			array_push ( $errorArray, 2 );
		}
	}
	if (empty ( $errorArray )) {
		$sql = "select * from login_master where userID=? and type=?";
		$conn = Database::connect ();
		$stmt = $conn->prepare ( $sql );
		$result = $stmt->execute ( array (
				$user,
				"Hospital" 
		) );
		$rowcount = $stmt->rowCount ();
		if ($result && $rowcount > 0) {
			$row = $stmt->fetch ( PDO::FETCH_ASSOC );
			// print_r ( $row );
			$dbpass = $row ['passwd'];
			$allowed = $row ["enabled"];
			$type = $row ["type"];
			if ($allowed == 'no') {
				$error .= '<li>You are not allowed to Login to this site.<br>Please contact admin.</li>';
				unset ( $_POST );
			}
			if ($dbpass == $passwd) {
				// correct user, set userID in session
				$_SESSION ['supplier'] = $user;
				$_SESSION ['user_type'] = $type;
				// check whether user has come from order_address page...if so, send back else send to home page
				
				// first login
				unset ( $_POST );
				$extraUri = 'supp_home.php';
				header ( "Location: http://$host$uri/$extraUri" );
			} else {
				$error .= "<li>userid or passwd is incorrect! try again!!</li>";
			}
		} else {
			// error occured in the query or user have not entered currect passwd
			// echo 'i am in else';
			$error .= "<li>ID or Password is incorrect! try again!!</li>";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Supplier Login</title>
<meta name="robots" content="noindex, nofollow">
<!-- Include CSS File Here -->
<link rel="stylesheet" type="text/css" href="../style.css" />
<script
	src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<style type="text/css">
input[type=text], [type=password] {
	margin-bottom: 15px;
}
</style>
<!-- Include CSS File Here -->
<script type="text/javascript">
$(document).ready(function(){
$(myform).slideDown("slow");
	
});
</script>
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
			 <?php
				/*
				 * if (isset ( $_SESSION ['user'] )) {
				 * include_once 'user_welcome.php';
				 * }
				 */
				?> 
			<div class="left_content">
				<div class="container">
				<?php
				if ($error != "") {
					echo '<ul>' . $error . '</ul>';
				}
				?>
					<div class="main">
						<form method="post" id="myform"
							action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
							<fieldset>
								<legend>Login</legend>
								<table>
									<tr>
										<td><label>Email :</label></td>
										<td><input type="text" name="demail" id="email"
											value="<?php echo $user;?>"></td>
									</tr>
									<tr>
										<td><label>Password :</label></td>
										<td><input type="password" name="password" id="password"></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="submit" class="button" name="login"
											id="login" value="Login"></td>
									</tr>

								</table>
							</fieldset>
						</form>
					</div>
					<div><p>New User? &nbsp;&nbsp;<a href="sup_register.php">Click here</a> to register.</p></div>
				</div>

			</div>
		</div>

		<?php include_once '../footer.php';?>
	</div>

</body>
</html>