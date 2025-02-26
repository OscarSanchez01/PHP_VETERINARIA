<?php
session_start();

// Controlar que sólo se pueda acceder al login si no hay sesión iniciada
if (!isset($_SESSION['user_role']) || empty($_SESSION['user_role'])) {
    if (basename($_SERVER['PHP_SELF']) !== 'login.php') {
        header("Location: login.php");
        exit();
    }
}

?>
