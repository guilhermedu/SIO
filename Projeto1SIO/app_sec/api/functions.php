<?php
session_start();

function check_admin_permission(){
	if($_SESSION["permission_level"] != 1){
		header("Location: index.php");
	}
}

function sendPOSTJSONRequest($data, $url){
		$base_url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$base_url = str_replace(end(explode("/", $base_url)), "" ,$base_url);
		$ch = curl_init($base_url . $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Content-Length: ' . strlen($data)
		));
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
}

function check_login_boolean(){
	return isset($_SESSION["username"]) && isset($_SESSION["token"]) && isset($_SESSION["timeout"]) && isset($_SESSION["id"]);
}

function check_login(){
	if(!isset($_SESSION["usernane"]) && !isset($_SESSION["token"]) && !isset($_SESSION["timeout"]) && !isset($_SESSION["id"])){
		header("Location: login.php");
		exit();
	}else{
		timeout_function();
		$_SESSION["timeout"] = time();
	}
}

function exit_session(){
	session_unset();
	session_destroy();
	header("Location: login.php");
	die();
}

function timeout_function(){
	$timeout = 600;
	$session_time = time() - $_SESSION['timeout'];
	if($session_time > $timeout){
		exit_session();
		exit();
	}
}

function generate_token(){
	$token = hash("sha256", uniqid(rand(), TRUE));
	return $token;
}
?>
