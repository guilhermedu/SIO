<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Pragma: no-cache");
	header("Expires: 0");
	include("../config.php");
	include("functions.php");
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		try{
			if(check_login_boolean()){
				$data = file_get_contents('php://input');
				$json = json_decode($data, true);
				if(!($json != NULL && key_exists("id", $json) && key_exists("quantity", $json))){
					throw new Exception("JSON inválido!");
				}else if(!(is_numeric($json["id"]) && (int)$json["id"] > 0)){
					throw new Exception("O ID é inválido!");
				}else if(!(is_numeric($json["quantity"]) && (int)$json["quantity"] > 0)){
					throw new Exception("A quantidade é inválida!");
				}else{
					$id = (int)$json["id"];
					$quantity = (int)$json["quantity"];
					$check_sql = "SELECT * FROM products WHERE id = '$id'";
					$check_result = $conn->query($check_sql)->fetchAll();
					if(count($check_result) == 1 && $quantity > 0) {
						if (isset($_SESSION["cart"]) && is_array($_SESSION["cart"])) {
							if (array_key_exists($id, $_SESSION["cart"])) {
								$_SESSION["cart"][$id] += $quantity;
							}else{
								$_SESSION["cart"][$id] = $quantity;
							}
						}else{
							$_SESSION['cart'] = array($id => $quantity);
						}
						echo json_encode(array("result" => 1, "result_text" => "Produto adicionado ao carrinho!"));
						die();
					}
				}
			}else{
				throw new Exception("Faça login para adicionar produtos ao carrinho!");
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
