<?php

if (!isset($_SESSION) || !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    echo '<div class="login-header"><a href="perform_login.php">Login</a></div>';
}
else {
    echo '<div class="login-header"><a href="profile.php">Profile</a></div>';
    echo '<div class="login-header"><a href="../bll/logout.php">Logout</a></div>';
}

?>