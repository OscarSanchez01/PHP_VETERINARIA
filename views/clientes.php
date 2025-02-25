<?php
require_once "../controllers/ClienteController.php";
$controller = new ClienteController();
$clientes = $controller->listarClientes();
$errorCrearCliente = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    //Comprobamos que el no tenga datos vacios
    if (!isset($_POST['dni']) || $_POST['dni'] === '') {
        $errorCrearCliente = "El DNI no puede estar vacio";
    } else if (!isset($_POST['nombre']) || $_POST['nombre'] === '') {
        $errorCrearCliente = "El nombre no puede estar vacio";
    } else if (!isset($_POST['apellido1']) || $_POST['apellido1'] === '') {
        $errorCrearCliente = "El primer apellido no puede estar vacio";
    } else if (!isset($_POST['apellido2']) || $_POST['apellido2'] === '') {
        $errorCrearCliente = "El segundo apellido no puede estar vacio";
    } else if (!isset($_POST['direccion']) || $_POST['direccion'] === '') {
        $errorCrearCliente = "La direccion no puede estar vacia";
    } else if (!isset($_POST['tlfno']) || $_POST['tlfno'] === '') {
        $errorCrearCliente = "El telefono no puede estar vacio";
    }

    //Si ha completado los campos, controlamos el dni
    if ($errorCrearCliente === "") {
        //Comprobamos que no exista dni
        foreach ($clientes as $key => $value) {
            foreach ($value as $clave => $valor) {
                if ($clave == "Dni") {
                    if ($valor === $_POST['dni']) {
                        $errorCrearCliente = "El cliente con el DNI " . $valor . " ya existe";
                    }
                }
            }
        }
    }
    if ($errorCrearCliente === "") {
        require_once "../services/ClienteService.php";
        ClienteService::crearCliente($_POST['dni'], $_POST['nombre'], $_POST['apellido1'], $_POST['apellido2'], $_POST['direccion'], $_POST['tlfno']);
        header("Location: clientes.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    require_once "../services/ClienteService.php";
    ClienteService::actualizarCliente($_POST['dni'], $_POST['nombre'], $_POST['apellido1'], $_POST['apellido2'], $_POST['direccion'], $_POST['tlfno']);
    header("Location: clientes.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $dni = $_POST['dni'];
    $ch = curl_init("http://localhost/gromer/SerWeb/clientes.php");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "dni=$dni");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
    header("Location: clientes.php");
    exit;
}

$cliente_a_editar = null;
if (isset($_GET['editar'])) {
    foreach ($clientes as $cliente) {
        if ($cliente['Dni'] === $_GET['editar']) {
            $cliente_a_editar = $cliente;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
</head>

<body>
    <h1>Lista de Clientes</h1>
    <a href="dashboard.php">Volver al Dashboard</a>

    <h2>Agregar Cliente</h2>
    <form method="POST">
        <input type="text" name="dni" placeholder="DNI">
        <input type="text" name="nombre" placeholder="Nombre">
        <input type="text" name="apellido1" placeholder="Apellido 1">
        <input type="text" name="apellido2" placeholder="Apellido 2">
        <input type="text" name="direccion" placeholder="Dirección">
        <input type="text" name="tlfno" placeholder="Teléfono">
        <button type="submit" name="agregar">Agregar Cliente</button>
    </form>
    <?php
    if ($errorCrearCliente !== "") {
        echo '<p style="color: red;">' . $errorCrearCliente . '</p>';
    }
    ?>

    <?php if ($cliente_a_editar): ?>
        <h2>Editar Cliente</h2>
        <form method="POST">
            <input type="hidden" name="dni" value="<?php echo $cliente_a_editar['Dni']; ?>">
            <input type="text" name="nombre" placeholder="Nombre" required value="<?php echo $cliente_a_editar['Nombre']; ?>">
            <input type="text" name="apellido1" placeholder="Apellido 1" required value="<?php echo $cliente_a_editar['Apellido1']; ?>">
            <input type="text" name="apellido2" placeholder="Apellido 2" value="<?php echo $cliente_a_editar['Apellido2']; ?>">
            <input type="text" name="direccion" placeholder="Dirección" required value="<?php echo $cliente_a_editar['Direccion']; ?>">
            <input type="text" name="tlfno" placeholder="Teléfono" required value="<?php echo $cliente_a_editar['Tlfno']; ?>">
            <button type="submit" name="actualizar">Actualizar Cliente</button>
            <a href="clientes.php">Cancelar</a>
        </form>
    <?php endif; ?>

    <h2>Lista de Clientes</h2>
    <table border="1">
        <tr>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?php echo $cliente['Dni']; ?></td>
                <td><?php echo $cliente['Nombre'] . " " . $cliente['Apellido1'] . " " . $cliente['Apellido2']; ?></td>
                <td><?php echo $cliente['Direccion']; ?></td>
                <td><?php echo $cliente['Tlfno']; ?></td>
                <td>
                    <a href="clientes.php?editar=<?php echo $cliente['Dni']; ?>">✏️ Editar</a>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="dni" value="<?php echo $cliente['Dni']; ?>">
                        <button type="submit" name="eliminar">❌ Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>