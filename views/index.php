<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_role'])) {
    header("Location: login.php");
    exit();
}

header("Location: perros.php");
exit();
?>
