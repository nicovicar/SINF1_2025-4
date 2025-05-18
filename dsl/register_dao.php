<?php
function registerUser($conn,$username,$password,$dataNascimento,$email){
    $sql = "INSERT INTO users (username, password,dataNascimento,email) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssds",
    $username,$password,$dataNascimento,$email);
    return $stmt->execute();
}