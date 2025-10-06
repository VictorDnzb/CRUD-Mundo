<?php
$servername = "localhost";
$username = "mydb";
$password = "";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
  die("Conexão falhou: " . $conn->connect_error);
}
echo "Conexão bem sucedida.";
?>