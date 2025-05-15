<?php
require_once("../dsl/connection.php");
require_once("../dsl/register_dao.php");

session_start();

function existUser($conn, $username) {
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    return $stmt->num_rows === 1;
}

