<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Pragma: no-cache");
	header("Expires: 0");
	include("../config.php");
	include("functions.php");
	check_login();
	$id = $_SESSION["id"];
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		try{
			$total = 0;
			if(isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0){
				foreach($_SESSION["cart"] as $cart_product => $cart_value){
					$query = "SELECT * FROM products";
					$row = $conn->query($query);
					foreach($row-> fetchAll() as $product_data){
						if($product_data["id"] == $cart_product){
							if(!((int)$product_data["quantity"] - (int)$cart_value >= 0)){
								unset($_SESSION["cart"]);
								throw new Exception("O produto " . $product_data["name"] . " só tem " . $product_data["quantity"] ." disponíveis! Checkout não feito");
							}
						}
					}
				}
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
				$salt = saltGenerator();
				$cart = json_encode($_SESSION["cart"]);
				$time = date("d/m/Y") . " / " . date("H:i");
				$new_key = keyGenerator($master_password, $salt);
				$id = encryptData($id . $salt, $new_key);
				$time = encryptData($time . $salt, $new_key);
				$cart = encryptData($cart . $salt, $new_key);
				$total = encryptData($total . $salt, $new_key);
				$query1 = "INSERT INTO cart (id, time, cart_info, total, salt) VALUES (:id, :time, :cart, :total, :salt)";
				$stmt = $conn->prepare($query1);
				$stmt->bindParam(':id', $id);
				$stmt->bindParam(':time', $time);
				$stmt->bindParam(':cart', $cart);
				$stmt->bindParam(':total', $total);
				$stmt->bindParam(':salt', $salt);
				$stmt->execute();
				unset($_SESSION["cart"]);
				echo json_encode(array("result" => 1, "result_text" => "Checkout feito com sucesso!"));
			}else{
				throw new Exception("Não existem produtos no carrinho!");
			}
		}
		catch (Exception $e) {
			$errorId = uniqid();
			error_log("Error ID: $errorId - " . $e->getMessage());
			$message = $e->getMessage();
			echo json_encode(array("result" => 0, "result_text" => $message . " Por favor, entre em contato com o suporte e forneça o ID do erro: $errorId"));
		}
	}
?>
