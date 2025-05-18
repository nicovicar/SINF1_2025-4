<?php
require_once("../bll/load_collection.php");
// Initialize the session
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_GET['id'])) {
    die("Coleção não especificada.");
}

$id = intval($_GET['id']);
$dados = carregar_colecao_com_livros($id);

if (!$dados) {
    die("Coleção não encontrada.");
}

$colecao = $dados['collection'];
$livros_result = $dados['books'];
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Book Collectors</title>
    <link rel="stylesheet" href="../css/styles.css" />
</head>

<body>
    <div class="nome-pagina">
        <h1>The Book Collectors</h1>
    </div>

    <?php include "header.php"; ?>

<main>

    <?php
    // Botão "Editar Coleção" visível apenas para o dono da coleção logado
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ) {
        require_once("../dsl/connection.php"); // conexão para buscar ID
        $username = $_SESSION["username"];

        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->fetch();

        if ($user_id === $colecao['user_id']) {
            echo '<div style="text-align:right; margin: 1rem 2rem 0 0;">';
            echo '  <a href="edit_collection.php?id=' . $colecao['id'] . '" class="btn-colecao">Editar Coleção</a>';
            echo '</div>';
        }
    }
    ?>

    <section class="bloco-lateral">
        <div class="bloco-imagem">
            <img src="<?php echo htmlspecialchars($colecao['image_path']); ?>" alt="Imagem da coleção" style="max-width: 300px;">
        </div>
        <div class="bloco-info">
            <h3><?php echo htmlspecialchars($colecao['title']); ?></h3>
            <p><strong>Descrição:</strong> <?php echo nl2br(htmlspecialchars($colecao['description'])); ?></p>
        </div>
    </section>

    <h2 style="margin-left: 2rem">Livros nesta coleção:</h2>

    <?php
    if ($livros_result->num_rows > 0) {
        while ($livro = $livros_result->fetch_assoc()) {
            echo '<section class="bloco-lateral">';
            echo '  <div class="bloco-imagem">';
            if (!empty($livro['image'])) {
                echo '    <a href="book.php?id=' . $livro['id'] . '">';
                echo '      <img src="' . htmlspecialchars($livro['image']) . '" alt="Imagem do livro" style="max-width: 200px;">';
                echo '    </a>';
            }
            echo '  </div>';
            echo '  <div class="bloco-info">';
            echo '    <h3>' . htmlspecialchars($livro['title']) . '</h3>';
            echo '    <p><strong>Autor:</strong> ' . htmlspecialchars($livro['author']) . '</p>';
            echo '    <p><strong>Ano:</strong> ' . htmlspecialchars($livro['year']) . '</p>';
            echo '    <p><strong>Editor:</strong> ' . htmlspecialchars($livro['editor']) . '</p>';
            echo '    <p><strong>Idioma:</strong> ' . htmlspecialchars($livro['language']) . '</p>';
            echo '    <p><strong>Encadernação:</strong> ' . htmlspecialchars($livro['binding']) . '</p>';
            echo '    <p><strong>Páginas:</strong> ' . htmlspecialchars($livro['pages']) . '</p>';
            echo '    <p><strong>Descrição:</strong> ' . nl2br(htmlspecialchars($livro['description'])) . '</p>';
            echo '  </div>';
            echo '</section>';
        }
    } else {
        echo "<p style='margin-left: 2rem'>Nenhum livro encontrado para esta coleção.</p>";
    }
    ?>
</main>

<footer>
    <p>The Book Collectors</p>
</footer>
</body>
</html>

