<?php

function findBookByTitleAuthor($conn, $title, $author) {
    $sql = "SELECT id FROM books WHERE title = ? AND author = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $author);
    $stmt->execute();
    $id = null;
    $stmt->bind_result($id);
    if ($stmt->fetch()) {
        return $id;
    }
    return null;
}

function linkBookToCollection($conn, $collection_id, $book_id) {
    $sql = "INSERT IGNORE INTO collection_book (collection_id, book_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $collection_id, $book_id);
    $stmt->execute();
}



function insertBooks($conn, $d) {
    $sql = "INSERT INTO books (title, author, year, editor, language, binding, pages, weight, price, date_of_acquisition, description, importance, image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssidssis",
        $d['title'], $d['author'], $d['year'],
        $d['editor'], $d['language'], $d['binding'],
        $d['pages'], $d['weight'], $d['price'],
        $d['date_of_acquisition'], $d['description'],
        $d['importance'], $d['image']
    );
    return $stmt->execute();
}
?>

