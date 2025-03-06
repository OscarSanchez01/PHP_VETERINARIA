<?php
require_once "../frontcontroller.php";
require_once "../controllers/PerroController.php";
require_once "../services/ClienteService.php";

$controller = new PerroController();
// Obtener lista de clientes
$clientes = ClienteService::getClientes();
$errorCrearPerro = "";
$errorEditarPerro = "";
$cliente_existe = false;
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
    //Controlamos que esten todos los datos completos
    if (!isset($_POST['dni_duenio']) || $_POST['dni_duenio'] === '') {
        $errorCrearPerro = "El DNI no puede estar vacio";
    } else if (!isset($_POST['nombre']) || $_POST['nombre'] === '') {
        $errorCrearPerro = "El nombre no puede estar vacio";
    } else if (!isset($_POST['fecha_nacimiento']) || $_POST['fecha_nacimiento'] === '') {
        $errorCrearPerro = "La fecha de nacimiento no puede estar vacia";
    } else if (!isset($_POST['nombre']) || $_POST['nombre'] === '') {
        $errorCrearPerro = "El nombre no puede estar vacio";
    } else if (!isset($_POST['raza']) || $_POST['raza'] === '') {
        $errorCrearPerro = "La raza no puede estar vacia";
    } else if (!isset($_POST['peso']) || $_POST['peso'] === '') {
        $errorCrearPerro = "El peso no puede estar vacio";
    } else if (!isset($_POST['numero_chip']) || $_POST['numero_chip'] === '') {
        $errorCrearPerro = "El chip no puede estar vacio";
    } else if (!isset($_POST['sexo']) || $_POST['sexo'] === '') {
        $errorCrearPerro = "El sexo no puede estar vacio";
    }
    //Si todos los datos requeridos estan completos, conotrolamos que exitsa el dueño
    if ($errorCrearPerro === "") {
        //Comprobamos exista dni
        foreach ($clientes as $cliente) {
            if (!empty($cliente['Dni']) && trim(strval($cliente['Dni'])) === trim(strval($_POST['dni_duenio']))) {
                $cliente_existe = true;
                break;
            }
        }
        if (!$cliente_existe) {
            $errorCrearPerro = "El cliente con el DNI " . $_POST['dni_duenio'] . " no existe";
        }
    }
    if ($errorCrearPerro === "") {
        require_once "../services/PerroService.php";
        PerroService::crearPerro($_POST['dni_duenio'], $_POST['nombre'], $_POST['fecha_nacimiento'], $_POST['raza'], $_POST['peso'], $_POST['altura'], $_POST['observaciones'], $_POST['numero_chip'], $_POST['sexo']);
        header("Location: perros.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    //Comprobamos exista dni
    foreach ($clientes as $cliente) {
        if (!empty($cliente['Dni']) && trim(strval($cliente['Dni'])) === trim(strval($_POST['dni_duenio']))) {
            $cliente_existe = true;
            break;
        }
    }
    if (!$cliente_existe) {
        $errorEditarPerro = "El cliente con el DNI " . $_POST['dni_duenio'] . " no existe";
    }

    if ($errorEditarPerro === "") {
        require_once "../services/PerroService.php";
        PerroService::actualizarPerro($_POST['id_perro'], $_POST['nombre'], $_POST['raza'], $_POST['fecha_nacimiento'], $_POST['peso'], $_POST['altura'], $_POST['observaciones'], $_POST['numero_chip'], $_POST['sexo'], $_POST['dni_duenio']);
        header("Location: perros.php");
        exit;
    }
}

// Procesar eliminación
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete"])) {
    $controller->eliminarPerro($_GET["delete"]);
    header("Location: perros.php");
    exit();
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
                <li><a class="text-lg text-white font-medium" href="./perros.php">Perros</a></li>
                <li><a class="text-lg text-white font-medium" href="./clientes.php">Clientes</a></li>
                <li><a class="text-lg text-white font-medium" href="./servicios_realizados.php">Servicios Realizados</a></li>
                <li><a class="text-lg text-white font-medium" href="./servicios.php">Servicios</a></li>
                <?php if ($_SESSION['user_role'] === 'ADMIN'): ?>
                    <li><a class="text-lg text-white font-medium" href="./empleados.php">Empleados</a></li>
                <?php endif; ?>
                <li><a class="text-lg text-white font-medium p-2" href="./logout.php">Cerrar sesión</a></li>
                <?php echo $_SESSION['user_profesion']; ?>
            </ul>
        </nav>
    </header>

    <div class="bg-indigo-500 m-2 rounded-sm p-4 mb-10">
        <h2 class="text-white text-2xl mb-5">Agregar Perro</h2>
        <form method="POST" class="flex flex-wrap gap-5">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="dni_duenio" placeholder="DNI Dueño">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="nombre" placeholder="Nombre">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="date" name="fecha_nacimiento">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="raza" placeholder="Raza">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="number" name="peso" placeholder="Peso (kg)">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="number" name="altura" placeholder="Altura (cm)">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="observaciones" placeholder="Observaciones">
            <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="numero_chip" placeholder="Número de Chip">
            <select class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" name="sexo">
                <option value="Macho">Macho</option>
                <option value="Hembra">Hembra</option>
            </select>
            <button class="bg-indigo-900 rounded-sm p-2 text-white" type="submit" name="agregar">Agregar Perro</button>
        </form>
        <?php
        if ($errorCrearPerro !== "") {
            echo '<p class="text-rose-400 mt-3">' . $errorCrearPerro . '</p>';
        }
        ?>
    </div>

    <div class="bg-indigo-500 m-2 rounded-sm p-4 mb-10">
        <h2 class="text-white text-2xl mb-5">Filtrar por Cliente</h2>
        <form method="GET">
            <label class="text-white text-1xl mb-6 mr-7">Selecciona un cliente:</label>
            <select class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" name="dni_cliente">
                <option value="">Todos</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo $cliente['Dni']; ?>" <?php echo isset($_GET['dni_cliente']) && $_GET['dni_cliente'] == $cliente['Dni'] ? 'selected' : ''; ?>>
                        <?php echo $cliente['Nombre'] . " " . $cliente['Apellido1'] . " - " . $cliente['Dni']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button class="bg-indigo-900 rounded-sm p-2 text-white" type="submit">Filtrar</button>
            <a href="perros.php"><button class="bg-indigo-900 rounded-sm p-2 text-white" type="button">Quitar Filtro</button></a>
        </form>
        <!-- Si el cliente no tiene perros registrados mostramos error -->
        <?php
        if ($filtroActivo) {
            foreach ($perros as $key => $value) {
                if ($key === "message") {
                    echo '<p class="text-rose-400 mt-3">' . $value . '</p>';
                }
            }
        }
        ?>

    </div>

    <?php if ($perro_a_editar): ?>
        <div class="bg-indigo-500 m-2 rounded-sm p-4 mb-10">
            <h2 class="text-white text-2xl mb-5">Editar Perro</h2>
            <form method="POST" class="flex flex-wrap gap-5">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="hidden" name="id_perro" value="<?php echo $perro_a_editar['ID_Perro']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="dni_duenio" placeholder="DNI Dueño" required value="<?php echo $perro_a_editar['Dni_duenio']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="nombre" placeholder="Nombre" required value="<?php echo $perro_a_editar['Nombre']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="date" name="fecha_nacimiento" required value="<?php echo $perro_a_editar['Fecha_Nto']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="raza" placeholder="Raza" required value="<?php echo $perro_a_editar['Raza']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="number" name="peso" placeholder="Peso (kg)" required value="<?php echo $perro_a_editar['Peso']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="number" name="altura" placeholder="Altura (cm)" required value="<?php echo $perro_a_editar['Altura']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="observaciones" placeholder="Observaciones" value="<?php echo $perro_a_editar['Observaciones']; ?>">
                <input class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" type="text" name="numero_chip" placeholder="Número de Chip" required value="<?php echo $perro_a_editar['Numero_Chip']; ?>">
                <select class="bg-white rounded-sm text-rose-400 p-2 font-medium border-rose-600 placeholder:text-indigo-300 focus:outline-none focus:border-b-4 focus:rounded-b-lg" name="sexo" required>
                    <option value="Macho" <?php echo ($perro_a_editar['Sexo'] === 'Macho') ? 'selected' : ''; ?>>Macho</option>
                    <option value="Hembra" <?php echo ($perro_a_editar['Sexo'] === 'Hembra') ? 'selected' : ''; ?>>Hembra</option>
                </select>
                <button class="bg-indigo-900 rounded-sm p-2 text-white" type="submit" name="actualizar">Actualizar Perro</button>
                <button class="bg-rose-400 rounded-sm p-2 text-white" type="submit" name="actualizar"><a href="perros.php">Cancelar</a></button>
            </form>
            <?php
            if ($errorEditarPerro !== "") {
                echo '<p class="text-rose-400 mt-3">' . $errorEditarPerro . '</p>';
            }
            ?>
        </div>
    <?php endif; ?>
    <div class="bg-indigo-500 m-2 rounded-sm p-4">
        <h2 class="text-white text-2xl mb-5">Lista de Perros</h2>
        <?php if (!$filtroActivo || !empty($perros)): ?>
            <table class="w-full flex flex-col items-center">
                <tr class="flex gap-5 w-full mb-3">
                    <!-- <th class="w-[70px] text-white text-center">ID</th> -->
                    <th class="w-[120px] text-white text-center">Nombre</th>
                    <th class="w-[150px] text-white text-center">Raza</th>
                    <th class="w-[100px] text-white text-center">Nacimiento</th>
                    <th class="w-[100px] text-white text-center">Peso</th>
                    <th class="w-[60px] text-white text-center">Altura</th>
                    <th class="w-[160px] text-white text-center">Chip</th>
                    <th class="w-[80px] text-white text-center">Sexo</th>
                    <th class="w-[120px] text-white text-center">Dueño</th>
                    <th class="w-[120px] text-white text-center">Acciones</th>
                </tr>
                <?php foreach ($perros as $perro): ?>
                    <tr class="flex gap-5 w-full mb-3">
                        <!-- <td class="bg-indigo-300 rounded-sm p-2 text-center w-[70px] text-[#E5E5E5]"><?php echo $perro['ID_Perro']; ?></td> -->
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[120px] text-[#E5E5E5]"><?php echo $perro['Nombre']; ?></td>
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[150px] text-[#E5E5E5]"><?php echo $perro['Raza']; ?></td>
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[100px] text-[#E5E5E5]"><?php echo $perro['Fecha_Nto']; ?></td>
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[100px] text-[#E5E5E5]"><?php echo $perro['Peso']; ?> kg</td>
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[60px] text-[#E5E5E5]"><?php echo $perro['Altura']; ?> cm</td>
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[160px] text-[#E5E5E5]"><?php echo $perro['Numero_Chip']; ?></td>
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[80px] text-[#E5E5E5]"><?php echo $perro['Sexo']; ?></td>
                        <td class="bg-indigo-300 rounded-sm p-2 text-center w-[120px] text-[#E5E5E5]"><?php echo $perro['Dni_duenio']; ?></td>
                        <td class="flex justify-center items-center gap-2 w-[120px]">
                            <button class="bg-indigo-900 rounded-sm p-2 text-white w-[70px]"><a href="perros.php?editar=<?php echo $perro['ID_Perro']; ?>">Editar</a></button>
                            <form method="POST" class="inline">
                                <input type="hidden" name="id_perro" value="<?php echo $perro['ID_Perro']; ?>">
                                <?php if ($_SESSION['user_role'] !== 'AUXILIAR'): ?>
                                    <a class="bg-rose-400 rounded-sm p-2 text-white" href="?delete=<?= $perro["ID_Perro"] ?>" onclick="return confirm('¿Seguro que quieres eliminar este servicio?')">Eliminar</a>
                                <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </table>

</body>

</html>