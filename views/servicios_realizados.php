<?php
require_once "../controllers/ServicioRealizadoController.php";
$controller = new ServicioRealizadoController();
$servicios = $controller->listarServiciosRealizados();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        "Cod_Servicio" => $_POST["Cod_Servicio"],
        "ID_Perro" => $_POST["ID_Perro"],
        "Fecha" => $_POST["Fecha"],
        "Incidencias" => $_POST["Incidencias"],
        "Precio_Final" => $_POST["Precio_Final"],
        "Dni" => $_POST["Dni"]
    ];
    $controller->agregarServicioRealizado($data);
    header("Location: servicios_realizados.php");
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete"])) {
    $controller->eliminarServicioRealizado($_GET["delete"]);
    header("Location: servicios_realizados.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Servicios Realizados</title>
</head>
<body>
    <h2>Lista de Servicios Realizados</h2>
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
        <?php foreach ($servicios as $servicio): ?>
        <tr>
            <td><?= $servicio["Sr_Cod"] ?></td>
            <td><?= $servicio["Cod_Servicio"] ?></td>
            <td><?= $servicio["ID_Perro"] ?></td>
            <td><?= $servicio["Fecha"] ?></td>
            <td><?= $servicio["Incidencias"] ?></td>
            <td><?= $servicio["Precio_Final"] ?></td>
            <td><?= $servicio["Dni"] ?></td>
            <td><a href="?delete=<?= $servicio["Sr_Cod"] ?>">Eliminar</a></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Agregar Servicio Realizado</h2>
    <form method="POST">
        <label>Cod_Servicio: <input type="text" name="Cod_Servicio" required></label><br>
        <label>ID_Perro: <input type="number" name="ID_Perro" required></label><br>
        <label>Fecha: <input type="date" name="Fecha" required></label><br>
        <label>Incidencias: <input type="text" name="Incidencias"></label><br>
        <label>Precio_Final: <input type="number" step="0.01" name="Precio_Final" required></label><br>
        <label>Dni: <input type="text" name="Dni" required></label><br>
        <button type="submit">Agregar</button>
    </form>
</body>
</html>
