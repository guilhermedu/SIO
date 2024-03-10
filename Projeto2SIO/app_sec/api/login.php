<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Pragma: no-cache");
	header("Expires: 0");
	include("../config.php");
	include("functions.php");

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$data = file_get_contents('php://input');
			$json = json_decode($data, true);

			if (!($json != NULL && key_exists("user_name", $json) && key_exists("password", $json))) {
				throw new Exception("JSON inválido");
			} elseif (empty($json['user_name'])) {
				throw new Exception("Utilizador não definido!");
			} elseif (empty($json['password'])) {
				throw new Exception("Palavra-passe não definida!");
			}

			$username = htmlspecialchars($json['user_name']);
			$password = $json['password'];

			$query = "SELECT * FROM users WHERE username=:username LIMIT 1";
			$stmt = $conn->prepare($query);
			$stmt->bindParam(":username", $username, PDO::PARAM_STR);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if($username == $row["username"] && password_verify($password, $row["password"])){
				$_SESSION['token'] = generate_token();
				$_SESSION['username'] = $username;
				$_SESSION['timeout'] = time();
				$_SESSION["permission_level"] = (int)$row["permission_level"];
				$_SESSION['id'] = $row['id'];

				$result_text = "Bem-vindo, " . $username . "!";
				$result_data = ($row["permission_level"] == "1") ? array("result" => 1, "result_text" => $result_text) : array("result" => 2, "result_text" => $result_text);

				echo json_encode($result_data);
			} else {
				throw new Exception("Utilizador ou Palavra-passe erradas!");
			}
		} catch (Exception $e) {
			$errorId = uniqid();
			error_log("Error ID: $errorId - " . $e->getMessage());
			$message = $e->getMessage();
			echo json_encode(array("result" => 0, "result_text" => $message . " Por favor, entre em contato com o suporte e forneça o ID do erro: $errorId"));
		}
	}
?>

