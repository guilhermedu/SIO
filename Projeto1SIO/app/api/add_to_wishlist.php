
<?php
	include '../config.php';
	include "functions.php";
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$data = file_get_contents('php://input');
		$json = json_decode($data, true);
		if(!(check_login_boolean())){
			echo json_encode(array("result" => 0, "result_text" => "Faça primeiro o login para adicionar a wishlist!"));
			die();
		}else if( !($json != NULL && key_exists("product_id", $json)) ){
			echo json_encode(array("result" => 0, "result_text" => "JSON inválido!"));
			die();
		}else if( !(is_numeric($json["product_id"]) && (int)$json["product_id"] > 0) ){
			echo json_encode(array("result" => 0, "result_text" => "Produto não encontrado na base de dados!"));
			die();
		}else{
			$product_id = (int)$json['product_id'];
			$id = $_SESSION["id"];
			$check_sql = "SELECT * FROM products WHERE id = '$product_id'";
			$check_result = $conn->query($check_sql)->fetchAll();
			if(count($check_result) == 1){
				$sql = "SELECT * wishlist WHERE user_id='$id' AND product_id='$product_id'";
				$stmt = $conn->prepare($sql);
				$stmt->execute();
				$stmt-> fetchAll();
				if(count($check_result) == 1){
					echo json_encode(array("result" => 0, "result_text" => "Produto já existe na wishlist!"));
				}else{
					$sql = "INSERT INTO wishlist (user_id, product_id) VALUES ('$id', '$product_id')";
					$stmt = $conn->prepare($sql);
					$stmt->execute();
					$stmt-> fetchAll();
					echo json_encode(array("result" => 1, "result_text" => "Produto adicionado a wishlist!"));
				}
			}
		}
	}
?>
