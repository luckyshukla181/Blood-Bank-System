<?php
if (isset ( $_SESSION ["products"] )) {
	$current_url = base64_encode ( "http://" . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'] );
	$total = 0;
	$items = 0;
	foreach ( $_SESSION ["products"] as $cart_itm ) {
	
		$items ++;
		$subtotal = ($cart_itm ["price"] * $cart_itm ["qty"]);
		$total = ($total + $subtotal);
	}
	echo '<span class="check-out-txt"><strong>Total :Rs '. $total . '</strong>'.'<span class="check-out-items"><i>&nbspTotal Items: '.$items . '</i> <a href="cart.php">Check-out!</a></span>';
} else {
	echo 'Your Cart is empty';
}