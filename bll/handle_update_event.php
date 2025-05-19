<?php
require_once("../dsl/connection.php");
require_once("../dsl/event_dao.php");
require_once("../bll/load_event.php");

if (!isset($_SESSION)) session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $title = trim($_POST['title']);
    $date = $_POST['event_date'];
    $time = $_POST['event_time'];
    $location = trim($_POST['location']);
    $description = trim($_POST['description']);

    $evento = carregar_evento($id);
    if (!$evento) {
        die("Evento não encontrado.");
    }

    $username = $_SESSION["username"];
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    if ($user_id !== $evento['user_id']) {
        die("Você não tem permissão para editar este evento.");
    }

    $image_path = $evento['image_path'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $filename = time() . "_" . basename($_FILES['image']['name']);
        $dest = "../fotos/" . $filename;
        move_uploaded_file($_FILES['image']['tmp_name'], $dest);
        $image_path = $dest;
    }

    $sucesso = atualizar_evento($conn, $id, $title, $date, $time, $location, $description, $image_path);

    if ($sucesso) {
        header("Location: ../ui/event.php?id=" . $id);
        exit();
    } else {
        echo "Erro ao atualizar evento.";
    }
}
