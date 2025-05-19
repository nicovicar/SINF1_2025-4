<?php
require_once("../dsl/connection.php");
if (!isset($_SESSION)) {
    session_start();
}

$collection_sql = "SELECT * FROM collections ORDER BY RAND() LIMIT 1";
$collection_result = $conn->query($collection_sql);
$collection = $collection_result->fetch_assoc();

$book = null;
if ($collection) {
    $book_sql = "
        SELECT b.* FROM books b
        INNER JOIN collection_book cb ON b.id = cb.book_id
        WHERE cb.collection_id = ?
        ORDER BY RAND() LIMIT 1
    ";
    $stmt = $conn->prepare($book_sql);
    $stmt->bind_param("i", $collection['id']);
    $stmt->execute();
    $book_result = $stmt->get_result();
    $book = $book_result->fetch_assoc();
    $stmt->close();
}

$event_sql = "SELECT * FROM events ORDER BY RAND() LIMIT 1";
$event_result = $conn->query($event_sql);
$event = $event_result->fetch_assoc();
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
        <h1> The Book Collectors</h1>
    </div>

    <?php include "header.php"; ?>

    <main>

        <h2 style="text-align: center; margin-top: 2rem; font-size: 2.2rem;">Coleção em alta</h2>

        <section class="contentor-cinza" style="padding: 2rem;">
            <div class="wrap-imagen" style="max-width: 90%; margin: auto;">
                <?php if ($collection): ?>
                    <img src="<?php echo htmlspecialchars($collection['image_path']); ?>" alt="<?php echo htmlspecialchars($collection['title']); ?>">
                <?php else: ?>
                    <p>Não há coleções cadastradas.</p>
                <?php endif; ?>
            </div>
        </section>

        <h2 style="text-align: center; margin-top: 2rem;">Exemplar da Coleção</h2>

        <?php if ($book): ?>
        <section class="bloco-lateral" style="transform: scale(0.95);">
            <div class="bloco-imagem">
                <img src="<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" />
            </div>
            <div class="bloco-info">
                <h3><a href="book.php?id=<?php echo $book['id']; ?>"><?php echo htmlspecialchars($book['title']); ?></a></h3>
                <p><strong>Autor:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                <p><strong>Ano de edição:</strong> <?php echo htmlspecialchars($book['year']); ?></p>
                <p><strong>Editor:</strong> <?php echo htmlspecialchars($book['editor']); ?></p>
                <p><strong>Idioma:</strong> <?php echo htmlspecialchars($book['language']); ?></p>
                <p><strong>Peso:</strong> <?php echo htmlspecialchars($book['weight']); ?></p>
                <p><strong>Encadernação:</strong> <?php echo htmlspecialchars($book['binding']); ?></p>
                <p><strong>Páginas:</strong> <?php echo htmlspecialchars($book['pages']); ?></p>
                <p><strong>Descrição: </strong>
                    <?php echo nl2br(htmlspecialchars(mb_strimwidth($book['description'], 0, 400, "..."))); ?>
                </p>
            </div>
        </section>
        <?php endif; ?>

        <h2 style="text-align: center; margin-top: 2rem;">Evento em alta</h2>

        <?php if ($event): ?>
        <section class="bloco-lateral" style="transform: scale(0.95); margin-bottom: 3rem;">
            <div class="bloco-imagem">
                <img src="<?php echo htmlspecialchars($event['image_path']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>" />
            </div>
            <div class="bloco-info">
                <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                <p><strong>Data:</strong> <?php echo date("d/m/Y", strtotime($event['date'])); ?></p>
                <p><strong>Horário:</strong> <?php echo htmlspecialchars($event['time']); ?></p>
                <p><strong>Local:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                <p><strong>Descrição: </strong>
                    <?php echo nl2br(htmlspecialchars(mb_strimwidth($event['description'], 0, 500, "..."))); ?>
                </p>
            </div>
        </section>
        <?php endif; ?>
    </main>

    <footer>
        <p>The Book Collectors</p>
    </footer>
</body>
</html>

<?php $conn->close(); ?>




