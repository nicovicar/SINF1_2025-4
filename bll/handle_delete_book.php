<?php
require_once("../dsl/connection.php");

if (!isset($_GET['id']) || !isset($_GET['collection_id'])) {
    die("Informações insuficientes para deletar o livro.");
}

$book_id = intval($_GET['id']);
$collection_id = intval($_GET['collection_id']);

$stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
$stmt->bind_param("i", $book_id);

if ($stmt->execute()) {
    header("Location: edit_collection.php?id=" . $collection_id);
    exit();
} else {
    echo "Erro ao deletar o livro.";
}

$stmt->close();
$conn->close();
?>
