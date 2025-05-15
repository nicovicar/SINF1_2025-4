<?php
require_once("../bll/handle_register.php");

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        if ($conn->existUser($username)) {
            $username_err = "This username is already taken.";
        } else {
            $username = trim($_POST["username"]);
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $conn->registerUser($username, $password);
    }

}

?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../css/styles.css">
  <script defer src="../js/login-sign-page.js"></script>
</head>

<body>
       <!-- Nome da página na parte superior -->
       <div class="nome-pagina">
        <h1>The Book Collectors</h1>
    </div>

    <!-- Barra de Navegação logo abaixo -->
    <header>
        <div class="contentor">
            <nav>
                <ul>
                    <li><a href="index.html">Ínicio</a></li>
                    <li><a href="collections.html">Coleções</a></li>
                    <li><a href="eventos.html">Eventos</a></li>
                    <li><a href="criar_colecao.html">Criar coleção</a></li>
                    <li><a href="criar_eventos.html">Criar evento</a></li>

                </ul>
            </nav>

            <form class="search-bar" action="resultados.html" method="GET">
                <input type="text" name="q" placeholder="Pesquisar..." aria-label="Pesquisar" required>
                <button type="submit">Buscar</button>
                <div class="login-header"><a href="login.html">Login</a></div>
            </form>
        </div>

    </header>
 
  <main id="main-holder">
    <h1 id="login-header">Signup</h1>
    <h1><a href="login.html">Login <a></h1>
    
    <div id="signup-error-msg-holder">
      <p id="signup-error-msg">Invalid username <span id="serror-msg-second-line">and/or password</span></p>
    </div>
    
    <form id="signup-form">
      <input type="text" name="newname" id="username-field" class="signup-form-field" placeholder="Username">
      <input type="password" name="newpass" id="password-field" class="signup-form-field" placeholder="Password">
      <input type="submit" value="signup" id="signup-form-submit">
    </form>
  
  </main>
  <footer>
    <p>The Book Collectors</p>
</footer>
</body>

</html>