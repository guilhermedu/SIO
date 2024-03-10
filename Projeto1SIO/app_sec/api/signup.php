<?php
	include("../config.php");
	if($_SERVER['REQUEST_METHOD'] === "POST"){
		$data = file_get_contents('php://input');
		$json = json_decode($data, true);
		if(!($json != NULL && key_exists("password", $json) && key_exists("password1", $json) && key_exists("user_name", $json)) ){
			echo json_encode(array("result" => 0, "result_text" => "JSON inválido!"));
			die();
		}else if(empty($json['user_name'])){
			echo json_encode(array("result" => 0, "result_text" => "Utilizador não definido!"));
			die();
		}else if( empty($json["password"]) || empty($json["password1"]) ){
			echo json_encode(array("result" => 0, "result_text" => "As palavras-passe não estão definidas!"));
			die();
		}else if( $json["password"] != $json["password1"]){
			echo json_encode(array("result" => 0, "result_text" => "As palavras-passe não são iguais!"));
			die();
		}
		$uppercase = preg_match('@[A-Z]@',$json["password"]);
		$number = preg_match('@[0-9]@',$json["password"]);
		$specialChars = preg_match('@[^\W]@',$json["password"]);
		$specialChars1 = preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/',$json["password"]);
		if( !(strlen($json["password"]) >= 8 && $uppercase && $number && $specialChars && $specialChars1)){
			echo json_encode(array("result" => 1, "result_text" => "A palavra-passe necessita de ter mais que 8 caracteres, conter pelo menos uma maiúscula, um símbolo e um número"));
			die();
		}else{
			$user_name = htmlspecialchars($json['user_name']);
			$password = $json['password'];
			$password1 = $json['password1'];
			$query = "SELECT * FROM users WHERE username =:username";
			$stmt = $conn -> prepare($query);
			$stmt -> bindParam(":username", $user_name, PDO::PARAM_STR);
			$stmt -> execute();
			$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			if(count($row) == 0){
				$hash = hash("sha256", $password);
				$query1 = "INSERT INTO users (username, password, permission_level) VALUES (:username, :hash, 2)";
				$stmt = $conn -> prepare($query1);
				$stmt -> bindParam(":username", $user_name, PDO::PARAM_STR);
				$stmt -> bindParam(":hash", $hash, PDO::PARAM_STR);
				$stmt -> execute();
				echo json_encode(array("result" => 1, "result_text" => "Utilizador criado com sucesso!"));
			}else{
				echo json_encode(array("result" => 0, "result_text" => "O Utilizador já existe!"));
			}
		}
	}
?>
