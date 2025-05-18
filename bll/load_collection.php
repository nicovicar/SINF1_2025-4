<?php
require_once("../dsl/connection.php");
require_once("../dsl/collection_dao.php");

function carregar_colecao_com_livros($collection_id) {
    global $conn;

    $collection = getCollectionById($conn, $collection_id);
    if (!$collection) return null;

    $books = getBooksFromCollection($conn, $collection_id);
    return ['collection' => $collection, 'books' => $books];
}
