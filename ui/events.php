<?php
require_once("../dsl/connection.php");
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    die("Acesso negado.");
}

$username = $_SESSION["username"];
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT * FROM events WHERE user_id = ? ORDER BY date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Meus Eventos</title>
    <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>
<div class="nome-pagina">
    <h1>Meus Eventos</h1>
</div>

<?php include "header.php"; ?>

<main>
    <div style="text-align: right; margin: 1rem 2rem;">
        <a href="create_event.php" class="btn-colecao">Criar Novo Evento</a>
    </div>

    <h2 style="margin-left: 2rem">Seus Eventos:</h2>

    <?php
    if ($result->num_rows > 0) {
        while ($evento = $result->fetch_assoc()) {
            echo '<section class="bloco-lateral">';
            echo '  <div class="bloco-imagem">';
            if (!empty($evento['image_path'])) {
                echo '    <a href="event.php?id=' . $evento['id'] . '">';
                echo '      <img src="' . htmlspecialchars($evento['image_path']) . '" alt="Imagem do evento" style="max-width: 200px;">';
                echo '    </a>';
            }
            echo '  </div>';
            echo '  <div class="bloco-info">';
            echo '    <h3>' . htmlspecialchars($evento['title']) . '</h3>';
            echo '    <p><strong>Data:</strong> ' . htmlspecialchars($evento['date']) . '</p>';
            echo '    <p><strong>Hora:</strong> ' . htmlspecialchars($evento['time']) . '</p>';
            echo '    <p><strong>Local:</strong> ' . htmlspecialchars($evento['location']) . '</p>';
            echo '    <p>' . nl2br(htmlspecialchars($evento['description'])) . '</p>';
            echo '    <a href="edit_event.php?id=' . $evento['id'] . '" class="btn-colecao" style="margin-right: 10px;">Editar</a>';
            echo '    <a href="../bll/delete_event.php?id=' . $evento['id'] . '" class="btn-colecao" onclick="return confirm(\'Deseja realmente deletar este evento?\');">Deletar</a>';
            echo '  </div>';
            echo '</section>';
        }
    } else {
        echo "<p style='margin-left: 2rem'>Você ainda não criou nenhum evento.</p>";
    }
    ?>
</main>

<footer>
    <p>The Book Collectors</p>
</footer>
</body>
</html>
