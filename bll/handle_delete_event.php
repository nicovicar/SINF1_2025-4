<?php
require_once("../dsl/connection.php");

if (!isset($_SESSION)) session_start();

if (!isset($_GET['id'])) {
    die("Evento não especificado.");
}

$id = intval($_GET['id']);

// Busca evento
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$evento = $result->fetch_assoc();

if (!$evento) {
    die("Evento não encontrado.");
}

// Verifica permissão
$username = $_SESSION["username"];
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

if ($user_id !== $evento['user_id']) {
    die("Você não tem permissão para deletar este evento.");
}

// Deleta evento
$stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: ../ui/events.php");
exit();
