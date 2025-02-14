<?php
require_once __DIR__ . '/../layouts/header.php';
?>
<div class="container mx-auto py-10">
    <h2 class="text-2xl font-bold mb-4">Insertar Perro</h2>
    <form action="../controllers/PerroController.php" method="POST" class="bg-white p-6 rounded shadow-md">
        <label class="block mb-2">DNI Dueño:</label>
        <input type="text" name="dni_duenio" required class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">Nombre:</label>
        <input type="text" name="nombre" required class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">Fecha de Nacimiento:</label>
        <input type="date" name="fecha_nto" required class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">Raza:</label>
        <input type="text" name="raza" required class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">Peso (kg):</label>
        <input type="number" step="0.1" name="peso" required class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">Altura (cm):</label>
        <input type="number" step="0.1" name="altura" required class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">Observaciones:</label>
        <textarea name="observaciones" class="w-full border p-2 rounded mb-4"></textarea>
        
        <label class="block mb-2">Número de Chip:</label>
        <input type="text" name="numero_chip" required class="w-full border p-2 rounded mb-4">
        
        <label class="block mb-2">Sexo:</label>
        <select name="sexo" required class="w-full border p-2 rounded mb-4">
            <option value="Macho">Macho</option>
            <option value="Hembra">Hembra</option>
        </select>
        
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Guardar</button>
    </form>
</div>
<?php
require_once __DIR__ . '/../layouts/footer.php';
?>