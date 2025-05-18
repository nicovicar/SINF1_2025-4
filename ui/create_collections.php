<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Criar Nova Coleção</title>
  <link rel="stylesheet" href="../css/styles.css">
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
          <li><a href="eventos.php">Eventos</a></li>
          <li><a href="criar_colecao.php">Criar coleção</a></li>
          <li><a href="criar_eventos.php">Criar evento</a></li>
        </ul>
      </nav>
      <form class="search-bar" action="resultados.php" method="GET">
        <input type="text" name="q" placeholder="Pesquisar..." required>
        <button type="submit">Buscar</button>
        <div class="login-header"><a href="login.php">Login</a></div>
      </form>
    </div>
  </header>

  <main>
    <section>
      <h2>Criar Nova Coleção</h2>
      <form action="../bll/handle_create_collection.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="collectionImage">Imagem da Coleção:</label>
          <input type="file" id="collectionImage" name="collectionImage" accept="image/*" required>
        </div>
        <div class="form-group">
          <label for="titles">Títulos da Coleção:</label>
          <textarea id="titles" name="titles" rows="2" required></textarea>
        </div>
        <div class="form-group">
          <label for="description">Descrição:</label>
          <textarea id="description" name="description" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn-colecao">Criar Coleção</button>
      </form>
    </section>
    <section>
      <h2>Importar Coleção via CSV</h2>
      <form action="../bll/import_collection.php" method="POST" enctype="multipart/form-data">
        <label for="csv">Escolha o arquivo CSV:</label>
        <input type="file" name="csv" accept=".csv" required>
        <button type="submit">Importar Coleção</button>
      </form>
    </section>
  </main>

  <footer>
    <p>The Book Collectors</p>
  </footer>
</body>

</html>