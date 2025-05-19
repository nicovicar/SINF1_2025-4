<?php
    echo '<header>';
    echo '<div class="contentor">';
    echo '<nav>';
    echo '<ul>';
    echo '<li><a href="index.php">Ínicio</a></li>';
    echo '<li><a href="collections.php">Coleções</a></li>';
    echo '<li><a href="events.php">Eventos</a></li>';
    echo '<li><a href="create_collections.php">Criar coleção</a></li>';
    echo '<li><a href="create_event.php">Criar evento</a></li>';
    echo '</ul>';
    echo '</nav>';
    echo '<form class="search-bar" action="search_results.php" method="GET">';
    echo '<input type="text" name="q" placeholder="Pesquisar..." aria-label="Pesquisar" required>';
    echo '<button type="submit">Buscar</button>';
    if (!isset($_SESSION) || !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        echo '<div class="login-header"><a href="perform_login.php">Login</a></div>';
    }
    else {
        echo '<div class="login-header"><a href="profile.php">Profile</a></div>';
        echo '<div class="login-header"><a href="../bll/logout.php">Logout</a></div>';
    }
    echo '</form>';
    echo '</div>';
    echo '</header>';
?>
