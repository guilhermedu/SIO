<?php
	include("../config.php");
	include("functions.php");
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		$data = file_get_contents('php://input');
		$json = json_decode($data, true);
		if(!(check_login_boolean())){
			echo json_encode(array("result" => 0, "result_text" => "Sessão não iniciada!"));
			die();
		}else if( !($json != NULL && key_exists("id", $json) && key_exists("comentario", $json)) ){
			echo json_encode(array("result" => 0, "result_text" => "JSON inválido!"));
			die();
		}else if(!(key_exists("stars", $json))){
			echo json_encode(array("result" => 0, "result_text" => "Não foi adicionada nenhuma avaliação! Comentário não inserido!"));
		}else if(empty($json["id"]) || empty($json["stars"]) || empty($json["comentario"])){
			echo json_encode(array("result" => 0, "result_text" => "Um dos campos está vazio! Comentário não inserido!"));
			die();
		}else if(!(is_numeric($json["id"]) && (int)$json["id"] > 0)){
			echo json_encode(array("result" => 0, "result_text" => "O ID é inválido! Comentário não inserido!"));
			die();
		}else if(!(is_numeric($json["stars"]) && (int)$json["stars"] >= 0 && (int)$json["stars"] <= 5 )){
			echo json_encode(array("result" => 0, "result_text" => "Número de estrelas inválido! Comentário não inserido!!"));
			die();
		}else{
			$id = (int)$json["id"];
			$query = "SELECT * FROM products WHERE id='$id' limit 1";
			$row = $conn->query($query)->fetch();
			if(count($row) == 0){
				echo json_encode(array("result" => 0, "result_text" => "Produto não encontrado na base de dados! Comentário não inserido!"));
				die();
			}
			$stars = $json["stars"];
			$comentario = htmlspecialchars($json["comentario"]);
			$username = $_SESSION["username"];
			$sql = "INSERT INTO comments (id, username, stars, comment) VALUES (:id ,:username, :stars, :comentario)";
			$stmt = $conn -> prepare($sql);
			$stmt -> bindParam(":id", $id, PDO::PARAM_INT);
			$stmt -> bindParam(":username", $username, PDO::PARAM_STR);
			$stmt -> bindParam(":stars", $stars, PDO::PARAM_STR);
			$stmt -> bindParam(":comentario", $comentario, PDO::PARAM_STR);
			$stmt -> execute();
			echo json_encode(array("result" => 1, "result_text" => "Comentário adicionado com sucesso!"));
		}
	}
?>
