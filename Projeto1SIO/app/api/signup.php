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
		}else{
			$user_name = $json['user_name'];
			$password = $json['password'];
			$password1 = $json['password1'];
			$query = "SELECT * FROM users WHERE username ='$user_name'";
			$row = $conn->query($query)->fetch();
			if($row == 0){
				$hash = hash("sha256", $password);
				$query1 = "INSERT INTO users (username, password, permission_level) VALUES ('$user_name', '$hash', 2)";
				$value = $conn->query($query1)->fetch();
				echo json_encode(array("result" => 1, "result_text" => "Utilizador criado com sucesso!"));
			}else{
				echo json_encode(array("result" => 0, "result_text" => "O Utilizador já existe!"));
			}
		}
	}
?>
