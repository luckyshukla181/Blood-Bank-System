<?php
function clean($data){
	$data=trim($data);
	$data=stripcslashes($data);
	$data=htmlentities($data);
	return $data;
}
//get image extension
function GetImageExtension($imagetype) {
	if (empty ( $imagetype ))
		return false;
	switch ($imagetype) {
		case 'image/bmp' :
			return '.bmp';
		case 'image/gif' :
			return '.gif';
		case 'image/jpeg' :
			return '.jpg';
		case 'image/png' :
			return '.png';
		default :
			return false;
	}
}
//URL decleartion for redirection on the local host
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

?>
<?php 
//url for project base directory
$projectBase=$_SERVER["DOCUMENT_ROOT"]."/bloodBank";
?>