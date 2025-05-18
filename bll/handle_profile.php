<?php
require_once("../dsl/connection.php");

session_start();

function getUser($conn, $username){
    $sql = "SELECT id, username, dataNascimento, email FROM users WHERE username = ?";
    $id = $dataNascimento = $email = " ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $stmt->bind_result($id, $username, $dataNascimento, $email);
    $stmt->fetch();
    $array1 = array(
        "id" => $id,
        "username" => $username,
        "dataNascimento" => $dataNascimento,
        "email" => $email,
    );
    
    return $array1;
}