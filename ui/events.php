<?php
require_once("../dsl/connection.php");
if (!isset($_SESSION)) session_start();

$query = "SELECT * FROM events ORDER BY date DESC, time DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Erro ao buscar eventos: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Eventos - The Book Collectors</title>
    <link rel="stylesheet" href="../css/styles.css" />
</head>

<body>
<div class="nome-pagina">
    <h1>Eventos</h1>
</div>

<?php include "header.php"; ?>

<main>
    <div style="text-align: right; margin: 1rem 2rem;">
        <a href="create_event.php" class="btn-colecao">Criar Novo Evento</a>
    </div>

    <h2 style="margin-left: 2rem">Lista de Eventos:</h2>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($evento = mysqli_fetch_assoc($result)) {
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
            echo '    <p><strong>Descrição:</strong> ' . nl2br(htmlspecialchars($evento['description'])) . '</p>';
            echo '    <a href="event.php?id=' . $evento['id'] . '" class="btn-colecao">Ver Detalhes</a>';
            echo '  </div>';
            echo '</section>';
        }
    } else {
        echo "<p style='margin-left: 2rem'>Nenhum evento encontrado.</p>";
    }
    ?>
</main>

<footer>
    <p>The Book Collectors</p>
</footer>
</body>
</html>
