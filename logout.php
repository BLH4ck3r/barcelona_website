<?php
// logout.php - Cierre de sesión

session_start();
session_unset();
session_destroy();

header("Location: login.php");
exit;
?>
