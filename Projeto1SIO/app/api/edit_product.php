<?php
	include("../config.php");
	include("functions.php");
	check_login();
	//check_admin_permission();
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		$data = file_get_contents('php://input');
		$json = json_decode($data, true);
		if( !($json != NULL && key_exists("id", $json) && key_exists("name", $json) && key_exists("description", $json) && key_exists("price", $json) && key_exists("categories", $json) && key_exists("images", $json) && key_exists("quantity", $json)) ){
			echo json_encode(array("result" => 0, "result_text" => "JSON inválido!"));
			die();
		}else if(empty($json["id"]) || empty($json["name"]) || empty($json["description"]) || empty($json["price"]) || empty($json["categories"]) || empty($json["images"]) || empty($json["quantity"])){
			echo json_encode(array("result" => 0, "result_text" => "Um dos campos está vazio! Produto não editado!"));
			die();
		}else if(!(is_numeric($json["price"]) && (int)$json["price"] > 0)){
			echo json_encode(array("result" => 0, "result_text" => "O preço é inválido! Produto não editado!"));
			die();
		}else if(!(is_numeric($json["quantity"]) && (int)$json["quantity"] >= 0)){
			echo json_encode(array("result" => 0, "result_text" => "A quantidade é inválida! Produto não editado!"));
			die();
		}else if(!(is_numeric($json["id"]) && (int)$json["id"] >= 0)){
			echo json_encode(array("result" => 0, "result_text" => "O ID é inválido! Produto não editado!"));
			die();
		}else{
			$id = (int)$json["id"];
			$name = $json["name"];
			$description = $json["description"];
			$price = (float)$json["price"];
			$categories = $json["categories"];
			$images = $json["images"];
			$quantity = (int)$json["quantity"];
			if($images == "nochange"){
				$sql = "UPDATE products SET name='$name', description='$description', price='$price', categories='$categories', quantity='$quantity' WHERE id='$id'";
				$conn->prepare($sql)->execute();
			}else{
				$sql = "UPDATE products SET name='$name', description='$description', price='$price', categories='$categories', images='$images', quantity='$quantity' WHERE id='$id'";
				$conn->prepare($sql)->execute();
			}
			echo json_encode(array("result" => 1, "result_text" => "Produto editado com sucesso!"));
		}
	}
?>
