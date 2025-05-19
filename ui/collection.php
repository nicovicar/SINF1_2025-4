<?php
require_once("../bll/load_collection.php");
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_GET['id'])) die("Coleção não especificada.");
$id = intval($_GET['id']);
$order = (isset($_GET['order']) && $_GET['order'] === 'desc') ? 'desc' : 'asc';

$dados = carregar_colecao_com_livros($id);
if (!$dados) die("Coleção não encontrada.");
$colecao = $dados['collection'];
$books_rs = $dados['books'];
$books = $books_rs->fetch_all(MYSQLI_ASSOC);

usort($books, function ($a, $b) use ($order) {
    return $order === 'asc' ? $a['importance'] <=> $b['importance']
        : $b['importance'] <=> $a['importance'];
});
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
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]) {
            require_once("../dsl/connection.php");
            $stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
            $stmt->bind_param("s", $_SESSION['username']);
            $stmt->execute();
            $stmt->bind_result($uid);
            $stmt->fetch();
            if ($uid == $colecao['user_id']) {
                echo '<div style="text-align:right;margin:1rem 2rem 0 0;"><a href="edit_collection.php?id=' . $colecao['id'] . '" class="btn-colecao">Editar Coleção</a></div>';
            }
        }
        ?>
        <section class="bloco-lateral">
            <div class="bloco-imagem"><img src="<?= htmlspecialchars($colecao['image_path']); ?>" alt="Imagem da coleção" style="max-width:300px"></div>
            <div class="bloco-info">
                <h3><?= htmlspecialchars($colecao['title']); ?></h3>
                <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($colecao['description'])); ?></p>
            </div>
        </section>

        <h2 style="margin-left:2rem">Livros nesta coleção:</h2>
        <div style="margin-left:2rem;margin-bottom:1rem;">Ordenar por importância:
            <?php $toggle = $order === 'asc' ? 'desc' : 'asc';
            echo '<a class="btn-colecao" href="collection.php?id=' . $id . '&order=' . $toggle . '">' . strtoupper($toggle) . '</a>'; ?>
        </div>
        <?php if ($books): foreach ($books as $livro): ?>
                <section class="bloco-lateral">
                    <div class="bloco-imagem">
                        <?php if (!empty($livro['image'])): ?>
                            <a href="book.php?id=<?= $livro['id']; ?>"><img src="<?= htmlspecialchars($livro['image']); ?>" alt="Imagem do livro" style="max-width:200px"></a>
                        <?php endif; ?>
                    </div>
                    <div class="bloco-info">
                        <h3><?= htmlspecialchars($livro['title']); ?></h3>
                        <p><strong>Autor:</strong> <?= htmlspecialchars($livro['author']); ?></p>
                        <p><strong>Ano:</strong> <?= $livro['year']; ?></p>
                        <p><strong>Importância:</strong> <?= $livro['importance']; ?></p>
                        <p><strong>Editor:</strong> <?= htmlspecialchars($livro['editor']); ?></p>
                        <p><strong>Idioma:</strong> <?= htmlspecialchars($livro['language']); ?></p>
                        <p><strong>Encadernação:</strong> <?= htmlspecialchars($livro['binding']); ?></p>
                        <p><strong>Páginas:</strong> <?= $livro['pages']; ?></p>
                        <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($livro['description'])); ?></p>
                    </div>
                </section>
            <?php endforeach;
        else: ?>
            <p style="margin-left:2rem">Nenhum livro encontrado para esta coleção.</p>
        <?php endif; ?>
    </main>
    <footer>
        <p>The Book Collectors</p>
    </footer>
</body>

</html>