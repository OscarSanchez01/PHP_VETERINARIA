<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../controllers/perro_recibeController.php';

$controller = new PerroRecibeController($conexion);
$servicios = $controller->obtenerTodosLosServicios();
?>
<div class="container mx-auto py-10">
    <h2 class="text-2xl font-bold mb-4">Todos los Servicios Realizados</h2>
    
    <?php if (!empty($servicios) && is_array($servicios)) : ?>
        <table class="w-full border-collapse bg-white shadow-md">
            <thead>
                <tr>
                    <th class="border p-2">Fecha</th>
                    <th class="border p-2">Código Servicio</th>
                    <th class="border p-2">ID Perro</th>
                    <th class="border p-2">DNI Empleado</th>
                    <th class="border p-2">Precio</th>
                    <th class="border p-2">Incidencia</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($servicios as $servicio) : ?>
                    <tr>
                        <td class="border p-2"><?php echo $servicio['Fecha_Servicio']; ?></td>
                        <td class="border p-2"><?php echo $servicio['Cod_Servicio']; ?></td>
                        <td class="border p-2"><?php echo $servicio['ID_Perro']; ?></td>
                        <td class="border p-2"><?php echo $servicio['DNI_Empleado']; ?></td>
                        <td class="border p-2">€<?php echo $servicio['Precio']; ?></td>
                        <td class="border p-2"><?php echo $servicio['Incidencia']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p class="text-red-500">No hay servicios registrados.</p>
    <?php endif; ?>
</div>
<?php
require_once __DIR__ . '/../layouts/footer.php';
?>