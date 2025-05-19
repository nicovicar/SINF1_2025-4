<?php
require_once("../dsl/connection.php");


if (!isset($_SESSION)) {
    session_start();
}
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
        <section class="contentor-cinza">
            <div class="wrap-imagen">
                <img src="../fotos/poppyWar_collectionPhoto_esticada.jpg" alt="poppyWar">
            </div>
        </section>

        <div class="collection-name">
            <h1>Coleções</h1>
        </div>

        <?php
        $sql = "SELECT * FROM collections ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<section class="bloco-lateral">';
                echo '  <div class="bloco-imagem">';
                echo '    <a href="collection.php?id=' . $row['id'] . '">';
                echo '      <img src="' . htmlspecialchars($row["image_path"]) . '" alt="' . htmlspecialchars($row["title"]) . '">';
                echo '    </a>';
                echo '  </div>';
                echo '  <div class="bloco-info">';
                echo '    <h3>' . htmlspecialchars($row["title"]) . '</h3>';
                echo '    <p><strong>Descrição: </strong>' . nl2br(htmlspecialchars($row["description"])) . '</p>';
                echo '  </div>';
                echo '</section>';
            }
        } else {
            echo '<p style="text-align:center">Nenhuma coleção encontrada.</p>';
        }


        ?>
    </main>

    <footer>
        <p>The Book Collectors</p>
    </footer>
</body>

</html>