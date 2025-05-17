<?php
function registerUser($conn,$username,$password){
    $sql = "INSERT INTO users (username, password) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss",
    $username,$password);
    return $stmt->execute();
}