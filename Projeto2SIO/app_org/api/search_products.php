<?php
	include("../config.php");
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		$data = file_get_contents('php://input');
		$json = json_decode($data, true);
		if(!($json != NULL && key_exists("keyword", $json)) ){
			echo json_encode(array("result" => 0, "result_text" => "JSON inválido!"));
			die();
		}else if(empty($json["keyword"])){
			echo json_encode(array("result" => 0, "result_text" => "O campo está vazio!"));
			die();
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
?>
