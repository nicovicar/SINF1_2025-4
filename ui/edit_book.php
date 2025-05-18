<?php
require_once("../dsl/connection.php");

if (!isset($_GET['id'])) {
    die("ID do livro não especificado.");
}

$id = intval($_GET['id']);

// Buscar os dados do livro
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();
$stmt->close();

if (!$book) {
    die("Livro não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Editar Livro</title>
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
  <div class="nome-pagina">
    <h1>The Book Collectors</h1>
  </div>

  <?php include "header.php"; ?>

  <main>
    <section>
      <h2>Editar Livro</h2>
      <form action="../bll/handle_update_book.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $book['id']; ?>">

        <div class="form-group">
          <label for="image">Capa do Livro:</label>
          <input type="file" id="image" name="image" accept="image/*">
          <p>Atual: <em><?php echo htmlspecialchars(basename($book['image'])); ?></em></p>
        </div>

        <div class="form-group">
          <label for="title">Título:</label>
          <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
        </div>

        <div class="form-group">
          <label for="author">Autor:</label>
          <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
        </div>

        <div class="form-group">
          <label for="year">Ano de Edição:</label>
          <input type="number" id="year" name="year" value="<?php echo $book['year']; ?>" required>
        </div>

        <div class="form-group">
          <label for="editor">Editor:</label>
          <input type="text" id="editor" name="editor" value="<?php echo htmlspecialchars($book['editor']); ?>" required>
        </div>

        <div class="form-group">
          <label for="language">Idioma:</label>
          <input type="text" id="language" name="language" value="<?php echo htmlspecialchars($book['language']); ?>" required>
        </div>

        <div class="form-group">
          <label for="weight">Peso:</label>
          <input type="text" id="weight" name="weight" value="<?php echo htmlspecialchars($book['weight']); ?>" required>
        </div>

        <div class="form-group">
          <label for="binding">Encadernação:</label>
          <input type="text" id="binding" name="binding" value="<?php echo htmlspecialchars($book['binding']); ?>" required>
        </div>

        <div class="form-group">
          <label for="pages">Páginas:</label>
          <input type="number" id="pages" name="pages" value="<?php echo $book['pages']; ?>" required>
        </div>

        <div class="form-group">
          <label for="price">Preço (€):</label>
          <input type="number" id="price" name="price" step="0.01" value="<?php echo $book['price']; ?>" required>
        </div>

        <div class="form-group">
          <label for="date_of_acquisition">Data de Aquisição:</label>
          <input type="date" id="date_of_acquisition" name="date_of_acquisition" value="<?php echo $book['date_of_acquisition']; ?>" required>
        </div>

        <div class="form-group">
          <label for="importance">Importância (1-10):</label>
          <input type="number" id="importance" name="importance" min="1" max="10" value="<?php echo $book['importance']; ?>" required>
        </div>

        <div class="form-group">
          <label for="description">Descrição:</label>
          <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($book['description']); ?></textarea>
        </div>

        <button type="submit" class="btn-colecao">Salvar Alterações</button>
      </form>
    </section>
  </main>

  <footer>
    <p>The Book Collectors</p>
  </footer>
</body>
</html>
