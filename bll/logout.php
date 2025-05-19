<?php
session_start();
 

$_SESSION = array();
 

session_destroy();
 
header("location: ../ui/perform_login.php");
exit;