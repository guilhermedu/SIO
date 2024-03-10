<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Pragma: no-cache");
	header("Expires: 0");
	include("../config.php");
	include("functions.php");
	check_login();
	check_admin_permission();
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		try{
			$data = file_get_contents('php://input');
			$json = json_decode($data, true);
			if( !($json != NULL && key_exists("id", $json) && key_exists("name", $json) && key_exists("description", $json) && key_exists("price", $json) && key_exists("categories", $json) && key_exists("images", $json) && key_exists("quantity", $json)) ){
				throw new Exception("JSON inválido!");
			}else if(empty($json["id"]) || empty($json["name"]) || empty($json["description"]) || empty($json["price"]) || empty($json["categories"]) || empty($json["images"]) || empty($json["quantity"])){
				throw new Exception("Um dos campos está vazio! Produto não editado!");
			}else if(!(is_numeric($json["price"]) && (int)$json["price"] > 0)){
				throw new Exception("O preço é inválido! Produto não editado!");
			}else if(!(is_numeric($json["quantity"]) && (int)$json["quantity"] >= 0)){
				throw new Exception("A quantidade é inválida! Produto não editado!");
			}else if(!(is_numeric($json["id"]) && (int)$json["id"] >= 0)){
				throw new Exception("O ID é inválido! Produto não editado!");
			}else{
				$id = (int)$json["id"];
				$name = htmlspecialchars($json["name"]);
				$description = htmlspecialchars($json["description"]);
				$price = (float)$json["price"];
				$categories = htmlspecialchars($json["categories"]);
				$images = htmlspecialchars($json["images"]);
				$quantity = (int)$json["quantity"];
				if($images == "nochange"){
					$sql = "UPDATE products SET name=:name, description=:description, price=:price, categories=:categories, quantity=:quantity WHERE id=:id";
					$stmt = $conn -> prepare($sql);
					$stmt -> bindParam(":id", $id, PDO::PARAM_INT);
					$stmt -> bindParam(":name", $name, PDO::PARAM_STR);
					$stmt -> bindParam(":description", $description, PDO::PARAM_STR);
					$stmt -> bindParam(":price", $price, PDO::PARAM_STR);
					$stmt -> bindParam(":categories", $categories, PDO::PARAM_STR);
					$stmt -> bindParam(":quantity", $quantity, PDO::PARAM_INT);
					$stmt -> execute();
				}else{
					$sql = "UPDATE products SET name=:name, description=:description, price=:price, categories=:categories, images=:images, quantity=:quantity WHERE id=:id";
					$stmt -> bindParam(":id", $id, PDO::PARAM_INT);
					$stmt -> bindParam(":name", $name, PDO::PARAM_STR);
					$stmt -> bindParam(":description", $description, PDO::PARAM_STR);
					$stmt -> bindParam(":price", $price, PDO::PARAM_STR);
					$stmt -> bindParam(":categories", $categories, PDO::PARAM_STR);
					$stmt -> bindParam(":images", $images, PDO::PARAM_STR);
					$stmt -> bindParam(":quantity", $quantity, PDO::PARAM_INT);
					$stmt -> execute();
				}
				echo json_encode(array("result" => 1, "result_text" => "Produto editado com sucesso!"));
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
