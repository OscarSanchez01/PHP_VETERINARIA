<?php
require_once __DIR__ . '/../layouts/header.php';
?>
<div class="container mx-auto py-10">
    <h2 class="text-2xl font-bold mb-4">Insertar Cliente</h2>
    <form action="../controllers/ClienteController.php" method="POST" class="bg-white p-6 rounded shadow-md">
        <label class="block mb-2">DNI:</label>
        <input type="text" name="dni" required class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">Nombre:</label>
        <input type="text" name="nombre" required class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">Apellido 1:</label>
        <input type="text" name="apellido1" required class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">Apellido 2:</label>
        <input type="text" name="apellido2" required class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">Dirección:</label>
        <input type="text" name="direccion" class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">Teléfono:</label>
        <input type="text" name="tlfno" class="w-full border p-2 rounded mb-4">
        
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Guardar</button>
    </form>
</div>

<?php
require_once __DIR__ . '/../views/insertPerro.php';
require_once __DIR__ . '/../views/insertEmpleado.php';
require_once __DIR__ . '/../views/insertServicio.php';
require_once __DIR__ . '/../views/insertPerroRecibe.php';
require_once __DIR__ . '/../views/listarServiciosEmpleado.php';
require_once __DIR__ . '/../views/listarTodosServicios.php';
require_once __DIR__ . '/../views/listarClientePerros.php';
require_once __DIR__ . '/../views/modificarPrecio.php';
require_once __DIR__ . '/../views/login.php';
require_once __DIR__ . '/../layouts/footer.php';
?>