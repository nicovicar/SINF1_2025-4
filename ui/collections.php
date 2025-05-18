<?php
require_once("../dsl/connection.php");
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

        $conn->close();
        ?>
    </main>

    <footer>
        <p>The Book Collectors</p>
    </footer>
</body>

</html>