<?php
require_once("../bll/handle_register.php");

// Define variables and initialize with empty values
$username = $password = $email = $dataNascimento = $confirm_password = "";
$username_err = $password_err = $email_err = $dataNascimento_err =  $confirm_password_err = "";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: profile.php");
    exit;
}

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
    
    // Validate data de nascimento
     if (empty(trim($_POST["dataNascimento"]))) {
       $dataNascimento_err = "Please enter a date.";
    } else if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', trim($_POST["dataNascimento"]))) {
       $dataNascimento_err = "Date can only contain numbers and underscores.";
    } else {
        $dataNascimento = trim($_POST["dataNascimento"]);
    }


    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+@[a-zA-Z0-9_]+\.[a-zA-Z0-9_]+$/', trim($_POST["email"]))) {
        $email_err = "email can only contain letters, numbers, and underscores.";
    } else {
        if (existUser($conn, $email)) {
            $email_err = "This email is already taken.";
        } else {
            $email = trim($_POST["email"]);
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
    if (empty($username_err) && empty($password_err) && empty($dataNascimento_err)&& empty($email_err) && empty($confirm_password_err)) {
        registerUser($conn, $username, $password, $dataNascimento, $email);
        header("location:profile.php");
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
</head>

<body>
       <!-- Nome da página na parte superior -->
       <div class="nome-pagina">
        <h1>The Book Collectors</h1>
    </div>

    <!-- Barra de Navegação logo abaixo -->
    <?php include "header.php"; ?>
 
  <main id="main-holder">
    <h1 id="login-header">Signup</h1>
    <h1><a href="perform_login.php">Login <a></h1>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div id="signup-form">
            <input type="text" name="username" class="signup-form-field <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>

        <div>
            <input type="date" name="dataNascimento" class="signup-form-field <?php echo (!empty($dataNascimento_err)) ? 'is-invalid' : ''; ?>" placeholder="Data de Nascimento" value="<?php echo htmlspecialchars($dataNascimento); ?>">
            <span class="invalid-feedback"><?php echo $dataNascimento_err; ?></span>
        </div>

        <div>
            <input type="text" name="email" class="signup-form-field <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
            <span class="invalid-feedback"><?php echo $email_err; ?></span>
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