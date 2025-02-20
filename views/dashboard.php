<?php
session_start();

// Si no hay usuario autenticado, redirigir al login
if (!isset($_SESSION['user_role'])) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['user_role'];
$email = $_SESSION['user_email'] ?? "Usuario Desconocido";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Panel de Control</h1>
    <p>Bienvenido, <?php echo $email; ?> (<?php echo strtoupper($role); ?>)</p>

    <h2>Menú</h2>
    <ul>
        <li><a href="clientes.php">Gestión de Clientes</a></li>
        <li><a href="perros.php">Gestión de Perros</a></li>

        <?php if ($role === 'ADMIN'): ?>
            <li><a href="empleados.php">Gestión de Empleados</a></li>
            <li><a href="servicios.php">Gestión de Servicios</a></li>
        <?php endif; ?>

        <li><a href="logout.php">Cerrar Sesión</a></li>
    </ul>
</body>
</html>
