<?php
	include("../config.php");
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$data = file_get_contents('php://input');
		$json = json_decode($data, true);
		if( !($json != NULL && key_exists($json["id"])) ){
			echo json_encode(array("result" => 0, "result_text" => "JSON inválido!"));
			die();
		}else if( !(empty($json["id"]) && is_numeric($json["id"]) && (int)$json["id"] > 0) ){
			echo json_encode(array("result" => 0, "result_text" => "O ID é inválido!"));
			die();
		}else{
			$product_id = (int)$json["id"];
			$sql = "SELECT * FROM reviews WHERE product_id = '$product_id'";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result) != 0){
				echo json_encode(array("result" => 0, "result_text" => "Não existem reviews para serem mostradas... Porque não acrescentas uma? :) "));
				die();
			}else{
				echo json_encode(array("result" => 1, "result_text" => $result));
			}
		}
	}
?>
