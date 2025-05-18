<?php
require_once("../dsl/connection.php");
if (!isset($_SESSION)) {
    session_start();
}

$q = isset($_GET['q']) ? trim($_GET['q']) : "";

$books = $collections = $events = [];

if ($q !== "") {
    $term = "%{$q}%";

    // Buscar livros
    $stmt = $conn->prepare("SELECT id, title FROM books WHERE title LIKE ?");
    $stmt->bind_param("s", $term);
    $stmt->execute();
    $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Buscar coleções
    $stmt = $conn->prepare("SELECT id, title FROM collections WHERE title LIKE ?");
    $stmt->bind_param("s", $term);
    $stmt->execute();
    $collections = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Buscar eventos
    $stmt = $conn->prepare("SELECT id, title FROM events WHERE title LIKE ?");
    $stmt->bind_param("s", $term);
    $stmt->execute();
    $events = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Resultados da Pesquisa</title>
    <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>

<div class="nome-pagina">
    <h1>Resultados da Pesquisa</h1>
</div>

<?php include "header.php"; ?>

<main class="search-container">
    <h2>Você pesquisou por: <em><?php echo htmlspecialchars($q); ?></em></h2>

    <?php if (empty($books) && empty($collections) && empty($events)): ?>
        <p>Nenhum resultado encontrado.</p>
    <?php else: ?>

        <?php if (!empty($books)): ?>
            <section>
                <h3>Livros</h3>
                <ul class="result-list">
                    <?php foreach ($books as $book): ?>
                        <li><a href="book.php?id=<?php echo $book['id']; ?>"><?php echo htmlspecialchars($book['title']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <?php if (!empty($collections)): ?>
            <section>
                <h3>Coleções</h3>
                <ul class="result-list">
                    <?php foreach ($collections as $collection): ?>
                        <li><a href="collection.php?id=<?php echo $collection['id']; ?>"><?php echo htmlspecialchars($collection['title']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <?php if (!empty($events)): ?>
            <section>
                <h3>Eventos</h3>
                <ul class="result-list">
                    <?php foreach ($events as $event): ?>
                        <li><a href="event.php?id=<?php echo $event['id']; ?>"><?php echo htmlspecialchars($event['title']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

    <?php endif; ?>
</main>

<footer>
    <p>The Book Collectors</p>
</footer>
</body>
</html>

<?php $conn->close(); ?>
