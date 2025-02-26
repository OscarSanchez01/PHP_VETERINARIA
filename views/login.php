<?php
session_start();
require_once "../services/LoginService.php";

// Si el usuario ya está autenticado, lo redirige a la app
if (isset($_SESSION['user_role'])) {
    header("Location: perros.php");
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $response = LoginService::login($email, $password);

    if (isset($response['success'])) {
        $_SESSION['user_role'] = $response['role'];

        // Redirigir según el rol del usuario
        header("Location: perros.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="./../assets/images/logo.png" type="image/x-icon">
</head>

<body class="bg-gradient-to-r from-indigo-400 to-blue-600 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-2xl w-96">
        <div class="flex flex-col items-center mb-6">
            <img src="./../assets/images/logo.png" class="w-16 h-16 rounded-full shadow-md" alt="">
            <h1 class="text-3xl font-bold text-indigo-900 mt-2">Iniciar Sesión</h1>
        </div>

        <?php if ($error): ?>
            <p class="text-red-600 text-center mb-4 font-semibold"> <?php echo $error; ?> </p>
        <?php endif; ?>

        <form method="POST" class="flex flex-col gap-4">
            <input class="bg-gray-100 rounded-md p-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500" type="email" name="email" placeholder="Correo Electrónico" required>
            <input class="bg-gray-100 rounded-md p-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500" type="password" name="password" placeholder="Contraseña" required>
            <button class="bg-indigo-700 text-white py-2 rounded-md font-semibold hover:bg-indigo-900 transition duration-300 shadow-md" type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>

</html>