<?php
require_once __DIR__ . '/../layouts/header.php';
?>
<div class="container mx-auto py-10">
    <h2 class="text-2xl font-bold mb-4">Insertar Empleado</h2>
    <form action="../controllers/EmpleadoController.php" method="POST" class="bg-white p-6 rounded shadow-md">
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
        
        <label class="block mb-2">Email:</label>
        <input type="email" name="email" required class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">Contraseña:</label>
        <input type="password" name="password" required class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">Rol:</label>
        <select name="rol" required class="w-full border p-2 rounded mb-4">
            <option value="ADMIN">ADMIN</option>
            <option value="EMPLEADO">EMPLEADO</option>
        </select>
        
        <label class="block mb-2">Profesión:</label>
        <select name="profesion" required class="w-full border p-2 rounded mb-4">
            <option value="ESTILISTA">ESTILISTA</option>
            <option value="NUTRICIONISTA">NUTRICIONISTA</option>
            <option value="AUXILIAR">AUXILIAR</option>
            <option value="ATT.CLIENTE">ATT.CLIENTE</option>
        </select>
        
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Guardar</button>
    </form>
</div>
<?php
require_once __DIR__ . '/../layouts/footer.php';
?>
