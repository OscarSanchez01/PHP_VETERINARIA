<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veterinaria</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 text-white">
        <div class="container mx-auto flex justify-between">
            <a href="index.php" class="text-xl font-bold">Veterinaria</a>
            <div>
                <a href="?page=insertCliente" class="px-4">Nuevo Cliente</a>
                <a href="?page=insertPerro" class="px-4">Nuevo Perro</a>
                <a href="?page=insertEmpleado" class="px-4">Nuevo Empleado</a>
                <a href="?page=insertServicio" class="px-4">Nuevo Servicio</a>
                <a href="?page=login" class="px-4">Login</a>
            </div>
        </div>
    </nav>
    <main class="container mx-auto p-6">