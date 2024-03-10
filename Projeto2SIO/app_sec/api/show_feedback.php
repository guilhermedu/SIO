<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Pragma: no-cache");
	header("Expires: 0");
	include("../config.php");
	include("functions.php");
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		try{
			$request = file_get_contents('php://input');
			$json = json_decode($request, true);
			if(!($json != NULL && key_exists("id", $json))){
				throw new Exception("JSON inválido!");
			}else if(!(is_numeric($json["id"]) && (int)$json["id"] > 0) ){
				throw new Exception("O ID é inválido!");
			}else{
				$id = (int)$json["id"];
				$query = "SELECT * FROM products WHERE id='$id'";
				$row = $conn->query($query)->fetchAll();
				$rows = [];
				if(count($row) > 0){
					$query = "SELECT * FROM comments WHERE id='$id'";
					$qq = $conn->query($query);
					foreach($qq -> fetchAll() as $row){
						$rows[] = [
							"id" => $row["id"],
							"stars" => $row["stars"],
							"comment" => $row["comment"],
							"username" => $row["username"],
							];
					}
					echo json_encode(array("result" => 1, "result_text" => json_encode($rows)));
				}else{
					throw new Exception("Produto não encontrado!");				}
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
