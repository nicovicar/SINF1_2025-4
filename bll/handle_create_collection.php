<?php
require_once("../dsl/connection.php");
require_once("../dsl/collection_dao.php");

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
        $dest = "../fotos/" . $filename;
        move_uploaded_file($_FILES['collectionImage']['tmp_name'], $dest);
        $dados["image_path"] = $dest;
    }

    if (insertCollection($conn, $user_id, $dados)) {

       
        $collection_id = $conn->insert_id;

        header("Location: ../ui/create_book.php?collection_id=$collection_id");
        exit();

    } else {
        echo "Erro ao criar coleção.";
    }
}
