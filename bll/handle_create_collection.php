<?php
require_once("../dsl/connection.php");
require_once("../dsl/collection_dao.php");

session_start();
$user_id = 1; // por enquanto, até integrar com login

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dados = $_POST;
    $dados["image_path"] = "";

    // Upload da imagem
    if (isset($_FILES['collectionImage']) && $_FILES['collectionImage']['error'] === 0) {
        $filename = basename($_FILES['collectionImage']['name']);
        $dest = "../fotos/" . $filename;
        move_uploaded_file($_FILES['collectionImage']['tmp_name'], $dest);
        $dados["image_path"] = $dest;
    }

    if (insertCollection($conn, $user_id, $dados)) {
        header("Location: ../ui/collections.php");
        exit();
    } else {
        echo "Erro ao criar coleção.";
    }
}
