<?php
class product {
	public $categoryID ;
	public $name ;
	public $unitPrice;
	public $description;
	public $image;
	public $productID;
	public function display() {
		echo '<tr>';
		echo '<td>' . $this->categoryID . '</td>';
		echo '<td>' . $this->name . '</td>';
		echo '<td>' . $this->unitPrice . '</td>';
		echo '<td>' . $this->description . '</td>';
		echo '<td><img src="' . $this->image . '"></img></td>';
		echo '<td><a href="product_edit.php?productID=' . $this->productID . '">Edit</a></td>';
		echo '</tr>';
	}
}
?>