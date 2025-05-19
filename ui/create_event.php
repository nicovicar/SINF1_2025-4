<?php
if (!isset($_SESSION)) session_start();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Criar Evento - The Book Collectors</title>
  <link rel="stylesheet" href="../css/styles.css" />
</head>

<body>
<div class="nome-pagina">
  <h1>Criar Evento</h1>
</div>

<?php include "header.php"; ?>

<main>
  <form action="../bll/handle_create_event.php" method="POST" enctype="multipart/form-data" class="form-container">
    <div class="form-group">
      <label for="collectionImage">Imagem do Evento:</label>
      <input type="file" id="collectionImage" name="collectionImage" accept="image/*" required>
    </div>

    <div class="form-group">
      <label for="titles">Título do Evento:</label>
      <input id="titles" name="titles" required />
    </div>

    <div class="form-group">
      <label for="event_date">Data:</label>
      <input type="date" id="event_date" name="event_date" required>
    </div>

    <div class="form-group">
      <label for="event_time">Hora:</label>
      <input type="time" id="event_time" name="event_time" required>
    </div>

    <div class="form-group">
      <label for="location">Local:</label>
      <input type="text" id="location" name="location" required>
    </div>

    <div class="form-group">
      <label for="description">Descrição:</label>
      <textarea id="description" name="description" rows="4" required></textarea>
    </div>

    <button type="submit" class="btn-colecao">Criar Evento</button>
  </form>
</main>

<footer>
  <p>The Book Collectors</p>
</footer>
</body>
</html>
