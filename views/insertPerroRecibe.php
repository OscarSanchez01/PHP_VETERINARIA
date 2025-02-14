<?php
require_once __DIR__ . '/../layouts/header.php';
?>
<div class="container mx-auto py-10">
    <h2 class="text-2xl font-bold mb-4">Registrar Servicio para Perro</h2>
    <form action="../controllers/PerroRecibeController.php" method="POST" class="bg-white p-6 rounded shadow-md">
        <label class="block mb-2">ID Perro:</label>
        <input type="number" name="id_perro" required class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">DNI Empleado:</label>
        <input type="text" name="dni_empleado" required class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">Código del Servicio:</label>
        <input type="text" name="cod_servicio" required class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">Precio:</label>
        <input type="number" step="0.01" name="precio" required class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">Fecha del Servicio:</label>
        <input type="date" name="fecha_servicio" value="<?php echo date('Y-m-d'); ?>" required class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">Incidencias:</label>
        <textarea name="incidencia" class="w-full border p-2 rounded mb-4"></textarea>
        
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Guardar</button>
    </form>
</div>
<?php
require_once __DIR__ . '/../layouts/footer.php';
?>