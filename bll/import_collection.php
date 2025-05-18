<?php
require_once("../dsl/connection.php");
require_once("../dsl/collection_dao.php");
require_once("../dsl/book_dao.php");

session_start();
$user_id = 1; // Substituir futuramente por $_SESSION['user_id']

if ($_FILES['csv']['error'] === UPLOAD_ERR_OK) {
    $file = fopen($_FILES['csv']['tmp_name'], 'r');
    $header = fgetcsv($file); // Ignora o cabeçalho

    $colecoes_inseridas = []; // Evita inserir coleções duplicadas

    while (($data = fgetcsv($file)) !== false) {
        // Extrai dados da coleção da linha atual
        $collection_key = $data[0] . '|' . $data[1] . '|' . $data[2]; // título|descrição|imagem
        if (!isset($colecoes_inseridas[$collection_key])) {
            $collection = [
                'title' => $data[0],
                'description' => $data[1],
                'image_path' => $data[2]
            ];
            $collection_id = insertCollection($conn, $user_id, $collection);
            $colecoes_inseridas[$collection_key] = $collection_id;
        } else {
            $collection_id = $colecoes_inseridas[$collection_key];
        }

        // Extrai dados do livro
        $book = [
            'title' => $data[3],
            'author' => $data[4],
            'year' => $data[5],
            'editor' => $data[6],
            'language' => $data[7],
            'binding' => $data[8],
            'pages' => $data[9],
            'weight' => $data[10],
            'price' => $data[11],
            'date_of_acquisition' => $data[12],
            'description' => $data[13],
            'importance' => $data[14],
            'image' => $data[15]
        ];

        // Verifica se o livro já existe
        $existing_id = findBookByTitleAuthor($conn, $book['title'], $book['author']);

        if ($existing_id) {
            $book_id = $existing_id;
        } else {
            insertBooks($conn, $book);
            $book_id = $conn->insert_id;
        }

        // Relaciona à coleção
        linkBookToCollection($conn, $collection_id, $book_id);
    }

    fclose($file);
    header("Location: ../ui/collections.php");
    exit();
} else {
    echo "Erro ao carregar o arquivo CSV.";
}
