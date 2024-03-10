<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Pragma: no-cache");
	header("Expires: 0");
	include("../config.php");
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		try{
			$data = file_get_contents('php://input');
			$json = json_decode($data, true);
			if(!($json != NULL && key_exists("keyword", $json)) ){
				throw new Exception("JSON inválido!");
			}else if(empty($json["keyword"])){
				throw new Exception("Campo vazio!");
			}else{
				$keyword = htmlspecialchars($json["keyword"]);
				$search_term = "%" . $keyword . "%";
				$sql = "SELECT * FROM products WHERE name LIKE :search_term OR description LIKE :search_term OR categories LIKE :search_term";
				$stmt = $conn->prepare($sql);
				$stmt -> bindParam(":search_term", $search_term, PDO::PARAM_STR);
				$stmt->execute();
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if(count($result) > 0){
					echo json_encode(array("result" => 1, "result_text" => $result, "keyword" => $keyword));
				}else{
					echo json_encode(array("result" => 0, "result_text" => "Produto não encontrado!", "keyword" => $keyword));
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
