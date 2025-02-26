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

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Servicios Realizados</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="shortcut icon" href="./../assets/images/logo.png" type="image/x-icon">
</head>

<body class="bg-indigo-200">
    <header class="flex justify-between items-center bg-rose-500 mb-14 p-2 h-[100px]">
        <div class="flex gap-4 items-center">
            <img src="./../assets/images/logo.png" class="w-[50px] h-[50px] rounded-3xl" alt="">
            <h1 class="text-2xl text-white font-medium">Veterineria Ribera</h1>
        </div>
        <nav class="mr-7">
            <ul class="flex gap-5">
                <li><a class="text-lg text-white font-medium" href="./dashboard.php">Inicio</a></li>
                <li><a class="text-lg text-white font-medium" href="./perros.php">Perros</a></li>
                <li><a class="text-lg text-white font-medium" href="./clientes.php">Clientes</a></li>
                <li><a class="text-lg text-white font-medium" href="./servicios_realizados.php">Servicios Realizados</a></li>
                <?php if ($role === 'ADMIN'): ?>
                    <li><a class="text-lg text-white font-medium" href="empleados.php">Gestión de Empleados</a></li>
                    <li><a class="text-lg text-white font-medium" href="servicios.php">Gestión de Servicios</a></li>
                <?php endif; ?>
                <li><a class="text-lg text-white font-medium" href="./logout.php">Logaout</a></li>
            </ul>
        </nav>
        <p class="text-lg text-white font-medium">Bienvenido usuario <?php echo '<span class="text-lg text-indigo-300 font-medium">' . strtoupper($role) . '</span>'; ?></p>
    </header>
</body>

</html>