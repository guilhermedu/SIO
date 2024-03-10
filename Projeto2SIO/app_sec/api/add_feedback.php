<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Pragma: no-cache");
	header("Expires: 0");
	include("../config.php");
	include("functions.php");

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		try {
			$data = file_get_contents('php://input');
			$json = json_decode($data, true);

			// Check if user is logged in
			if (!check_login_boolean()) {
				throw new Exception("Sessão não iniciada!");
			} elseif (!($json != NULL && key_exists("id", $json) && key_exists("comentario", $json))) {
				throw new Exception("JSON inválido!");
			} elseif (!key_exists("stars", $json)) {
				throw new Exception("Não foi adicionada nenhuma avaliação! Comentário não inserido!");
			} elseif (empty($json["id"]) || empty($json["stars"]) || empty($json["comentario"])) {
				throw new Exception("Um dos campos está vazio! Comentário não inserido!");
			} elseif (!(is_numeric($json["id"]) && (int)$json["id"] > 0)) {
				throw new Exception("O ID é inválido! Comentário não inserido!");
			} elseif (!(is_numeric($json["stars"]) && (int)$json["stars"] >= 0 && (int)$json["stars"] <= 5)) {
				throw new Exception("Número de estrelas inválido! Comentário não inserido!!");
			} else {
				$id = (int)$json["id"];

				// Check if the product exists
				$query = "SELECT * FROM products WHERE id=:id LIMIT 1";
				$stmt = $conn->prepare($query);
				$stmt->bindParam(":id", $id, PDO::PARAM_INT);
				$stmt->execute();
				$row = $stmt->fetch();

				if (!$row) {
					throw new Exception("Produto não encontrado na base de dados! Comentário não inserido!");
				}

				$stars = $json["stars"];
				$comentario = htmlspecialchars($json["comentario"]);
				$username = $_SESSION["username"];

				// Insert comment into the database
				$sql = "INSERT INTO comments (id, username, stars, comment) VALUES (:id, :username, :stars, :comentario)";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(":id", $id, PDO::PARAM_INT);
				$stmt->bindParam(":username", $username, PDO::PARAM_STR);
				$stmt->bindParam(":stars", $stars, PDO::PARAM_STR);
				$stmt->bindParam(":comentario", $comentario, PDO::PARAM_STR);
				$stmt->execute();

				echo json_encode(array("result" => 1, "result_text" => "Comentário adicionado com sucesso!"));
			}
		} catch (Exception $e) {
			$errorId = uniqid();
			error_log("Error ID: $errorId - " . $e->getMessage());
			$message = $e->getMessage();
			echo json_encode(array("result" => 0, "result_text" => $message . " Por favor, entre em contato com o suporte e forneça o ID do erro: $errorId"));
		}
	}
?>
