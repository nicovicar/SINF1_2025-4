<?php
require_once("../dsl/connection.php");

function getUser($conn, $username){
    $sql = "SELECT id, username, dateBirth, email WHERE username = ?";
    $id = $dateBirth = $email = " ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$username);
    $stmt->excute();
    $stmt->bind_result($id, $username, $dateBirth, $email);
    $stmt->fetch();
    $array1 = array(
        "id" => $id,
        "username" => $username,
        "dateBirth" => $dateBirth,
        "email" => $email,
    );
    
    return $array1;
}