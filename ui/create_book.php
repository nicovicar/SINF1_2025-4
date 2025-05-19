<?php

if (!isset($_SESSION)) {
  session_start();
}

require_once("../dsl/connection.php");


$pre_collection_id = isset($_GET['collection_id']) ? intval($_GET['collection_id']) : 0;

$collections_result = $conn->query("SELECT id, title FROM collections");


?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Adicionar Novo Livro</title>
  <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
  <div class="nome-pagina">
    <h1>The Book Collectors</h1>
  </div>

  <?php include "header.php"; ?>

  <main>
    <section>
      <h2>Adicionar Novo Livro</h2>
      <form action="../bll/handle_create_books.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="image">Capa do Livro:</label>
          <input type="file" id="image" name="image" accept="image/*" required>
        </div>
        <div class="form-group">
          <label for="title">Título:</label>
          <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
          <label for="author">Autor:</label>
          <input type="text" id="author" name="author" required>
        </div>
        <div class="form-group">
          <label for="year">Ano de Edição:</label>
          <input type="number" id="year" name="year" required>
        </div>
        <div class="form-group">
          <label for="editor">Editor:</label>
          <input type="text" id="editor" name="editor" required>
        </div>
        <div class="form-group">
          <label for="language">Idioma:</label>
          <input type="text" id="language" name="language" required>
        </div>
        <div class="form-group">
          <label for="weight">Peso:</label>
          <input type="text" id="weight" name="weight" required>
        </div>
        <div class="form-group">
          <label for="binding">Encadernação:</label>
          <input type="text" id="binding" name="binding" required>
        </div>
        <div class="form-group">
          <label for="pages">Páginas:</label>
          <input type="number" id="pages" name="pages" min="1" required>
        </div>
        <div class="form-group">
          <label for="price">Preço (€):</label>
          <input type="number" id="price" name="price" step="0.01" required>
        </div>
        <div class="form-group">
          <label for="date_of_acquisition">Data de Aquisição:</label>
          <input type="date" id="date_of_acquisition" name="date_of_acquisition" required>
        </div>
        <div class="form-group">
          <label for="importance">Importância (1-10):</label>
          <input type="number" id="importance" name="importance" min="1" max="10" required>
        </div>
        <div class="form-group">
          <label for="description">Descrição:</label>
          <textarea id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="form-group">
          <?php if ($pre_collection_id): ?>
            <input type="hidden" name="collections[]" value="<?= $pre_collection_id ?>">
            <p><em>Livro será ligado automaticamente à coleção criada.</em></p>
          <?php else: ?>
            <label for="collections">Coleções:</label>
            <select id="collections" name="collections[]" multiple required>
              <?php
              if ($collections_result && $collections_result->num_rows > 0) {
                while ($row = $collections_result->fetch_assoc()) {
                  echo '<option value="' . $row['id'] . '">' .
                    htmlspecialchars($row['title']) . '</option>';
                }
              } else {
                echo '<option disabled>Nenhuma coleção disponível</option>';
              }
              ?>
            </select>
          <?php endif; ?>
        </div>
        <button type="submit" class="btn-colecao">Adicionar Livro</button>
      </form>
    </section>
  </main>

  <footer>
    <p>The Book Collectors</p>
  </footer>
</body>

</html>