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
        if (existUser($conn, $username)) {
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
        registerUser($conn, $username, $password);
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
  <!--<script defer src="../js/login-sign-page.js"></script>-->
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
                <div class="login-header"><a href="perform_login.php">Login</a></div>
            </form>
        </div>

    </header>
 
  <main id="main-holder">
    <h1 id="login-header">Signup</h1>
    <h1><a href="perform-login.php">Login <a></h1>
    
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div id="signup-form">
        <input type="text" name="username" class="signup-form-field <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>">
        <span class="invalid-feedback"><?php echo $username_err; ?></span>
    </div>

    <div>
        <input type="password" name="password" class="signup-form-field <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password" value="<?php echo htmlspecialchars($password); ?>">
        <span class="invalid-feedback"><?php echo $password_err; ?></span>
    </div>

    <div>
        <input type="password" name="confirm_password" class="signup-form-field <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" placeholder="Confirm Password" value="<?php echo htmlspecialchars($confirm_password); ?>">
        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
    </div>

    <input type="submit" value="Submit" id="signup-form-submit"> 
</form>

    
  </main>
  <footer>
    <p>The Book Collectors</p>
</footer>
</body>

</html>