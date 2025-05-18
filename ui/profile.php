<?php

require_once("../bll/handle_profile.php");

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: perform_login.php");
}else {
    $array1 = getUser($conn, $_SESSION["username"]);
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
        <h1>The Book Collectors</h1>
    </div>

    <?php include "header.php"; ?>

    <main>
        <section class="profile-container">
            <div class="profile-info">
                <h3><a> <?php echo ($_SESSION["username"]); ?> </a></h3>
                <p><strong>Email: </strong> <?php echo ($array1["email"]); ?></p>
                <p><strong>Data de nascimento: </strong><?php echo ($array1["dataNascimento"]); ?></p>
            </div>
        </section>

        <section class="bloco-lateral">
            <div class="minhas-colecoes-info">
                <h3>As minhas Colecoes</h3>

                <?php
                $user_id = $array1["id"];
                $sql = "SELECT * FROM collections WHERE user_id = $user_id ORDER BY id DESC";
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

            </div>
        </section>
        <section class="bloco-lateral">
            <div class="meus-eventos-info">
                <h3>Os meus eventos</h3>

                <?php
                $user_id = $array1["id"];
                $sql = "SELECT * FROM events WHERE user_id = $user_id ORDER BY id DESC";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<section class="bloco-lateral">';
                        echo '  <div class="bloco-imagem">';
                        echo '    <a href="events.php?id=' . $row['id'] . '">';
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
                    echo '<p style="text-align:center">Nenhum evento encontrado.</p>';
                }
                ?>

            </div>
        </section>
        <section class="bloco-lateral">
            <a href="edit_profile.php"><button class="btn-editar-perfil">Editar perfil</button></a>   
        </section>
    </main>

    <footer>
        <p>The Book Collectors</p>
    </footer>
</body>

</html>
