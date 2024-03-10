<?php
	include("../config.php");
	include("functions.php");
	check_login();
	$id = $_SESSION["id"];
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		$total = 0;
		if(isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0){
			foreach($_SESSION["cart"] as $cart_product => $cart_value){
				$query = "SELECT * FROM products";
				$row = $conn->query($query);
				foreach($row-> fetchAll() as $product_data){
					if($product_data["id"] == $cart_product){
						if(!((int)$product_data["quantity"] - (int)$cart_value >= 0)){
							unset($_SESSION["cart"]);
							echo json_encode(array("result" => 0, "result_text" => "O produto " . $product_data["name"] . " só tem " . $product_data["quantity"] ." disponíveis! Checkout não feito"));
							die();
						}
					}
				}
			}
		// 	// Update quantity
			foreach($_SESSION["cart"] as $cart_product => $cart_value){
					$query = "SELECT * FROM products";
					$row = $conn->query($query);
					foreach($row-> fetchAll() as $product_data){
						if($product_data["id"] == $cart_product){
							$total += $product_data["price"]*$cart_value;
							$product_data["quantity"] = (int)$product_data["quantity"] - (int)$cart_value;
							$qq = $product_data["quantity"];
							$sql = "UPDATE products SET quantity = '$qq' WHERE id = '$cart_product'";
							$stmt = $conn->prepare($sql);
							$stmt->execute();
							$result = $stmt->fetchAll();
						}
					}
				}
			$cart = json_encode($_SESSION["cart"]);
			$time = date("d/m/Y") . " / " . date("H:i");
			$query1 = "INSERT INTO cart (id, time, cart_info, total) VALUES ('$id', '$time', '$cart','$total')";
			$stmt = $conn->prepare($query1);
			$stmt->execute();
			$result = $stmt->fetchAll();
			unset($_SESSION["cart"]);
			echo json_encode(array("result" => 1, "result_text" => "Checkout feito com sucesso!"));
		}else{
			echo json_encode(array("result" => 0, "result_text" => "Não existem produtos para fazer o checkout!"));
		}
	}
?>
