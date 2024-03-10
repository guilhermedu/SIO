<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Pragma: no-cache");
	header("Expires: 0");
	include("../config.php");
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		try{
			$data = file_get_contents('php://input');
			$json = json_decode($data, true);
			if( !($json != NULL && key_exists("id",$json)) ){
				throw new Exception("JSON inválido!");
			}else if( !(empty($json["id"]) && is_numeric($json["id"]) && (int)$json["id"] > 0) ){
				throw new Exception("ID inválido!");
			}else{
				$product_id = (int)$json["id"];
				$sql = "SELECT * FROM reviews WHERE product_id = '$product_id'";
				$stmt = $conn->prepare($sql);
				$stmt->execute();
				$result = $stmt->fetchAll();
				if(count($result) != 0){
					throw new Exception("Nenhuma avaliação encontrada!");
				}else{
					echo json_encode(array("result" => 1, "result_text" => $result));
				}
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
