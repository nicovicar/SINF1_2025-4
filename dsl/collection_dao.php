<?php
function insertCollection($conn, $user_id, $d) {
    $sql = "INSERT INTO collections (user_id, title, author, year_edition, editor, language, dimensions, binding, pages, description, image_path)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssssss",
        $user_id,
        $d['titles'], $d['author'], $d['yearEdition'],
        $d['editor'], $d['language'], $d['dimensions'],
        $d['binding'], $d['pages'], $d['description'], $d['image_path']
    );
    return $stmt->execute();
}
