<?php
require_once("../dsl/connection.php");
require_once("../dsl/event_dao.php");

session_start();
$user_id = 1; // Por enquanto, até integrar com login

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dados = $_POST;
    $dados["image_path"] = "";

    // Upload da imagem
    if (isset($_FILES['collectionImage']) && $_FILES['collectionImage']['error'] === 0) {
        $filename = basename($_FILES['collectionImage']['name']);
        $dest = "../fotos/" . time() . "_" . $filename;

        if (move_uploaded_file($_FILES['collectionImage']['tmp_name'], $dest)) {
            $dados["image_path"] = $dest;
        } else {
            echo "Erro ao salvar a imagem.";
            exit();
        }
    }

    if (insertEvent($conn, $user_id, $dados)) {
        header("Location: ../ui/events.php"); // redireciona após sucesso
        exit();
    } else {
        echo "Erro ao criar evento.";
    }
}
