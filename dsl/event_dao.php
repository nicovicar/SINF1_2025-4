<?php

function insertEvent($conn, $user_id, $dados) {
    $sql = "INSERT INTO events (user_id, title, date, time, location, description, image_path)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "issssss",
        $user_id,
        $dados['titles'],
        $dados['event_date'],
        $dados['event_time'],
        $dados['location'],
        $dados['description'],
        $dados['image_path']
    );

    return mysqli_stmt_execute($stmt);
}

function atualizar_evento($conn, $id, $title, $date, $time, $location, $description, $image_path) {
    $sql = "UPDATE events 
            SET title = ?, date = ?, time = ?, location = ?, description = ?, image_path = ? 
            WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) return false;

    mysqli_stmt_bind_param($stmt, "ssssssi", $title, $date, $time, $location, $description, $image_path, $id);
    return mysqli_stmt_execute($stmt);
}
