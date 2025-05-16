<?php
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

