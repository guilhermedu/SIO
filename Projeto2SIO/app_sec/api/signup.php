<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");
	include("../config.php");
	include("functions.php");
	if($_SERVER['REQUEST_METHOD'] === "POST"){
		try{
			$data = file_get_contents('php://input');
			$json = json_decode($data, true);
			if(!($json != NULL && key_exists("password", $json) && key_exists("password1", $json) && key_exists("user_name", $json)) ){
				throw new Exception("JSON inválido!");
			}else if(empty($json['user_name'])){
				throw new Exception("O nome de utilizador não está definido!");
			}else if( empty($json["password"]) || empty($json["password1"]) ){
				throw new Exception("A palavra-passe não está definida!");
			}else if( $json["password"] != $json["password1"]){
				throw new Exception("As palavras-passe não coincidem!");
			}else if( isPasswordBreached($json["password"]) ){
				throw new Exception("A palavra-passe já foi comprometida!");
			}else if(!(validateDoubleSpaces($json["password"]))){
				throw new Exception("A palavra-passe não pode ter multiplos espaços!");
			}else if( !( validatePassword( $json["password"] ) ) ){
				throw new Exception("A palavra-passe necessita de ter mais que 12 e menos que 128 caracteres.");
			}else if( !(key_exists("terms", $json)) || $json["terms"] != "on"){
				throw new Exception("Os termos e condições não foram aceites!");
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
					$hash =  password_hash($password, PASSWORD_ARGON2ID, ['memory_cost' => 1<<12, 'time_cost' => 12, 'threads' => 6]);
					$query1 = "INSERT INTO users (username, password, permission_level) VALUES (:username, :hash, 2)";
					$stmt = $conn -> prepare($query1);
					$stmt -> bindParam(":username", $user_name, PDO::PARAM_STR);
					$stmt -> bindParam(":hash", $hash, PDO::PARAM_STR);
					$stmt -> execute();
					echo json_encode(array("result" => 1, "result_text" => "Utilizador criado com sucesso!"));
				}else{
					throw new Exception("O nome de utilizador já existe!");				}
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
