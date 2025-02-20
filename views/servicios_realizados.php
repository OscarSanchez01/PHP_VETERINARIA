<?php
session_start();
require_once "../controllers/ServicioRealizadoController.php";
require_once "../services/ServicioRealizadoService.php";

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_role'])) {
    header("Location: login.php");
    exit;
}

$controller = new ServicioRecibidoController();

// Si el usuario es ADMIN, obtiene todos los servicios
$servicios_realizados = ($_SESSION['user_role'] === "ADMIN")
    ? $controller->listarServiciosRealizados()
    : $controller->listarServiciosPorEmpleado($_SESSION['user_id']);

// Procesar formulario para registrar un servicio
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    // Validar que todos los datos estén presentes
    if (!empty($_POST['fecha']) && !empty($_POST['codigo_servicio']) && !empty($_POST['id_perro']) && !empty($_POST['precio_final'])) {
        ServicioRealizadoService::registrarServicio(
            $_POST['fecha'],
            $_POST['codigo_servicio'],
            $_POST['id_perro'],
            $_SESSION['user_id'],
            $_POST['precio_final'],
            $_POST['incidencias'] ?? null
        );
        header("Location: servicios_realizados.php");
        exit;
    } else {
        $error = "Todos los campos obligatorios deben estar llenos.";
    }
}

// Procesar solicitud para eliminar un servicio
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    if (!empty($_POST['Sr_Cod'])) {
        ServicioRealizadoService::eliminarServicio($_POST['Sr_Cod']);
        header("Location: servicios_realizados.php");
        exit;
    } else {
        $error = "No se puede eliminar el servicio sin un código válido.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Servicios Realizados</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .delete-btn {
            color: red;
            font-weight: bold;
            cursor: pointer;
        }
        .delete-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Servicios Realizados</h1>
    <a href="dashboard.php"> Volver al Dashboard</a>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <h2>Registrar Servicio Realizado</h2>
    <form method="POST">
        <label>Fecha:</label>
        <input type="date" name="fecha" required>
        
        <label>Código del Servicio:</label>
        <input type="text" name="codigo_servicio" placeholder="Código" required>
        
        <label>ID del Perro:</label>
        <input type="text" name="id_perro" placeholder="ID del Perro" required>
        
        <label>Precio Final (€):</label>
        <input type="number" step="0.01" name="precio_final" placeholder="Precio" required>
        
        <label>Incidencias:</label>
        <input type="text" name="incidencias" placeholder="Opcional">
        
        <button type="submit" name="agregar">Registrar</button>
    </form>

    <h2>Lista de Servicios Realizados</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Código del Servicio</th>
                <th>ID del Perro</th>
                <th>DNI Empleado</th>
                <th>Precio Final</th>
                <th>Incidencias</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($servicios_realizados as $servicio): ?>
                <tr>
                    <td><?php echo htmlspecialchars($servicio['Fecha']); ?></td>
                    <td><?php echo htmlspecialchars($servicio['Cod_Servicio'] ?? 'No disponible'); ?></td>
                    <td><?php echo htmlspecialchars($servicio['ID_Perro'] ?? 'No disponible'); ?></td>
                    <td><?php echo htmlspecialchars($servicio['Dni'] ?? 'No disponible'); ?></td>
                    <td><?php echo htmlspecialchars(number_format($servicio['Precio_Final'], 2)) . " €"; ?></td>
                    <td><?php echo htmlspecialchars($servicio['Incidencias'] ?? "Ninguna"); ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="Sr_Cod" value="<?php echo $servicio['Sr_Cod']; ?>">
                            <button type="submit" name="eliminar" class="delete-btn">❌ Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
