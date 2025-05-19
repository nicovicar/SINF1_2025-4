<?php
require_once("../bll/load_event.php");
require_once("../dsl/connection.php");

if (!isset($_SESSION)) session_start();

if (!isset($_GET['id'])) {
    die("Evento não especificado.");
}

$id = intval($_GET['id']);
$evento = carregar_evento($id);

if (!$evento) {
    die("Evento não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($evento['title']); ?> - The Book Collectors</title>
    <link rel="stylesheet" href="../css/styles.css" />
</head>

<body>
<div class="nome-pagina">
    <h1>Detalhes do Evento</h1>
</div>

<?php include "header.php"; ?>

<main>

<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $username = $_SESSION["username"];

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    if ($user_id === $evento['user_id']) {
        echo '<div style="text-align:right; margin: 1rem 2rem 0 0;">';
        echo '  <a href="edit_event.php?id=' . $evento['id'] . '" class="btn-colecao">Editar Evento</a>';
        echo '</div>';
    }
}
?>

<section class="bloco-lateral">
    <div class="bloco-imagem">
        <img src="<?php echo htmlspecialchars($evento['image_path']); ?>" alt="Imagem do evento" style="max-width: 300px;">
    </div>
    <div class="bloco-info">
        <h3><?php echo htmlspecialchars($evento['title']); ?></h3>
        <p><strong>Data:</strong> <?php echo htmlspecialchars($evento['date']); ?></p>
        <p><strong>Hora:</strong> <?php echo htmlspecialchars($evento['time']); ?></p>
        <p><strong>Local:</strong> <?php echo htmlspecialchars($evento['location']); ?></p>
        <p><strong>Descrição:</strong> <?php echo nl2br(htmlspecialchars($evento['description'])); ?></p>
    </div>
</section>

</main>

<footer>
    <p>The Book Collectors</p>
</footer>
</body>
</html>
