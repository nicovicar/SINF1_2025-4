<?php
$conn = new mysqli("localhost", "root", "", "book_collectors");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>
