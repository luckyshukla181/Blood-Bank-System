<?php
class Database {
	private static $conn;
	public static function connect() {
		$username = "root";
		$password = "";
		$dsn='mysql:host=localhost;dbname=bloodbank';
		global $conn; 
		if (isset ( $conn )) {
			return $conn;
		} else {
			try {
				$conn = new PDO ( $dsn, $username, $password );
				// set the PDO error mode to exception
				$conn->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				//echo "connection successfull...<br>";
			} catch ( PDOException $e ) {
				echo "<br>" . $e->getMessage ();
				die ( "could not create connection" );
			}
		}
		return $conn;
	}
	public static function disconnect() {
		global $conn;
		if (isset ( $conn )) {
			$conn = null;
			//echo "connection closed..";
		}
	}
}
?> 