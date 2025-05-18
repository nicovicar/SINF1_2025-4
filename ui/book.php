<?php
require_once("../dsl/connection.php");

// 1) ID do livro vindo por GET, ex: book.php?id=3
$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 2) Busca segura (prepared statement)
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book   = $result->fetch_assoc();
$stmt->close();
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

    <header>
        <div class="contentor">
            <nav>
                <ul>
                    <li><a href="index.php">Ínicio</a></li>
                    <li><a href="collections.php">Coleções</a></li>
                    <li><a href="events.php">Eventos</a></li>
                    <li><a href="create_collections.php">Criar coleção</a></li>
                    <li><a href="create_events.php">Criar evento</a></li>
                </ul>
            </nav>

            <form class="search-bar" action="resultados.php" method="GET">
                <input type="text" name="q" placeholder="Pesquisar..." aria-label="Pesquisar">
                <button type="submit">Buscar</button>
                <div class="login-header"><a href="perform_login.php">Login</a></div>
            </form>
        </div>
    </header>

    <main>
        <?php if ($book): ?>
        <section class="book-container">
            <img src="<?php echo htmlspecialchars($book['image']); ?>" alt="Capa do Livro" />
            <div class="book-info">
                <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                <p><strong>Autor:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                <p><strong>Ano de edição:</strong> <?php echo htmlspecialchars($book['year']); ?></p>
                <p><strong>Editor:</strong> <?php echo htmlspecialchars($book['editor']); ?></p>
                <p><strong>Idioma:</strong> <?php echo htmlspecialchars($book['language']); ?></p>
                <p><strong>Peso:</strong> <?php echo htmlspecialchars($book['weight']); ?></p>
                <p><strong>Encadernação:</strong> <?php echo htmlspecialchars($book['binding']); ?></p>
                <p><strong>Páginas:</strong> <?php echo htmlspecialchars($book['pages']); ?></p>
                <p><strong>Preço:</strong> €<?php echo number_format($book['price'], 2, ',', '.'); ?></p>
                <p><strong>Data de aquisição:</strong> <?php echo htmlspecialchars($book['date_of_acquisition']); ?></p>
                <p><strong>Importância:</strong> <?php echo htmlspecialchars($book['importance']); ?></p>
                <p><strong>Descrição: </strong><?php echo nl2br(htmlspecialchars($book['description'])); ?></p>
                <a href="collections.php" class="btn-colecao">Voltar às Coleções</a>
            </div>
        </section>
        <?php else: ?>
            <p style="text-align:center;">Livro não encontrado.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>The Book Collectors</p>
    </footer>
</body>
</html>
<?php $conn->close(); ?>
