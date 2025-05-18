<?php
function insertCollection($conn, $user_id, $d) {
    $sql = "INSERT INTO collections (user_id, title, description, image_path)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss",
        $user_id,
        $d['title'],$d['description'], $d['image_path']
    );
    return $stmt->execute();
}

function importCollection($conn, $user_id, $dados) {
    $sql = "INSERT INTO collections (user_id, title, description, image_path)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $user_id, $dados['title'], $dados['description'], $dados['image_path']);
    $stmt->execute();
    return $stmt->insert_id;
}

function getCollectionById($conn, $id) {
    $sql = "SELECT * FROM collections WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getBooksFromCollection($conn, $collection_id) {
    $sql = "SELECT b.* FROM books b
            INNER JOIN collection_book cb ON b.id = cb.book_id
            WHERE cb.collection_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $collection_id);
    $stmt->execute();
    return $stmt->get_result();
}
