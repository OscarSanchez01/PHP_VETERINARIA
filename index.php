<?php

require_once "./services/perroService.php";

$perroModel = new PerroService();
$perros = $perroModel->obtenerPerros();
$error = "";
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["agregar"])) {
        $dni_duenio = $_POST["dni_duenio"];
        $nombre = $_POST["nombre"];
        $fecha_nto = $_POST["fecha_nto"];
        $raza = $_POST["raza"];
        $peso = $_POST["peso"];
        $altura = $_POST["altura"];
        $observaciones = $_POST["observaciones"];
        $numero_chip = $_POST["numero_chip"];
        $sexo = $_POST["sexo"];

        $resultado = $perroModel->agregarPerro($dni_duenio, $nombre, $fecha_nto, $raza, $peso, $altura, $observaciones, $numero_chip, $sexo);

        if (strpos($resultado, "Error") !== false) {
            $error = $resultado;
        } else {
            $mensaje = $resultado;
            header("Location: index.php");
            exit();
        }
    }

    if (isset($_POST["eliminar"])) {
        $chip = $_POST["numero_chip"];
        $resultado = $perroModel->eliminarPerro($chip);

        if (strpos($resultado, "Error") !== false) {
            $error = $resultado;
        } else {
            $mensaje = $resultado;
            header("Location: index.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Perros</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .error { color: red; }
        .mensaje { color: green; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-bottom: 20px; }
        input, select { padding: 5px; margin-right: 5px; }
    </style>
</head>
<body>

    <h1>Gestión de Perros</h1>

    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if ($mensaje): ?>
        <p class="mensaje"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <h2>Agregar Perro</h2>
    <form method="post">
        <input type="text" name="dni_duenio" placeholder="DNI Dueño" required>
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="date" name="fecha_nto" required>
        <input type="text" name="raza" placeholder="Raza" required>
        <input type="number" step="0.1" name="peso" placeholder="Peso (kg)" required>
        <input type="number" name="altura" placeholder="Altura (cm)" required>
        <input type="text" name="observaciones" placeholder="Observaciones">
        <input type="text" name="numero_chip" placeholder="Número de Chip" required>
        <select name="sexo" required>
            <option value="Macho">Macho</option>
            <option value="Hembra">Hembra</option>
        </select>
        <button type="submit" name="agregar">Agregar</button>
    </form>

    <h2>Listado de Perros</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>DNI Dueño</th>
            <th>Nombre</th>
            <th>Fecha de Nacimiento</th>
            <th>Raza</th>
            <th>Peso (kg)</th>
            <th>Altura (cm)</th>
            <th>Observaciones</th>
            <th>Chip</th>
            <th>Sexo</th>
            <th>Acción</th>
        </tr>
        <?php foreach ($perros as $perro): ?>
            <tr>
                <td><?php echo $perro['ID_Perro']; ?></td>
                <td><?php echo $perro['Dni_duenio']; ?></td>
                <td><?php echo $perro['Nombre']; ?></td>
                <td><?php echo $perro['Fecha_Nto']; ?></td>
                <td><?php echo $perro['Raza']; ?></td>
                <td><?php echo $perro['Peso']; ?></td>
                <td><?php echo $perro['Altura']; ?></td>
                <td><?php echo $perro['Observaciones']; ?></td>
                <td><?php echo $perro['Numero_Chip']; ?></td>
                <td><?php echo $perro['Sexo']; ?></td>
                <td>
                    <form method="post" onsubmit="return confirm('¿Seguro que deseas eliminar este perro?');">
                        <input type="hidden" name="numero_chip" value="<?php echo $perro['Numero_Chip']; ?>">
                        <button type="submit" name="eliminar">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
