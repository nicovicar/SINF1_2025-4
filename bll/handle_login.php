<?php
require_once("../dsl/connection.php");

if (!isset($_SESSION)) {
    session_start();
}

function checkUser($conn, $username, $password) {
    $sql = "SELECT username, password FROM users WHERE username = ?";
    $fetched_username = $hashed_password = '';
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($fetched_username, $hashed_password);
            $stmt->fetch();

            if (strcmp($password, $hashed_password) == 0) {
                return true;
            }
        }

        $stmt->close();
    }

    return false;
}

?>