<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Pragma: no-cache");
	header("Expires: 0");
    include("../config.php");
    include("functions.php");
    check_login();
    if($_SERVER['REQUEST_METHOD']=== "POST"){
		try{
			if(check_admin_permission_boolean()){
				throw new Exception("Só utilizadores padrão podem apagar as suas informações!");
			}
			$data = file_get_contents('php://input');
			$json = json_decode($data, true);
			if(!($json != NULL && key_exists("action", $json))){
				throw new Exception("JSON inválido!");
			}else{
				if($json["action"] == 1){
					//Delete user from database
					$id = $_SESSION["id"];
					$sql="DELETE FROM users WHERE id= :id ";
					$statement= $conn->prepare($sql);
					$statement->bindParam(':id', $id, PDO::PARAM_INT);
					$statement->execute();
					//Delete last informations
					$query2 = "SELECT id, salt FROM cart";
					$stmt2 = $conn -> prepare($query2);
					$stmt2 -> execute();
					while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
						$salt = $row['salt'];
						$new_key = keyGenerator($master_password, $salt);
						$encrypted_id = decryptData($row["id"], $new_key);
						$database_id = substr($encrypted_id, 0, strlen($encrypted_id) - strlen($salt));
						echo $database_id;
						if((int)$database_id == (int)$id){
							echo $encrypted_id;
							$query3 = "DELETE FROM cart WHERE id= :id";
							$stmt3 = $conn -> prepare($query3);
							$stmt3->bindParam(':id', $row["id"], PDO::PARAM_INT);
							$stmt3 -> execute();
						}
					}
					session_unset();
					echo json_encode(array("result" => 1, "result_text" => "Utilizador deletado com sucesso!"));
				}else if($json["action"] == 2){
					$query2 = "SELECT * FROM cart";
					$stmt2 = $conn -> prepare($query2);
					$stmt2 -> execute();
					$str = "{\"result\":1, \"result_text\":\"Começando o download...\"}" . "\n";
					$str = $str . "\n\n\tUsername: " . $_SESSION["username"] . "\n\n\n\n";
					while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
						$salt = $row['salt'];
						$new_key = keyGenerator($master_password, $salt);
						//decrypt
						$id = decryptData($row["id"], $new_key);
						$id = substr($id, 0, strlen($id) - strlen($salt));
						if((int)$id == (int)$_SESSION["id"]){
							$time = decryptData($row["time"], $new_key);
							$cart = decryptData($row["cart_info"], $new_key);
							$total = decryptData($row["total"], $new_key);
							$time = substr($time, 0, strlen($time) - strlen($salt));
							$cart = substr($cart, 0, strlen($cart) - strlen($salt));
							$total = substr($total, 0, strlen($total) - strlen($salt));
							$str = $str . "\tData de compra: " . $time . "\n";
							$str = $str . "\tPreço total da compra: " . $total . "€\n\n\n";
							$cart_temp = json_decode($cart, true);
							$cart_content = [];
							foreach($cart_temp as $key => $value){
								$query4 = "SELECT * FROM products WHERE id=:id";
								$stmt4 = $conn->prepare($query4);
								$stmt4->bindParam(':id', $key);
								$stmt4->execute();
								$product = $stmt4->fetch(PDO::FETCH_ASSOC);
								$str = $str . "\t\tNome do produto: " . $product["name"] . "\n";
								$str = $str . "\t\tPreço do produto: " . $product["price"] . "\n";
								$str = $str . "\t\tQuantidade comprada:" . $value . "\n";
								$str = $str . "\t\tSubtotal do produto: " . intval($product["price"]) * intval($value) . "€\n\n";
							}
							$str = $str . "\n\n";
						}
					}
				header('Content-Disposition: attachment; filename="dados.txt"');
					header('Content-Type: text/plain');
					echo $str;
					exit();
				}else{
					throw new Exception("A opção selecionada não existe!");
				}
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
