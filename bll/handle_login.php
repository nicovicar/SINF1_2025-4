<?php
require_once("../dsl/connection.php");
require_once("../dsl/handle_register.php");
session_start();

function checkUser($conn, $username, $password) {
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->existUser($username);
    if ($stmt != null) {
        // Bind result variables
        $stmt->bind_result($username,$stored);

        if (fetch($stmt)) {
            if (password_verify($password, $stored)) {
                return True;
            }else{
                return False;
            }
        } else {
            return False;
        }
    } else {
        return False;
    }
}
?>