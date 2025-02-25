<?php
require_once "../controllers/ServicioRealizadoController.php";
require_once "../services/EmpleadoService.php"; // Se requiere para obtener la lista de empleados

$controller = new ServicioRealizadoController();
$empleados = EmpleadoService::getEmpleados(); // Obtener lista de empleados

// Si se aplica un filtro por empleado
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['dni_empleado']) && !empty($_GET['dni_empleado'])) {
    $servicios = $controller->listarServiciosPorEmpleado($_GET['dni_empleado']);
    $filtroActivo = true;
} else {
    $servicios = $controller->listarServiciosRealizados();
    $filtroActivo = false;
}

// Asegurarse de que `$servicios` sea un array válido para evitar errores
if (!is_array($servicios)) {
    $servicios = [];
}

// Si se está editando un servicio, se cargan los datos en el formulario
$editando = false;
$servicioEditar = [
    "Sr_Cod" => "",
    "Cod_Servicio" => "",
    "ID_Perro" => "",
    "Fecha" => "",
    "Incidencias" => "",
    "Precio_Final" => "",
    "Dni" => ""
];

// Procesar inserción o actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        "Cod_Servicio" => $_POST["Cod_Servicio"],
        "ID_Perro" => $_POST["ID_Perro"],
        "Fecha" => $_POST["Fecha"],
        "Incidencias" => $_POST["Incidencias"],
        "Precio_Final" => $_POST["Precio_Final"],
        "Dni" => $_POST["Dni"]
    ];

    if (!empty($_POST["update_id"])) {
        $data["Sr_Cod"] = $_POST["update_id"];
        $controller->actualizarServicioRealizado($data);
    } else {
        $controller->agregarServicioRealizado($data);
    }

    header("Location: servicios_realizados.php");
    exit();
}

// Procesar eliminación
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete"])) {
    $controller->eliminarServicioRealizado($_GET["delete"]);
    header("Location: servicios_realizados.php");
    exit();
}

// Cargar datos para edición
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["edit"])) {
    $editando = true;
    foreach ($servicios as $servicio) {
        if ($servicio["Sr_Cod"] == $_GET["edit"]) {
            $servicioEditar = $servicio;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Servicios Realizados</title>
</head>
<body>
    <h1>Lista de Servicios Realizados</h1>
    <a href="dashboard.php">Volver al Dashboard</a>

    <h2>Filtrar por Empleado</h2>
    <form method="GET">
        <label>Selecciona un empleado:</label>
        <select name="dni_empleado">
            <option value="">Todos</option>
            <?php foreach ($empleados as $empleado): ?>
                <option value="<?php echo $empleado['Dni']; ?>" <?php echo isset($_GET['dni_empleado']) && $_GET['dni_empleado'] == $empleado['Dni'] ? 'selected' : ''; ?>>
                    <?php echo $empleado['Nombre'] . " " . $empleado['Apellido1'] . " - " . $empleado['Dni']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrar</button>
        <a href="servicios_realizados.php"><button type="button">Quitar Filtro</button></a>
    </form>

    <?php if ($filtroActivo && empty($servicios)): ?>
        <p style="color: red; font-weight: bold;">El empleado no tiene servicios.</p>
    <?php endif; ?>

    <h2><?php echo $editando ? "Modificar Servicio Realizado" : "Agregar Servicio Realizado"; ?></h2>
    <form method="POST">
        <input type="hidden" name="update_id" value="<?= $editando ? $servicioEditar['Sr_Cod'] : "" ?>">
        <label>Cod_Servicio: <input type="text" name="Cod_Servicio" value="<?= $editando ? $servicioEditar['Cod_Servicio'] : "" ?>" required></label>
        <label>ID_Perro: <input type="number" name="ID_Perro" value="<?= $editando ? $servicioEditar['ID_Perro'] : "" ?>" required></label>
        <label>Fecha: <input type="date" name="Fecha" value="<?= $editando ? $servicioEditar['Fecha'] : "" ?>" required></label>
        <label>Incidencias: <input type="text" name="Incidencias" value="<?= $editando ? $servicioEditar['Incidencias'] : "" ?>"></label>
        <label>Precio_Final: <input type="number" step="0.01" name="Precio_Final" value="<?= $editando ? $servicioEditar['Precio_Final'] : "" ?>" required></label>
        <label>Dni: <input type="text" name="Dni" value="<?= $editando ? $servicioEditar['Dni'] : "" ?>" required></label>
        <button type="submit"><?= $editando ? "Guardar Cambios" : "Agregar" ?></button>
        <?php if ($editando): ?>
            <a href="servicios_realizados.php">Cancelar</a>
        <?php endif; ?>
    </form>

    <h2>Listar Servicios Realizados</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Cod_Servicio</th>
            <th>ID_Perro</th>
            <th>Fecha</th>
            <th>Incidencias</th>
            <th>Precio_Final</th>
            <th>Dni</th>
            <th>Acciones</th>
        </tr>
        <?php if (!empty($servicios)): ?>
            <?php foreach ($servicios as $servicio): ?>
                <tr>
                    <td><?= htmlspecialchars($servicio["Sr_Cod"] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($servicio["Cod_Servicio"] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($servicio["ID_Perro"] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($servicio["Fecha"] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($servicio["Incidencias"] ?? 'Ninguna') ?></td>
                    <td><?= htmlspecialchars(number_format($servicio["Precio_Final"] ?? 0, 2)) . " €"; ?></td>
                    <td><?= htmlspecialchars($servicio["Dni"] ?? 'N/A') ?></td>
                    <td>
                        <a href="?edit=<?= $servicio["Sr_Cod"] ?>">Modificar</a>
                        <a href="?delete=<?= $servicio["Sr_Cod"] ?>" onclick="return confirm('¿Seguro que quieres eliminar este servicio?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="text-align: center; color: red; font-weight: bold;">No hay servicios registrados.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
