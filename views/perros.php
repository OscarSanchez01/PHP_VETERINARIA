<?php
session_start();
require_once "../controllers/PerroController.php";
require_once "../services/ClienteService.php"; 

$controller = new PerroController();
// Obtener lista de clientes
$clientes = ClienteService::getClientes();

// Si se aplica un filtro por cliente
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['dni_cliente']) && !empty($_GET['dni_cliente'])) {
    $perros = $controller->listarPerrosPorCliente($_GET['dni_cliente']);
    $filtroActivo = true;
} else {
    $perros = $controller->listarPerros();
    $filtroActivo = false;
}

// Asegurarse de que `$perros` sea un array válido para evitar errores
if (!is_array($perros)) {
    $perros = [];
}

// Procesar inserción o actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    require_once "../services/PerroService.php";
    PerroService::crearPerro($_POST['dni_duenio'], $_POST['nombre'], $_POST['fecha_nacimiento'], $_POST['raza'], $_POST['peso'], $_POST['altura'], $_POST['observaciones'], $_POST['numero_chip'], $_POST['sexo']);
    header("Location: perros.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    require_once "../services/PerroService.php";
    PerroService::actualizarPerro($_POST['id_perro'], $_POST['nombre'], $_POST['raza'], $_POST['fecha_nacimiento'], $_POST['peso'], $_POST['altura'], $_POST['observaciones'], $_POST['numero_chip'], $_POST['sexo'], $_POST['dni_duenio']);
    header("Location: perros.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $id_perro = $_POST['id_perro'];
    $ch = curl_init("http://localhost/gromer/SerWeb/perros.php");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "id_perro=$id_perro");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
    header("Location: perros.php");
    exit;
}

$perro_a_editar = null;
if (isset($_GET['editar'])) {
    foreach ($perros as $perro) {
        if ((string) $perro['ID_Perro'] === $_GET['editar']) { 
            $perro_a_editar = $perro;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perros</title>
</head>
<body>
    <h1>Lista de Perros</h1>
    <a href="dashboard.php">Volver al Dashboard</a>

    <h2>Filtrar por Cliente</h2>
    <form method="GET">
        <label>Selecciona un cliente:</label>
        <select name="dni_cliente">
            <option value="">Todos</option>
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?php echo $cliente['Dni']; ?>" <?php echo isset($_GET['dni_cliente']) && $_GET['dni_cliente'] == $cliente['Dni'] ? 'selected' : ''; ?>>
                    <?php echo $cliente['Nombre'] . " " . $cliente['Apellido1'] . " - " . $cliente['Dni']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrar</button>
        <a href="perros.php"><button type="button">Quitar Filtro</button></a>
    </form>

    <?php if ($filtroActivo && empty($perros)): ?>
        <p style="color: red; font-weight: bold; text-align:center;">El cliente no tiene perros registrados.</p>
    <?php endif; ?>

    <h2>Agregar Perro</h2>
    <form method="POST">
        <input type="text" name="dni_duenio" placeholder="DNI Dueño" required>
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="date" name="fecha_nacimiento" required>
        <input type="text" name="raza" placeholder="Raza" required>
        <input type="number" name="peso" placeholder="Peso (kg)" required>
        <input type="number" name="altura" placeholder="Altura (cm)" required>
        <input type="text" name="observaciones" placeholder="Observaciones">
        <input type="text" name="numero_chip" placeholder="Número de Chip" required>
        <select name="sexo" required>
            <option value="Macho">Macho</option>
            <option value="Hembra">Hembra</option>
        </select>
        <button type="submit" name="agregar">Agregar Perro</button>
    </form>

    <?php if ($perro_a_editar): ?>
        <h2>Editar Perro</h2>
        <form method="POST">
            <input type="hidden" name="id_perro" value="<?php echo $perro_a_editar['ID_Perro']; ?>">
            <input type="text" name="dni_duenio" placeholder="DNI Dueño" required value="<?php echo $perro_a_editar['Dni_duenio']; ?>">
            <input type="text" name="nombre" placeholder="Nombre" required value="<?php echo $perro_a_editar['Nombre']; ?>">
            <input type="date" name="fecha_nacimiento" required value="<?php echo $perro_a_editar['Fecha_Nto']; ?>">
            <input type="text" name="raza" placeholder="Raza" required value="<?php echo $perro_a_editar['Raza']; ?>">
            <input type="number" name="peso" placeholder="Peso (kg)" required value="<?php echo $perro_a_editar['Peso']; ?>">
            <input type="number" name="altura" placeholder="Altura (cm)" required value="<?php echo $perro_a_editar['Altura']; ?>">
            <input type="text" name="observaciones" placeholder="Observaciones" value="<?php echo $perro_a_editar['Observaciones']; ?>">
            <input type="text" name="numero_chip" placeholder="Número de Chip" required value="<?php echo $perro_a_editar['Numero_Chip']; ?>">
            <select name="sexo" required>
                <option value="Macho" <?php echo ($perro_a_editar['Sexo'] === 'Macho') ? 'selected' : ''; ?>>Macho</option>
                <option value="Hembra" <?php echo ($perro_a_editar['Sexo'] === 'Hembra') ? 'selected' : ''; ?>>Hembra</option>
            </select>
            <button type="submit" name="actualizar">Actualizar Perro</button>
            <a href="perros.php">Cancelar</a>
        </form>
    <?php endif; ?>

    <?php if (!$filtroActivo || !empty($perros)): ?>
        <h2>Lista de Perros</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Raza</th>
                <th>Fecha de Nacimiento</th>
                <th>Peso</th>
                <th>Altura</th>
                <th>Número de Chip</th>
                <th>Sexo</th>
                <th>Dueño (DNI)</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($perros as $perro): ?>
                <tr>
                    <td><?php echo $perro['ID_Perro']; ?></td>
                    <td><?php echo $perro['Nombre']; ?></td>
                    <td><?php echo $perro['Raza']; ?></td>
                    <td><?php echo $perro['Fecha_Nto']; ?></td>
                    <td><?php echo $perro['Peso']; ?> kg</td>
                    <td><?php echo $perro['Altura']; ?> cm</td>
                    <td><?php echo $perro['Numero_Chip']; ?></td>
                    <td><?php echo $perro['Sexo']; ?></td>
                    <td><?php echo $perro['Dni_duenio']; ?></td>
                    <td>
                        <a href="perros.php?editar=<?php echo $perro['ID_Perro']; ?>">✏️ Editar</a>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id_perro" value="<?php echo $perro['ID_Perro']; ?>">
                            <button type="submit" name="eliminar">❌ Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
