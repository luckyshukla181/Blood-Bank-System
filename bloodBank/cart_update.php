<?php
session_start (); // start session
include_once ("utils/config.php"); // include config file
include_once 'utils/DB.php';

// empty cart by distroying current session
if (isset ( $_GET ["emptycart"] ) && $_GET ["emptycart"] == 1) {
	//$return_url = base64_decode ( $_GET ["return_url"] ); // return url
	session_destroy ();
	header ( 'Location:' . $return_url );
}

// add item in shopping cart
if (isset ( $_POST ["type"] ) && $_POST ["type"] == 'add') {
	$productID = filter_var ( $_POST ["productID"], FILTER_SANITIZE_STRING ); // product code
	$product_qty = filter_var ( $_POST ["product_qty"], FILTER_SANITIZE_NUMBER_INT ); // product quantity
	                                                                                  // $return_url = base64_decode ( $_POST ["return_url"] ); // return url
	                                                                                  
	// limit quantity for single product
	if ($product_qty > 2) {
		die ( '<div align="center">This demo does not allowed more than 10 quantity!<br /><a href="index.php">Back To Products</a>.</div>' );
	}
	
	// MySqli query - get details of item from db using product code
	$sql = "SELECT name,unitPrice FROM product WHERE productID=? LIMIT 1";
	$conn = Database::connect ();
	$stmt = $conn->prepare ( $sql );
	$result = $stmt->execute ( array (
			$productID 
	) );
	if ($result) {
		$obj = $stmt->fetch ( PDO::FETCH_OBJ );
		// we have the product info
		
		// prepare array for the session variable
		$new_product = array (
				array (
						'name' => $obj->name,
						'code' => $productID,
						'qty' => $product_qty,
						'price' => $obj->unitPrice 
				) 
		);
		
		if (isset ( $_SESSION ["products"] )) // if we have the session, secondtime come to this page which contains a product already
		{
			$found = false; // set found item to false
			
			foreach ( $_SESSION ["products"] as $cart_itm ) // loop through session array
			{
				// $product [] = array ();
				if ($cart_itm ["code"] == $productID) { // the item exist in array
					
					$product [] = array (
							'name' => $cart_itm ["name"],
							'code' => $cart_itm ["code"],
							'qty' => $product_qty,
							'price' => $cart_itm ["price"] 
					);
					$found = true;
				} else {
					// item doesn't exist in the list, just retrive old info and prepare array for session var
					$product [] = array (
							'name' => $cart_itm ["name"],
							'code' => $cart_itm ["code"],
							'qty' => $cart_itm ["qty"],
							'price' => $cart_itm ["price"] 
					);
				}
			}
			
			if ($found == false) // we didn't find item in array
			{
				// add new user item in array
				$_SESSION ["products"] = array_merge ( $product, $new_product );
			} else {
				// found user item in array list, and increased the quantity it merges the both array
				$_SESSION ["products"] = $product;
			}
		} else {
			// create a new session var if does not exist
			$_SESSION ["products"] = $new_product;
		}
	}
	unset($_POST);
	$extraUri = 'cart.php';
	header ( "Location: http://$host$uri/$extraUri" );
	// redirect back to original page
}

// remove item from shopping cart
if (isset ( $_GET ["removep"] ) && isset ( $_GET ["return_url"] ) && isset ( $_SESSION ["products"] )) {
	$product_code = $_GET ["removep"]; // get the product code to remove
	$return_url = base64_decode ( $_GET ["return_url"] ); // get return url
	
	foreach ( $_SESSION ["products"] as $cart_itm ) // loop through session array var
{
		if ($cart_itm ["code"] != $product_code) { // item does,t exist in the list
			$product [] = array (
					'name' => $cart_itm ["name"],
					'code' => $cart_itm ["code"],
					'qty' => $cart_itm ["qty"],
					'price' => $cart_itm ["price"] 
			);
		}
		
		// create a new product list for cart
		$_SESSION ["products"] = $product;
	}
	
	// redirect back to original page
	header ( 'Location:' . $return_url );
}
?>