<?php
$servername = "localhost";
$username = "root";
$password = "SDAs2123@_122";

try {
  $conn = new PDO("mysql:host=$servername;dbname=app", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
