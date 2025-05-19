<?php
require_once("../dsl/connection.php");
if (!isset($_SESSION)) session_start();

if (!isset($_GET['id'])) {
    die("Evento não especificado.");
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$evento = $result->fetch_assoc();

if (!$evento) {
    die("Evento não encontrado.");
}

$username = $_SESSION["username"];
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

if ($user_id !== $evento['user_id']) {
    die("Você não tem permissão para editar este evento.");
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Editar Evento</title>
  <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>
<div class="nome-pagina">
  <h1>Editar Evento</h1>
</div>

<?php include "header.php"; ?>

<main>
  <form action="../bll/update_event.php" method="POST" enctype="multipart/form-data" class="form-container">
    <input type="hidden" name="id" value="<?php echo $evento['id']; ?>">

    <div class="form-group">
      <label for="title">Título:</label>
      <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($evento['title']); ?>" required>
    </div>

    <div class="form-group">
      <label for="event_date">Data:</label>
      <input type="date" id="event_date" name="event_date" value="<?php echo $evento['date']; ?>" required>
    </div>

    <div class="form-group">
      <label for="event_time">Hora:</label>
      <input type="time" id="event_time" name="event_time" value="<?php echo $evento['time']; ?>" required>
    </div>

    <div class="form-group">
      <label for="location">Local:</label>
      <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($evento['location']); ?>" required>
    </div>

    <div class="form-group">
      <label for="description">Descrição:</label>
      <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($evento['description']); ?></textarea>
    </div>

    <div class="form-group">
      <label>Imagem Atual:</label><br>
      <img src="<?php echo htmlspecialchars($evento['image_path']); ?>" alt="Imagem atual" style="max-width: 200px;">
    </div>

    <div class="form-group">
      <label for="image">Nova Imagem (opcional):</label>
      <input type="file" id="image" name="image" accept="image/*">
    </div>

    <div style="text-align: right;">
      <button type="submit" class="btn-colecao">Salvar</button>
      <a href="event.php?id=<?php echo $evento['id']; ?>" class="btn-colecao">Cancelar</a>
    </div>
  </form>
</main>

<footer>
  <p>The Book Collectors</p>
</footer>
</body>
</html>
