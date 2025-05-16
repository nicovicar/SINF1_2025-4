<?php
function insertBooks($conn, $user_id, $d) {
    $sql = "INSERT INTO books (id, title, author, year, editor, language, binding, pages, weight, price, date_of_acquisition, description, importance)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssssss",
        $user_id,
        $d['id'], $d['title'], $d['author'],
        $d['year'], $d['editor'], $d['language'],
        $d['binding'], $d['pages'], $d['weight'], $d['price']
        $d['date_of_acquisition'], $d['description'], $d['importance'],
    );
    return $stmt->execute();
}
