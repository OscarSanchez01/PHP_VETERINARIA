<?php
session_start();
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
    <title>Servicios Realizados</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="shortcut icon" href="./../assets/images/logo.png" type="image/x-icon">
</head>


<body class="bg-indigo-200">
    <header class="flex justify-between items-center bg-rose-500 mb-14 p-2 h-[100px]">
        <div class="flex gap-4 items-center">
            <img src="./../assets/images/logo.png" class="w-[50px] h-[50px] rounded-3xl" alt="">
            <h1 class="text-2xl text-white font-medium">Veterineria Ribera</h1>
        </div>
        <nav class="mr-7">
            <ul class="flex gap-5">
                <li><a class="text-lg text-white font-medium" href="./dashboard.php">Inicio</a></li>
                <li><a class="text-lg text-white font-medium" href="./perros.php">Perros</a></li>
                <li><a class="text-lg text-white font-medium" href="./clientes.php">Clientes</a></li>
                <li><a class="text-lg text-white font-medium" href="./servicios_realizados.php">Servicios Realizados</a></li>
                <li><a class="text-lg text-white font-medium" href="./logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>


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


    <div class="bg-indigo-500 m-2 rounded-sm p-4 mb-10">
        <h2 class="text-white text-2xl mb-5">Agregar Cliente</h2>
        <form method="POST" class="flex flex-wrap gap-5">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="dni" placeholder="DNI">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="nombre" placeholder="Nombre">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="apellido1" placeholder="Apellido 1">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="apellido2" placeholder="Apellido 2">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="direccion" placeholder="Dirección">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="tlfno" placeholder="Teléfono">
            <button class="bg-indigo-900 rounded-sm p-2 text-white" type="submit" name="agregar">Agregar Cliente</button>
        </form>
        <?php
        if ($errorCrearCliente !== "") {
            echo '<p class = "text-rose-400 mt-3">' . $errorCrearCliente . '</p>';
        }
        ?>
    </div>
    <?php if ($cliente_a_editar): ?>
        <div class="bg-indigo-500 m-2 rounded-sm p-4 mb-10">
            <h2 class="text-white text-2xl mb-5">Editar Cliente</h2>
            <form method="POST" class="flex flex-wrap gap-5">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="hidden" name="dni" value="<?php echo $cliente_a_editar['Dni']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="nombre" placeholder="Nombre" required value="<?php echo $cliente_a_editar['Nombre']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="apellido1" placeholder="Apellido 1" required value="<?php echo $cliente_a_editar['Apellido1']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="apellido2" placeholder="Apellido 2" value="<?php echo $cliente_a_editar['Apellido2']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="direccion" placeholder="Dirección" required value="<?php echo $cliente_a_editar['Direccion']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="tlfno" placeholder="Teléfono" required value="<?php echo $cliente_a_editar['Tlfno']; ?>">
                <button class="bg-indigo-900 rounded-sm p-2 text-white" type="submit" name="actualizar">Actualizar Cliente</button>
                <button class="bg-rose-400 rounded-sm p-2 text-white">
                    <a href="clientes.php">Cancelar</a>
                </button>
            </form>
        </div>
    <?php endif; ?>

    <div class="bg-indigo-500 m-2 rounded-sm p-4">
        <h2 class="text-white text-2xl mb-5">Lista de Clientes</h2>
        <table class="w-full">
            <tr class="flex gap-5 w-full mb-3">
                <th class="w-[110px] text-white text-center">DNI</th>
                <th class="w-[200px] text-white text-center">Nombre</th>
                <th class="w-[300px] text-white text-center">Dirección</th>
                <th class="w-[120px] text-white text-center">Teléfono</th>
                <th class="w-[150px] text-white text-center">Acciones</th>

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
                    <?php if ($_SESSION['user_role'] !== 'AUXILIAR'): ?>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="dni" value="<?php echo $cliente['Dni']; ?>">
                            <button type="submit" name="eliminar">❌ Eliminar</button>
                        </form>
                    <?php endif; ?>
                </td>

            </tr>
            <?php foreach ($clientes as $cliente): ?>
                <tr class="flex gap-5 w-full mb-3">
                    <td class="flex items-center justify-center bg-indigo-300 rounded-sm p-2 text-center w-[110px] text-[#E5E5E5]"><?php echo $cliente['Dni']; ?></td>
                    <td class="flex items-center justify-center bg-indigo-300 rounded-sm p-2 text-center w-[200px] text-[#E5E5E5]"><?php echo $cliente['Nombre'] . " " . $cliente['Apellido1'] . " " . $cliente['Apellido2']; ?></td>
                    <td class="flex items-center justify-center bg-indigo-300 rounded-sm p-2 text-center w-[300px] text-[#E5E5E5]"><?php echo $cliente['Direccion']; ?></td>
                    <td class="flex items-center justify-center bg-indigo-300 rounded-sm p-2 text-center w-[120px] text-[#E5E5E5]"><?php echo $cliente['Tlfno']; ?></td>
                    <td class="flex items-center gap-3">
                        <button class="bg-indigo-900 rounded-sm p-2 text-white w-[70px]"><a href="clientes.php?editar=<?php echo $cliente['Dni']; ?>">Editar</a></button>
                        <form method="POST" class="inline">
                            <input type="hidden" name="dni" value="<?php echo $cliente['Dni']; ?>">
                            <button class="bg-rose-400 rounded-sm p-2 text-white" type="submit" name="eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
    <?php endforeach; ?>
</html>