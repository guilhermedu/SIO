<?php
	include("../config.php");
	include("functions.php");
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$data = file_get_contents('php://input');
		$json = json_decode($data, true);
		if(!($json != NULL && key_exists("user_name", $json) && key_exists("password", $json)  )){
			echo json_encode(array("result" => 0, "result_text" => "JSON inválido"));
			die();
		}else if (empty($json['user_name'])){
			echo json_encode(array("result" => 0, "result_text" => "Utilizador não definido!"));
			die();
		}else if(empty($json['password'])){
			echo json_encode(array("result" => 0, "result_text" => "Palavra-passe não definida!"));
			die();
		}else{
			$username = htmlspecialchars($json['user_name']);
			$password = $json['password'];
			$query = "SELECT * FROM users WHERE username=:username limit 1";
			$stmt = $conn -> prepare($query);
			$stmt -> bindParam(":username", $username, PDO::PARAM_STR);
			$stmt -> execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if($username == $row["username"] && hash('sha256', $password) === $row["password"]){
				$_SESSION['token'] = generate_token();
				$_SESSION['username'] = $username;
				$_SESSION['timeout'] = time();
				$_SESSION["permission_level"] = (int)$row["permission_level"];
				$_SESSION['id'] = $row['id'];
				$result_text = "Bem-vindo, " . $username . "!";
				if ($row["permission_level"] == "1"){
					echo json_encode(array("result" => 1, "result_text" => $result_text));
				}else{
					echo json_encode(array("result" => 2, "result_text" => $result_text));
				}
			}else{
				echo json_encode(array("result" => 0, "result_text" => "Utilizador ou Palavra-passe erradas!"));
			}
		}
	}
?>
