
<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Pragma: no-cache");
	header("Expires: 0");
	include("../config.php");
	include("functions.php");
	check_login();
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		$sql = "SELECT * FROM products";
		$result = $conn->query($sql);
		$cart_items = [];
		$total = 0;
		$products = $_SESSION["cart"];
		foreach($result->fetchAll() as $row) {
			foreach($products as $product_id => $quantity){
				if($row["id"] == $product_id && is_numeric($quantity) && is_numeric($product_id) && (int)$product_id >= 0 && (int)$quantity >= 0){
					$cart_items[] = [
						"id" => $row["id"],
						"name" => $row["name"],
						"price" => (float)$row["price"],
						"description" => $row["description"],
						"quantity" => $quantity,
						"images" => $row["images"],
						"subtotal" => (float)$row["price"] * (int)$quantity
					];
					$total += (float)$row["price"] * (int)$quantity;
				}
			}
		}

		echo json_encode(array("cart_items" => $cart_items, "total" => $total));
	}
?>
