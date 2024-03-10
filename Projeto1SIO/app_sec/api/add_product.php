<?php
	include("../config.php");
	include("functions.php");
	check_login();
	check_admin_permission();
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		$data = file_get_contents('php://input');
		$json = json_decode($data, true);
		if($json != NULL && key_exists("name", $json) && key_exists("name", $json) && key_exists("description", $json) && key_exists("price", $json) && key_exists("categories", $json) && key_exists("images", $json) && key_exists("quantity", $json)){
			$name = htmlspecialchars($json["name"]);
			$description = htmlspecialchars($json["description"]);
			$price = $json["price"];
			$categories = htmlspecialchars($json["categories"]);
			$images = $json["images"];
			$quantity = $json["quantity"];
			if(empty($name) || empty($description) || empty($price) || empty($categories) || empty($images) || empty($quantity)){
				echo json_encode(array("result" => 0, "result_text" => "Um dos campos está vazio! Produto não inserido!"));
			}else{
				if(!(is_numeric($price) && (int)$price > 0)){
					echo json_encode(array("result" => 0, "result_text" => "O preço não é válido! Produto não inserido!"));
					die();
				}else if(!(is_numeric($quantity) && (int)$quantity > 0)){
					echo json_encode(array("result" => 0, "result_text" => "A quantidade não é válida! Produto não inserido!"));
				}else{
					$sql = "INSERT INTO products (name, description, price, categories, images, quantity) VALUES ('$name', '$description', '$price', '$categories', '$images', '$quantity')";
					$conn->prepare($sql)->execute();
					echo json_encode(array("result" => 1, "result_text" => "Produto adicionado com sucesso!"));
				}
			}
		}
		else{
			echo json_encode(array("result" => 0, "result_text" => "JSON inválido!"));
		}
	}
?>
