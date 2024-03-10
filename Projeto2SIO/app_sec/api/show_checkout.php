<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Pragma: no-cache");
	header("Expires: 0");
	include("../config.php");
	include("functions.php");
	check_login();
	check_admin_permission();
	if($_SERVER["REQUEST_METHOD"] === "POST") {
		$query2 = "SELECT * FROM cart";
		$stmt2 = $conn -> prepare($query2);
		$stmt2 -> execute();
		$rows = [];
		while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
			$salt = $row['salt'];
			$new_key = keyGenerator($master_password, $salt);
			//decrypt
			$id = decryptData($row["id"], $new_key);
			$time = decryptData($row["time"], $new_key);
			$cart = decryptData($row["cart_info"], $new_key);
			$total = decryptData($row["total"], $new_key);
			//remove salt
			$id = substr($id, 0, strlen($id) - strlen($salt));
			$time = substr($time, 0, strlen($time) - strlen($salt));
			$cart = substr($cart, 0, strlen($cart) - strlen($salt));
			$total = substr($total, 0, strlen($total) - strlen($salt));
			$query3 = "SELECT username FROM users WHERE id=:id";
			$stmt3 = $conn->prepare($query3);
			$stmt3->bindParam(':id', $id);
			$stmt3->execute();
			$username = $stmt3->fetch(PDO::FETCH_ASSOC);
			$username = $username["username"];
			$cart_temp = json_decode($cart, true);
			$cart_content = [];
			foreach($cart_temp as $key => $value){
				$query4 = "SELECT * FROM products WHERE id=:id";
				$stmt4 = $conn->prepare($query4);
				$stmt4->bindParam(':id', $key);
				$stmt4->execute();
				$product = $stmt4->fetch(PDO::FETCH_ASSOC);
				$cart_content[] = [
					"id" => $product["id"],
					"name" => $product["name"],
					"price" => $product["price"],
					"quantity" => $value,
					"subtotal" => intval($product["price"]) * intval($value),
				];
			}

			$rows[] = [
					"id_user" => $id,
					"username" => $username,
					"time" => $time,
					"cart" => $cart_content,
					"total" => $total,
				];
		}
		echo json_encode($rows);
	}
?>
