<?php
require_once("../dsl/connection.php");
require_once("../dsl/handle_register.php");
session_start();

function checkUser($conn, $username, $password) {
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        // Verifica se usuário existe
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $fetched_username, $hashed_password); //trabalhar na cena do fetched
            $stmt->fetch();

            // Verifica senha
            if (password_verify($password, $hashed_password)) {
                return true;
            }
        }
        $stmt->close();
    }

    return false;
}

?>