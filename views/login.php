<?php
session_start();
require_once "../services/LoginService.php";

// Si el usuario ya está autenticado, lo redirige al dashboard
if (isset($_SESSION['user_role'])) {
    header("Location: dashboard.php");
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $response = LoginService::login($email, $password);

    if (isset($response['success'])) {
        $_SESSION['user_role'] = $response['role'];

        // Redirigir según el rol del usuario
        if ($response['role'] === 'ADMIN') {
            header("Location: dashboard.php");
        } else { // Para empleados, por ahora mismo dashboard es el mismo para todos
            header("Location: dashboard.php");
        }
        exit;
    } else {
        $error = $response['error'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>

    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Correo Electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>
