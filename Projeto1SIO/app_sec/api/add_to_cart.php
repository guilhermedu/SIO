<?php
	include("../config.php");
	include("functions.php");
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		if(check_login_boolean()){
			$data = file_get_contents('php://input');
			$json = json_decode($data, true);
			if(!($json != NULL && key_exists("id", $json) && key_exists("quantity", $json))){
				echo json_encode(array("result" => 0, "result_text" => "JSON inválido!"));
				die();
			}else if(!(is_numeric($json["id"]) && (int)$json["id"] > 0)){
				echo json_encode(array("result" => 0, "result_text" => "ID do produto tem de ser do tipo inteiro e maior que zero!"));
				die();
			}else if(!(is_numeric($json["quantity"]) && (int)$json["quantity"] > 0)){
				echo json_encode(array("result" => 0, "result_text" => "A quantidade do produto tem de ser do tipo inteiro e maior que zero!"));
				die();
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
			echo json_encode(array("result" => 0, "result_text" => "Faça primeiro o login para fazer compras!"));
			die();
		}
	}
?>
