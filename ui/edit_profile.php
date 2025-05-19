<?php

require_once("../bll/handle_profile.php");
require_once("../bll/handle_login.php");
require_once("../bll/handle_register.php");

// Define variables and initialize with empty values

$username_err = $password_err = $old_password_err = $email_err = $dataNascimento_err =  $confirm_password_err = "";

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: perform_login.php");
}else {
    $array1 = getUser($conn, $_SESSION["username"]);
}

// $username = $array1['username'];
$email = $array1['email'];
$dataNascimento = $array1['dataNascimento'];
$old_password = $password = $confirm_password = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verify old password
    $old_password = trim($_POST["old_password"]);
    if (empty($old_password)) {
        $old_password_err = "Please enter the old password.";
    } elseif (!checkUser($conn, $_SESSION["username"], $old_password)) {
        $old_password_err = "Old password incorrect.";
    } else {
        // // Validate username
        // if (empty(trim($_POST["username"]))) {
        //     $username_err = "Please enter a username.";
        // } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        //     $username_err = "Username can only contain letters, numbers, and underscores.";
        // } else {
        //     if (existUser($conn, trim($_POST['username'])) && $username != trim($_POST['username'])) {
        //         $username_err = "This username is already taken.";
        //     } else {
        //         $username = trim($_POST["username"]);
        //     }
        // }
        
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
            if (existUser($conn, trim($_POST["email"])) && $email != trim($_POST["email"])) {
                $email_err = "This email is already taken.";
            } else {
                $email = trim($_POST["email"]);
            }
        }

        // Validate password
        if (!empty(trim($_POST["password"]))) {
            if (strlen(trim($_POST["password"])) < 6) {
                $password_err = "Password must have atleast 6 characters.";
            } else {
                // Validate confirm password
                if (empty(trim($_POST["confirm_password"]))) {
                    $confirm_password_err = "Please confirm password.";
                } else {
                    $password = trim($_POST["password"]);
                    $confirm_password = trim($_POST["confirm_password"]);
                    if (empty($password_err) && (strcmp($password,$confirm_password) != 0)) {
                        $password_err = "Password did not match.";
                        $confirm_password_err = "Password did not match.";
                    }
                }
            }
        } else {
            $password = trim($_POST["old_password"]);
        }

        // Check input errors before inserting in database
        if (empty($username_err) && empty($old_password_err) && empty($password_err) && empty($confirm_password_err) && empty($dataNascimento_err)&& empty($email_err) && empty($confirm_password_err)) {
            editUser($conn,$array1['id'], $password, $dataNascimento, $email);
            header("location:profile.php");
        }
        $password = $old_password = $confirm_password = "";
    }

}

?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Book Collectors</title>
    <link rel="stylesheet" href="../css/styles.css" />
    
</head>

<body>

    <div class="nome-pagina">
        <h1>The Book Collectors</h1>
    </div>

    <?php include "header.php"; ?>

    <main>
        <section class="profile-container">
            <div class="profile-info">
                <h3><a>Editar Perfil</a></h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <p><strong>Username: </strong> 
                        <input type="text" name="username" class="signup-form-field <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" placeholder="Username" value="<?php echo htmlspecialchars($array1["username"]); ?>" disabled="disabled">
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    </p>
                    <p><strong>Data de nascimento: </strong>
                        <input type="date" name="dataNascimento" class="signup-form-field <?php echo (!empty($dataNascimento_err)) ? 'is-invalid' : ''; ?>" placeholder="Data de Nascimento" value="<?php echo htmlspecialchars($array1["dataNascimento"]); ?>">
                        <span class="invalid-feedback"><?php echo $dataNascimento_err; ?></span>
                    </p>
                    <p><strong>Email: </strong>
                        <input type="text" name="email" class="signup-form-field <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" placeholder="Email" value="<?php echo htmlspecialchars($array1["email"]); ?>">
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </p>
                    <p><strong>Old Password: </strong>
                        <input type="password" name="old_password" class="signup-form-field <?php echo (!empty($old_password_err)) ? 'is-invalid' : ''; ?>" placeholder="Old Password" value="<?php echo htmlspecialchars($old_password); ?>">
                        <span class="invalid-feedback"><?php echo $old_password_err; ?></span>
                    </p>
                    <p><strong>New Password: </strong>
                        <input type="password" name="password" class="signup-form-field <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password" value="<?php echo htmlspecialchars($password); ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </p>
                    <p><strong>Confirm Password: </strong>
                        <input type="password" name="confirm_password" class="signup-form-field <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" placeholder="Confirm Password" value="<?php echo htmlspecialchars($confirm_password); ?>">
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    </p>
                    <input type="submit" value="Submit" id="signup-form-submit"> 
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>The Book Collectors</p>
    </footer>
</body>

</html>
