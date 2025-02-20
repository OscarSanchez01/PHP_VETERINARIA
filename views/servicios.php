<?php
require_once "../controllers/ServicioController.php";
$controller = new ServicioController();
$servicios = $controller->listarServicios();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    require_once "../services/ServicioService.php";
    ServicioService::crearServicio($_POST['codigo'], $_POST['nombre'], $_POST['precio'], $_POST['descripcion']);
    header("Location: servicios.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    require_once "../services/ServicioService.php";
    ServicioService::actualizarPrecioServicio($_POST['codigo'], $_POST['precio']);
    header("Location: servicios.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $codigo = $_POST['codigo'];
    $ch = curl_init("http://localhost/gromer/SerWeb/servicios.php");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "codigo=$codigo");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
    header("Location: servicios.php");
    exit;
}

$servicio_a_editar = null;
if (isset($_GET['editar'])) {
    foreach ($servicios as $servicio) {
        if ($servicio['Codigo'] === $_GET['editar']) {
            $servicio_a_editar = $servicio;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Servicios</title>
</head>
<body>
    <h1>Lista de Servicios</h1>
    <a href="dashboard.php">Volver al Dashboard</a>

    <h2>Agregar Servicio</h2>
    <form method="POST">
        <input type="text" name="codigo" placeholder="Código" required>
        <input type="text" name="nombre" placeholder="Nombre del Servicio" required>
        <input type="number" step="0.01" name="precio" placeholder="Precio (€)" required>
        <input type="text" name="descripcion" placeholder="Descripción" required>
        <button type="submit" name="agregar">Agregar Servicio</button>
    </form>

    <?php if ($servicio_a_editar): ?>
        <h2>Editar Precio del Servicio</h2>
        <form method="POST">
            <input type="hidden" name="codigo" value="<?php echo $servicio_a_editar['Codigo']; ?>">
            <input type="number" step="0.01" name="precio" placeholder="Nuevo Precio (€)" required value="<?php echo $servicio_a_editar['Precio']; ?>">
            <button type="submit" name="actualizar">Actualizar Precio</button>
            <a href="servicios.php">Cancelar</a>
        </form>
    <?php endif; ?>

    <h2>Lista de Servicios</h2>
    <table border="1">
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($servicios as $servicio): ?>
            <tr>
                <td><?php echo $servicio['Codigo']; ?></td>
                <td><?php echo $servicio['Nombre']; ?></td>
                <td><?php echo number_format($servicio['Precio'], 2); ?> €</td>
                <td><?php echo $servicio['Descripcion']; ?></td>
                <td>
                    <a href="servicios.php?editar=<?php echo $servicio['Codigo']; ?>">✏️ Editar</a>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="codigo" value="<?php echo $servicio['Codigo']; ?>">
                        <button type="submit" name="eliminar">❌ Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
