<?php
function setupSession() {
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params([
        'lifetime' => $cookieParams["lifetime"],
        'path' => '/',
        'domain' => $cookieParams["domain"], 
        'secure' => true,
        'httponly' => true, 
        'samesite' => 'Lax' 
    ]);
    session_start();
}

setupSession();

$master_password = "0aafea3cfd7a98dd4e2188d89d652f96206fd8ab15b381dfd7f946293f28e339075da0f10e52f3f1c0ca96dd2d23b0d2a08ae21bcc744a32bb5149bfa59fd830";

function saltGenerator(){
	return bin2hex(random_bytes(128));
}

function keyGenerator($key, $salt){
	return hash("sha512", $key . $salt);
}

function encryptData($plaintext, $key){
    $method = 'aes-256-cbc';
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
    $ciphertext = openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $ciphertext, $key, true);
    $encryptedData = base64_encode($iv . $hmac . $ciphertext);
    return $encryptedData;
}

function decryptData($encryptedData, $key) {
    $method = 'aes-256-cbc';
    $decodedData = base64_decode($encryptedData);
    $iv = substr($decodedData, 0, openssl_cipher_iv_length($method));
    $hmac_received = substr($decodedData, openssl_cipher_iv_length($method), 32);
    $ciphertext = substr($decodedData, openssl_cipher_iv_length($method) + 32);
    $hmac_calculated = hash_hmac('sha256', $ciphertext, $key, true);
    if (!hash_equals($hmac_received, $hmac_calculated)) {
        return "Error: HMAC NOT EQUAL!";
    }
    $decryptedData = openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);
    return $decryptedData;
}

function check_admin_permission_boolean(){
	return $_SESSION["permission_level"] == 1;
}

function check_admin_permission(){
	if ($_SESSION["permission_level"] != 1) {
		header("Location: index.php");
		exit();
	}
}

function sendPOSTJSONRequest($data, $url){
    // Validate input parameters
    if (empty($data) || empty($url) || !is_array($data) || !filter_var($url, FILTER_VALIDATE_URL)) {
        // Handle invalid parameters
        return false;
    }

    // Encode data as JSON
    $json = json_encode($data);

    if ($json === false) {
        // Handle JSON encoding failure
        return false;
    }

    // Get the base URL
    $base_url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $base_url = str_replace(end(explode("/", $base_url)), "" ,$base_url);

    // Initialize cURL session
    $ch = curl_init($base_url . $url);

    // Set cURL options
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => "POST",
        CURLOPT_POSTFIELDS     => $json,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json)
        ],
    ]);

    // Execute cURL and get the result
    $result = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        // Handle cURL error
        return false;
    }

    // Close cURL session
    curl_close($ch);

    return $result;
}

function check_login_boolean(){
	return isset($_SESSION["username"]) && isset($_SESSION["token"]) && isset($_SESSION["timeout"]) && isset($_SESSION["id"]);
}

function check_login(){
	if (!isset($_SESSION["username"]) || !isset($_SESSION["token"]) || !isset($_SESSION["timeout"]) || !isset($_SESSION["id"])) {
		header("Location: login.php");
		exit();
	} else {
		timeout_function();
		$_SESSION["timeout"] = time();

		//reautenticação
		if(needs_reauthentication()) {
			header("Location: login.php");
			exit();
		}
	}
}

function needs_reauthentication(){
    $idle_timeout = 1800; // 30 minutos de inatividade antes da reautenticação
    $active_timeout = 43200; // 12 horas de uso ativo antes da reautenticação
    
    $session_time = time() - $_SESSION['timeout'];
    
    if ($session_time > $idle_timeout && check_login_boolean()) {
		exit_session();
		exit();
    } elseif ($session_time > $active_timeout && check_login_boolean()) {
		exit_session();
		exit();
    }

}

function exit_session(){
	session_unset();
	session_destroy();
	header("Location: login.php");
	exit();
}

function timeout_function(){
	$timeout = 600;
	$session_time = time() - $_SESSION['timeout'];
	if ($session_time > $timeout) {
		exit_session();
		exit();
	}
}

function generate_token() {
    $token = bin2hex(random_bytes(32)); // 32 bytes for a secure token
    return $token;
}


function isPasswordBreached($password) {
    $hashedPassword = strtoupper(sha1($password));
    $prefix = substr($hashedPassword, 0, 5);
    $suffix = substr($hashedPassword, 5);

    $url = 'https://api.pwnedpasswords.com/range/' . $prefix;
    $response = file_get_contents($url);
    if ($response === false) {
        return false;
    }

    $lines = explode("\n", $response);
    foreach ($lines as $line) {
        if (strpos($line, $suffix) !== false) {
            return true; // Password is breached
        }
    }

    return false; // Password is safe
}

function validateDoubleSpaces($password){
	$stringSemEspacosDuplos = preg_replace('/\s{2,}/', ' ', $password);
	return $stringSemEspacosDuplos == $password;
}
function processPassword($password) {
	return preg_replace('/\s+/', ' ', $password);
}

function validatePassword($password){
    $isLongEnough = strlen($password) >= 12;
    $isNotTooLong = strlen($password) <= 128;
    return $isLongEnough && $isNotTooLong;
}
?>
