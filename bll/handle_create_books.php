<?php
require_once("../dsl/connection.php");
require_once("../dao/book_dao.php");

session_start();
$user_id = 1; // temporário até login estar ativo

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dados = $_POST;
    $dados["image"] = "";

    // Upload da imagem
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $filename = basename($_FILES['image']['name']);
        $dest = "../fotos/" . $filename;
        move_uploaded_file($_FILES['image']['tmp_name'], $dest);
        $dados["image"] = $dest;
    }

    if (insertBooks($conn, $dados)) {
        header("Location: ../ui/book.php");
        exit();
    } else {
        echo "Erro ao adicionar o livro.";
    }
}
