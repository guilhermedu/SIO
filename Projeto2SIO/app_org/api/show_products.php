<?php
	include("../config.php");
	include("functions.php");
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$request = file_get_contents('php://input');
		$json_request = (json_decode($request, true) != NULL) ? true : false;
		if($json_request){
			$json = json_decode($request, true);
			if(!(key_exists("id", $json))){
				echo json_encode(array("result" => 0, "result_text" => "JSON inválido!"));
				die();
			}
			else if(!(is_numeric($json["id"]) && (int)$json["id"] > 0) ){
				echo json_encode(array("result" => 0, "result_text" => "O ID é inválido!"));
				die();
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
					echo json_encode(array("result" => 0, "result_text" => "Produto não encontrado na base de dados!"));
				}
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
?>
