<?php
require_once("../dsl/connection.php");
require_once("../dsl/book_dao.php");

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../ui/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dados = $_POST;
    $collection_ids = $_POST['collections'] ?? [];   
    $dados["image"] = "";

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $filename = basename($_FILES['image']['name']);
        $dest = "../fotos/" . $filename;
        move_uploaded_file($_FILES['image']['tmp_name'], $dest);
        $dados["image"] = $dest;
    }

    $existing_id = findBookByTitleAuthor($conn, $dados['title'], $dados['author']);

    if ($existing_id) {
        $book_id = $existing_id;               
    } else {
        try {
            insertBooks($conn, $dados);     
            $book_id = $conn->insert_id;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {       
                $book_id = findBookByTitleAuthor($conn, $dados['title'], $dados['author']);
            } else {
                throw $e;                       
            }
        }
    }

    $collection_ids = $_POST['collections'] ?? [];
    foreach ($collection_ids as $cid) {
        linkBookToCollection($conn, (int)$cid, $book_id);
    }

    header("Location: ../ui/book.php?id=$book_id");
    exit();
}
