<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once ("../bll/handle_login.php");

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: profile.php");
    exit;
}

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        if (checkUser($conn, $username, $password)) {
            print("triste");

            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            
            header("location: profile.php");
            
        } else {

            $login_err = "Invalid username or password.";
        }
    } else {
        $login_err = "Invalid username or password.";
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
      <div class="nome-pagina">
        <h1>The Book Collectors</h1>
    </div>

    <?php include "header.php"; ?>

  <main id="main-holder">
    <h1>Login</h1>
    <h1><a href="register.php">Signup <a></div></h1>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div id="login-form">
        <input type="text" name="username" class="login-form-field <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" placeholder="Username" value="<?php echo $username; ?>">
        <span class="invalid-feedback"><?php echo $username_err; ?></span>
      </div>
      <div>
        <input type="password" name="password" class="login-form-field  <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password">
        <span class="invalid-feedback"><?php echo $password_err; ?></span>
      </div>
      
      <input type="submit" value="Login" id="login-form-submit">
    </form>

  </main>
  <footer>
    <p>The Book Collectors</p>
</footer>
</body>

</html>