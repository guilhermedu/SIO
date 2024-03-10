<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Pragma: no-cache");
	header("Expires: 0");
	include("../config.php");
	include("functions.php");
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		try{
			$request = file_get_contents('php://input');
			$json_request = (json_decode($request, true) != NULL) ? true : false;
			if($json_request){
				$json = json_decode($request, true);
				if(!(key_exists("id", $json))){
					throw new Exception("JSON inválido!");
				}
				else if(!(is_numeric($json["id"]) && (int)$json["id"] > 0) ){
					throw new Exception("O ID é inválido!");
				}else{
					$id = (int)$json["id"];
					$query = "SELECT * FROM products WHERE id='$id'";
					$row = $conn->query($query)->fetchAll();
					if(count($row) == 1){
						$row = $row[0];
						$rows = array(
							"id" => $row["id"],
							"name" => $row["name"],
							"description" => $row["description"],
							"price" => $row["price"],
							"categories" => $row["categories"],
							"images" => $row["images"],
							"quantity" => $row["quantity"],
						);
						echo json_encode(array("result" => 1, "result_text" => json_encode($rows)));
					}else{
						throw new Exception("Produto não encontrado!");					}
				}
			}
			else{
				$sql = "SELECT * FROM products";
				$result = $conn->query($sql);
				$rows = [];
				foreach($result -> fetchAll() as $row){
					$rows[] = [
						"id" => $row["id"],
						"name" => $row["name"],
						"description" => $row["description"],
						"price" => $row["price"],
						"categories" => $row["categories"],
						"images" => $row["images"],
						"quantity" => $row["quantity"],
					];
				}
				$json = json_encode($rows);
				echo $json;
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
