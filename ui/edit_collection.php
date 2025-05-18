<?php
require_once("../bll/load_collection.php");
session_start();

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
    <title>Editar Coleção</title>
    <link rel="stylesheet" href="../css/styles.css" />
</head>

<body>
    <div class="nome-pagina">
        <h1>Editar Coleção - The Book Collectors</h1>
    </div>

    <header>
        <div class="contentor">
            <nav>
                <ul>
                    <li><a href="index.php">Ínicio</a></li>
                    <li><a href="collections.php">Coleções</a></li>
                    <li><a href="eventos.php">Eventos</a></li>
                    <li><a href="criar_colecao.php">Criar coleção</a></li>
                    <li><a href="criar_eventos.php">Criar evento</a></li>
                </ul>
            </nav>

            <form class="search-bar" action="resultados.php" method="GET">
                <input type="text" name="q" placeholder="Pesquisar..." aria-label="Pesquisar">
                <button type="submit">Buscar</button>
                <div class="login-header"><a href="login.php">Login</a></div>
            </form>
        </div>
    </header>

<main>

    <section class="bloco-lateral">
        <div class="bloco-imagem">
            <img src="<?php echo htmlspecialchars($colecao['image_path']); ?>" alt="Imagem da coleção" style="max-width: 300px;">
        </div>
        <div class="bloco-info">
            <h3><?php echo htmlspecialchars($colecao['title']); ?></h3>
            <p><strong>Descrição:</strong> <?php echo nl2br(htmlspecialchars($colecao['description'])); ?></p>
        </div>
    </section>

    <!-- Botão Criar Livro (após bloco da coleção) -->
    <div style="text-align: right; margin: 1rem 2rem;">
        <a href="create_book.php" class="btn-colecao">Criar Livro</a>
    </div>

    <h2 style="margin-left: 2rem">Livros nesta coleção:</h2>

    <?php
    if ($livros_result->num_rows > 0) {
        while ($livro = $livros_result->fetch_assoc()) {
            echo '<section class="bloco-lateral">';
            echo '  <div class="bloco-imagem">';
            if (!empty($livro['image'])) {
                echo '    <img src="' . htmlspecialchars($livro['image']) . '" alt="Imagem do livro" style="max-width: 200px;">';
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
            echo '    <div style="margin-top: 10px;">';
            echo '      <a href="edit_book.php?id=' . $livro['id'] . '" class="btn-colecao" style="margin-right: 10px;">Editar Livro</a>';
            echo '      <a href="handle_delete_book.php?id=' . $livro['id'] . '" class="btn-colecao" onclick="return confirm(\'Tem certeza que deseja deletar este livro?\');">Deletar Livro</a>';
            echo '    </div>';
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


