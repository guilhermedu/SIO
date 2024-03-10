<?php
$servername = "localhost";
$username = "app_sec_mysql_user_n_1";
$password = "SDAs2123@_122";

try {
  $conn = new PDO("mysql:host=$servername;dbname=app_sec", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
