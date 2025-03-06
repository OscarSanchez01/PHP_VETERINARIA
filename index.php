<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_role'])) {
    header("Location: /PHP_VETERINARIA/views/login.php");
    exit();
}

header("Location: /PHP_VETERINARIA/views/perros.php");
exit();
?>
