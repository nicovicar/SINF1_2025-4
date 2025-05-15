<?php
function registerUser($conn,$d){
    $sql = "INSERT INTO users (username, password) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss",
    $d['username'],$d['password']);
    return $stmt->execute();
}