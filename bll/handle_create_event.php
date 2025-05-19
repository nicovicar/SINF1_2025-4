<?php
require_once("../dsl/connection.php");
require_once("../dsl/event_dao.php");

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../ui/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dados = $_POST;
    $dados["image_path"] = "";

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
